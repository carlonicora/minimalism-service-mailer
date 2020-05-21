# minimalism-service-mailer

**minimalism-service-mailer** is a service for [minimalism](https://github.com/carlonicora/minimalism) to send emails. 
It currently supports either [mandrillapp](https://mandrillapp.com) or [sendgrid](https://sendgrid.com).

## Getting Started

To use this library, you need to have an application using minimalism. This library does not work outside this scope.

### Prerequisite

You should have read the [minimalism documentation](https://github.com/carlonicora/minimalism/readme.md) and understand
the concepts of services in the framework.

### Installing

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```
$ composer require carlonicora/minimalism-service-mailer
```

or simply add the requirement in `composer.json`

```json
{
    "require": {
        "carlonicora/minimalism-service-mailer": "~1.0"
    }
}
```

## Deployment

One important difference between other minimalism sevices and minimalism-service-mailer is that the latter does not
return a mailer class from the ServicesFactory, but a `mailerServiceInterface`. The service automatically returns the
correct class depending on the required configuration (mandrillapp or sendgrid).

This service requires you to set up two parameters in your `.env` file in order to send email.

### Required parameters

```dotenv
#the mailing service password or private key
MINIMALISM_SERVICE_MAILER_PASSWORD=
```

### Optional parameters

```dotenv
#defines the type of services to use. Currently supported are `mandrillapp' and 'sendgrid`. It defaults to `mandrillapp`
MINIMALISM_SERVICE_MAILER_TYPE=  

#the username used to connect to the service. Not required if the service use a private key
MINIMALISM_SERVICE_MAILER_USERNAME=

#default sender email address
MINIMALISM_SERVICE_MAILER_SENDER_EMAIL=

#default sender name
MINIMALISM_SERVICE_MAILER_SENDER_NAME=
```

## Build With

* [minimalism](https://github.com/carlonicora/minimalism) - minimal modular PHP MVC framework
* [phpmailer/phpmailer](https://github.com/phpmailer/phpmailer)
* [sendgrid/sendgrid](https://github.com/sendgrid/sendgrid)

## Versioning

This project use [Semantiv Versioning](https://semver.org/) for its tags.

## Authors

* **Carlo Nicora** - Initial version - [GitHub](https://github.com/carlonicora) |
[phlow](https://phlow.com/@carlo)

# License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT) - see the
[LICENSE.md](LICENSE.md) file for details 

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)