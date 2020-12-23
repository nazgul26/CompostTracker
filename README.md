# Compost Tracker Application

This application was originally developed to track compost pickups / volumes for Rust Belt Riders.  It has been open sourced to help other compost startups get started.

https://www.gnu.org/licenses/gpl-3.0.en.html

# Features

* Tracking of commercial pickups.
* User Management for employees and customers.
* Basic Reporting for volumes and invoicing needs.

# Setup

In order to run the Compost Tracker Application you must have a Web Hosting provider.  This is web application and must have some server software installed such as PHP and a database.

The fastest way to get running will most likely be using a provider like Heroku.  With a service like Heroku, AWS, Azure you pay per time used on their servers.  Thus the pricing will scale with how much you and your users use the app.  Using Heroku could be a great way to try out the app and then you could later move it.  

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

To get updates of the application you will need to configure the 'Deploy' tab in Heroku to integrate with GitHub - https://devcenter.heroku.com/articles/github-integration

The second and very common way to run a PHP application is paying for hosting a traditional web hosting provider.  This would provide a fixed cost each month to run your application.  Most likely the basic level of hosting on many providers will be sufficient for many years of growing your business.  We would recommend SiteGround (https://www.siteground.com/) if you don't have a preference to start with.

### Steps -- [TBD]

## Setup for Local Development

To start development your need to have
    + PHP 7 (or higher) with ext-dom (sudo apt install php-xml)
    + MySQL with a local db user created.

Create a configuration file config/.env

with contents (modify to fit your needs):

```

export APP_NAME="CompostingTracker"
export DATABASE_NAME="dbname"
export DEBUG="true"
export APP_ENCODING="UTF-8"
export APP_DEFAULT_LOCALE="en_US"
export APP_DEFAULT_TIMEZONE="UTC"
export DATABASE_URL="mysql://db_user:db_password@localhost/${DATABASE_NAME}?encoding=utf8&timezone=UTC&cacheMetadata=true&quoteIdentifiers=false&persistent=false"
export SECURITY_SALT="--------------replace with random string---------------------------------------"
export LOGO_LETTERS="TBD"
export COMPANY_PHONE_NUMBER = "216-555-5555"
export COMPANY_ADDRESS = "555 Main St, Cleveland, OH, 44114, United States"
export COMPANY_FACEBOOK = "yourFaceBookName"
export COMPANY_EMAIL = "youremail@company.com";
export COMPANY_TWITTER = "twitterName";

```


