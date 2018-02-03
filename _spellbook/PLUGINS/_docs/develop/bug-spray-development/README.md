# [Bug Spray](https://ivycat.com)

## Description

_Bug Spray_ is a WordPress plugin that contains a small suite of developer tools to make WordPress development and debugging easier and more fun.

This plugin includes:

1. [Composer](https://getcomposer.org/) - Manage PHP dependencies.
2. [Kint](http://raveren.github.io/kint/) - Helpful replacement for [var_dump()](http://php.net/manual/en/function.var-dump.php), [print_r()](http://php.net/manual/en/function.print-r.php) and [debug_backtrace()](http://php.net/manual/en/function.debug-backtrace.php).
3. [Whoops](https://github.com/filp/whoops) - Replaces default PHP orange error table with information you can actually use.

## Installation
[Composer](https://getcomposer.org/) must already be installed on your system.

1. Clone this project into a directory within `wp-content/plugins/`.
1. Use Terminal to `cd` into the plugin directory and run `composer install`.
1. Log into your WordPress site
1. Activate the plugin.

## Usage

Once activated you can use the following functions to help troubleshoot code:

* `d()` - Dumps data
* `ddd()` - Dumps data and dies

When your PHP code has an error, Whoops will whip the error codes into a more helpful, readable format to make debugging easier.

There's also a sandbox.php file in the `src` directory that you can use to try out code.

## Where to get help

* Currently, there is no official documentation. Docs for [Composer](https://getcomposer.org/), [Kint](http://raveren.github.io/kint/), and [Whoops](https://github.com/filp/whoops) can be found on their respective sites. 
* You can post issues here on Github.

## Contribution Guidelines
Feel free to contribute pull requests.

## Contributor List
* [sewmyheadon](https://github.com/sewmyheadon)
* [KnowTheCode](https://github.com/KnowTheCode)

## Credits, Inspiration, Alternatives
This plugin is inspired by Tonya Mork of [KnowTheCode](https://github.com/KnowTheCode), who has a great tutorial on building [this plugin](https://github.com/KnowTheCode/WordPress-Starter-Plugin-Lab) on [KnowTheCode.io](https://knowthecode.io/).

## License
GPL v2 license. See LICENSE for full details.