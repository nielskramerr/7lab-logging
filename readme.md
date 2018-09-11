## About this package

Add the following repository to the composer.json of your project
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/nielskramerr/7lab-logging.git"
    }
]
```
After this run `composer require "7lab/7lab-logging:dev-master"` to install the package

Then run `7 artisan vendor:publish --provider="SevenLabLogging\SevenLabLoggingLaravelServiceProvider"` to publish it's config files.

And add the following code to the `report` function in `Exceptions/Handler.php` to catch the exceptions and send them to our dashboard

```
if (app()->bound('7lab-logging')) {
    app('7lab-logging')->captureException($exception);
}
```

Don't forget to add the variables to your .env file and you're good to go ;)
