<?php

namespace SevenLabLogging;

use GuzzleHttp\Client;

class SevenLabLogging
{
    const VERSION = '1.0.0';

    protected $client;
    protected $headers;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        if (!empty($config['token']) && !empty($config['uri'])) {
            $this->headers = [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $config['token'],
            ];

            $this->client = new Client([
                'base_uri' => $config['uri'],
            ]);
        }
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
        if (isset($this->headers)) {
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
            $data['env'] = app()->environment();
            $data['url'] = request()->fullUrl();
            $data['stacktrace'] = $exception->getTraceAsString();

            return $this->send($data);
        }
        return false;
    }

    protected function send($data)
    {
        return $this->client->post('logs', [
            'headers' => $this->headers,
            'form_params' => $data,
        ]);
    }

    public function sendFaildJob($data)
    {
        if (!isset($this->headers)) {
            return false;
        }

        return $this->client->post('failed-job', [
            'headers' => $this->headers,
            'form_params' => $data,
        ]);
    }
}
