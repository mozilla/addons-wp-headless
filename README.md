# addons-wp-headless

[![CircleCI](https://circleci.com/gh/mozilla/addons-wp-headless.svg?style=svg)](https://circleci.com/gh/mozilla/addons-wp-headless)

A WordPress plugin for the AMO blog.

## Usage

Install the plugin in the WordPress admin panel by uploading the zip file.

## Development

Important: you'll need [composer](https://getcomposer.org/) to install the project's dev dependencies.

### Running the test suite

This is a bit involved because there is no nice way to write "unit" tests with WordPress. We follow the recommended approach, which requires both a WordPress instance and MySQL database. The `bin/install-wp-tests.sh` script can be used to download and setup the WP instance as well as create the "test" database, which requires a local MySQL server.

Assuming you have a MySQL server running locally (for instance a Docker container accessible at `127.0.0.1:55001`), run the following commands once:

```
$ ./bin/install-wp-tests.sh test root '' '127.0.0.1:55001' 5.7.1 true
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
