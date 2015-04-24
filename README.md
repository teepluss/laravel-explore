## Laravel RESTful explorer.

Explore is a RESTful explorer for [apiDoc](http://apidocjs.com/)
> This package will work after apiDoc installed.

![ScreenShot](https://raw.githubusercontent.com/teepluss/laravel-explore/master/public/screenshots/sample.png)

### Installation

- [Explore on Packagist](https://packagist.org/packages/teepluss/explore)
- [Explore on GitHub](https://github.com/teepluss/laravel-explore)

To get the lastest version of Theme simply require it in your `composer.json` file.

~~~
"teepluss/explore": "1.*@dev"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Once Theme is installed you need to register the service provider with the application. Open up `app/config/app.php` and find the `providers` key.

~~~
'providers' => array(

    'Teepluss\Explore\ExploreServiceProvider'

)
~~~

Publish config and asset using artisan CLI.

~~~
php artisan config:publish teepluss/explore

php artisan asset:publish teepluss/explore
~~~

## Usage

Set up your config
~~~php
/app/config/packages/teepluss/explore/explore.php
~~~

then navigate to path

~~~php
http://domain.com/developers/explorer
~~~


## Support or Contact

If you have some problem, Contact teepluss@gmail.com

[![Support via PayPal](https://rawgithub.com/chris---/Donation-Badges/master/paypal.jpeg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9GEC8J7FAG6JA)