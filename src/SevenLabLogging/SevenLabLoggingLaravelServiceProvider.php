<?php
namespace SevenLabLogging;

use Exception;
use Illuminate\Support\ServiceProvider;

class SevenLabLoggingLaravelServiceProvider extends ServiceProvider
{
    /**
     * Abstract type to bind Sentry as in the Service Container.
     *
     * @var string
     */
    public static $abstract = '7lab-logging';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the configuration file
        $this->publishes(array(
            __DIR__ . '/config.php' => config_path(static::$abstract . '.php'),
        ), 'config');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(static::$abstract . '.config', function ($app) {
            // Make sure we don't crash when we did not publish the config file and the config is null
            return $app['config'][static::$abstract] ?: array();
        });

        $this->app->singleton(static::$abstract, function ($app) {
            $user_config = $app[static::$abstract . '.config'];

            $client = new SevenLabLogging($user_config);

            return $client;
        });

        $app = $this->app;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(static::$abstract);
    }
}
