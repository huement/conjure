## WP_Cubi
### WordPress stack for developers
========================================

STACK URL: [https://github.com/globalis-ms/wp-cubi](https://github.com/globalis-ms/wp-cubi)

> wp-cubi provides a modern stack and project structure to make professional web applications with WordPress.
> Built with Composer dependency manager and Robo task runner.

**Note: wp-cubi is under active development and is not a final product yet. You should not use it if you don't know PHP development and WordPress basics.**

------------------------------------------------------------------------------------------------------------

## Features

### General

* Environment-specific configuration
* Command-line administration with [wp-cli](http://wp-cli.org/)
* Optimized .htaccess generation (inspired by [html5-boilerplate](https://github.com/h5bp/server-configs-apache))
* Gitflow integration with Robo commands
* Automated `no-index` on non-production stages with [wpg-disallow-indexing](https://github.com/wp-globalis-tools/wpg-disallow-indexing)

### Security

* Better password encryption with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt)
* Deactivation of REST API and XML-RPC by default with [wpg-security](https://github.com/wp-globalis-tools/wpg-security)

### Debug and monitoring

* Standalone mail-trapping with [wpg-mail-trapping](https://github.com/wp-globalis-tools/wpg-mail-trapping)
* Debug and monitoring plugin suite with [query-monitor](https://fr.wordpress.org/plugins/query-monitor/) and [wp-crontrol](https://fr.wordpress.org/plugins/wp-crontrol/)

### Logs

* Logging system with [inpsyde/wonolog](https://github.com/inpsyde/Wonolog) and [monolog](https://github.com/Seldaek/monolog)

### wp-admin enhancement

* Cleaner wp-admin with [soberwp/intervention](https://github.com/soberwp/intervention)
* Environment info-box in admin-bar with [wpg-environment-info](https://github.com/wp-globalis-tools/wpg-environment-info)

### Additional functions

* Collection of simple WordPress-friendly functions with [globalis/wp-cubi-helpers](https://github.com/globalis-ms/wp-cubi-helpers)
