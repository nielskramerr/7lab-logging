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

Then run `7 a vendor:publish` to publish it's config files.

Don't forget to add the variables to your .env file and you're good to go ;)