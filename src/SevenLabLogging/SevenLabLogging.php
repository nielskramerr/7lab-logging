<?php

namespace SevenLabLogging;

use GuzzleHttp\Client;

class SevenLabLogging
{
    const VERSION = '1.0.0';

    protected $client;
    protected $headers;

    public function __construct($config)
    {
        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $config['token'],
        ];

        $this->client =  new Client([
            'base_uri' => $config['uri'],
        ]);
    }

    /**
     * Log an exception to 7lab-dashboard
     *
     * @param \Throwable|\Exception $exception The Throwable/Exception object.
     * @param array                 $data      Additional attributes to pass with this event.
     * @return string|null
     */
    public function captureException($exception, $data = null, $logger = null, $vars = null)
    {
        if ($data === null) {
            $data = array();
        }
        $message = $exception->getMessage();
        if (empty($message)) {
            $message = 'Not applicable';
        }

        if (method_exists($exception, 'getStatusCode')) {
            $code = $exception->getStatusCode();
        } else {
            $code = $exception->getCode();
            if ($code === 0) {
                $code = 500;
            }
        }

        $data['type'] = 'Laravel';
        $data['status_code'] = $code;
        $data['error'] = $message;
        $data['file'] = $exception->getFile();
        $data['line'] = $exception->getLine();
        $data['stacktrace'] = json_encode($exception->getTrace());

        return $this->send($data);
    }

    protected function send($data)
    {
        return $this->client->post('logs', [
            'headers' => $this->headers,
            'form_params' => $data
        ]);
    }
}
