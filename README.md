## Laravel RESTful explorer.

### For Laravel 4, please use the [v1.x branch](https://github.com/teepluss/laravel-explore/tree/v1.x)!

Explore is a RESTful explorer for [apiDoc](http://apidocjs.com/)
> This package will work after apiDoc installed.

![ScreenShot](https://raw.githubusercontent.com/teepluss/laravel-explore/master/public/screenshots/sample.png)

### Installation

- [Explore on Packagist](https://packagist.org/packages/teepluss/explore)
- [Explore on GitHub](https://github.com/teepluss/laravel-explore)

To get the lastest version of Theme simply require it in your `composer.json` file.

~~~
"teepluss/explore": "dev-master"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Once Theme is installed you need to register the service provider with the application. Open up `config/app.php` and find the `providers` key.

~~~json
'providers' => [
    ...
    'Teepluss\Explore\ExploreServiceProvider'

]
~~~

Publish config and asset using artisan CLI.

~~~shell
php artisan vendor:publish --provider="Teepluss\Explore\ExploreServiceProvider"
~~~

## Usage

Set up your config
~~~php
config/explore.php
~~~

then navigate to path

~~~php
http://domain.com/developers/explorer
~~~


## Support or Contact

If you have some problem, Contact teepluss@gmail.com

[![Support via PayPal](https://rawgithub.com/chris---/Donation-Badges/master/paypal.jpeg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9GEC8J7FAG6JA)