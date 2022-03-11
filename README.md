# addons-wp-headless

[![CircleCI](https://circleci.com/gh/mozilla/addons-wp-headless.svg?style=svg)](https://circleci.com/gh/mozilla/addons-wp-headless)

A WordPress plugin for the AMO blog.

## Usage

Install the plugin in the WordPress admin panel by uploading the zip file.

## Development

Important: you'll need [composer](https://getcomposer.org/) to install the project's dev dependencies.

### Running the test suite

This is a bit involved because there is no nice way to write "unit" tests with WordPress. We follow the recommended approach, which requires both a WordPress instance and MySQL database. The `bin/install-wp-tests.sh` script can be used to download and setup the WP instance as well as create the "test" database, which requires a local MySQL server, e.g. with Docker:

```
$ docker run --name mysql_addons_wp_headless -e MYSQL_ROOT_PASSWORD=pass -e MYSQL_DATABASE=addons_wp_headless -p 55001:3306 --rm mysql
```

Assuming you have a MySQL server running locally using the docker command above, run the following commands once:

```
# `5.6.2` is the WordPress version, use `latest` for the latest version or any
# other version if you like.
# `true` at the end of the command below skips the database creation since it is
# created when the docker container starts
$ ./bin/install-wp-tests.sh addons_wp_headless root pass '127.0.0.1:55001' 5.6.2 true
$ composer install
```

Then, you can run the test suite with PHPUnit:

```
$ ./vendor/bin/phpunit
```

### Build the plugin (zip file)

```
$ make
```

## License

This plugin is released under the Mozilla Public License Version 2.0. See the bundled [LICENSE](./LICENSE.txt) file for details.
