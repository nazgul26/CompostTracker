# Compost Tracker Application

This application was originally developed to track compost pickups / volumes for Rust Belt Riders.  It has been open sourced to help other compost startups get started.

https://www.gnu.org/licenses/gpl-3.0.en.html

# Features

* Tracking of commercial pickups.
* User Management for employees and customers.
* Basic Reporting for volumes and invoicing needs.

## Setup for Local Development

To start development your need to have
    * PHP 7 (or higher) with ext-dom (sudo apt install php-xml)
    * MySQL with a local db user created.

Create a configuration file configs/.env

with contents (modify to fit your needs):
export APP_NAME="rbr"
export DEBUG="true"
export APP_ENCODING="UTF-8"
export APP_DEFAULT_LOCALE="en_US"
export APP_DEFAULT_TIMEZONE="UTC"
export SECURITY_SALT="--------------replace with random string---------------------------------------"
export COMPANY_PHONE_NUMBER = "216-555-5555"
export COMPANY_ADDRESS = "555 Main St, Cleveland, OH, 44114, United States"
export COMPANY_FACEBOOK = "yourFaceBookName"
export COMPANY_EMAIL = "youremail@company.com";
export COMPANY_TWITTER = "twitterName";
export DATABASE_URL="mysql://db_user:db_password@localhost/${APP_NAME}?encoding=utf8&timezone=UTC&cacheMetadata=true&quoteIdentifiers=false&persistent=false"



