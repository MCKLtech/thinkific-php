# thinkific-php

PHP bindings to the Intercom API

## Installation

This library requires PHP 7.1 and later

The recommended way to install thinkific-php is through [Composer](https://getcomposer.org):

This library is intended to speed up development time but is not a shortcut to reading the Thinkific documentation. Many endpoints require specific and required fields for successful operation. Always read the documentation before using an endpoint.

```sh
composer require mckltech/thinkific-php
```

## Clients

Initialize your client using your access token:

```php
use Thinkific\ThinkificClient;

$client = new ThinkificClient('XXXXAPIKEYXXXX', 'subdomain');
```

> - You can find your API Key by following the Thinkific API documentation: https://developers.thinkific.com/api/api-key-auth
>
> - For your subdomain, do not include .thinkific.com. For example, if your subdomain is example.thinkific.com, then you would use 'example' in your ThinkificClient set up. If you are using a custom domain, you should retrieve your Thinkific sub-domain from your Thinkific dashboard.

## Support, Issues & Bugs

This library is unofficial and is not endorsed or supported by Thinkific.

For bugs and issues, open an issue in this repo and feel free to submit a PR. Any issues that do not contain full logs or explainations will be closed. We need you to help us help you!

## API Versions

This library is intended to work with Version 1 of the Thinkific Public API

## Users

```php
/** List Users */
$client->users->list();

/** Find User By Email */
$client->users->findBy('example@thinkific.com');

/** Create A User */
$client->users->create(['email' => 'example@thinkific.com', 'first_name' => 'John', 'last_name' => 'Smith']);
```

## Enrollments

```php
/**
 * Create an Enrollment in a Course (ID: 1234) for User (ID: 1)
 * Very important! The date in Thinkific must be ISO 8601 */
 */

$client->enrollments->create([
    "course_id" => "1234",
    "user_id" => "1",
    "activated_at" => "2018-01-01T01:01:00Z",
    "expiry_date" => "2019-01-01T01:01:00Z"
]);

/** Expire the enrollment with ID 346712 */
$client->enrollments->expire(346712);

```

## Supported Endpoints

All endpoints follow a similar mechanism to the examples show above. Again, please ensure you read the Thinkific API documentation prior to use as there are numerous required fields for most POST/PUT operations.

- Bundles
- Categories
- Category Memberships
- Chapters
- Contents
- Coupons
- Courses
- Course Reviews
- Custom Profile Field Definitions
- Enrollments
- External Orders
- Groups
- Group Users
- Instructors
- Product Publish Request
- Products
- Promotions
- Users

## Exceptions

Exceptions are handled by HTTPlug. Every exception thrown implements `Http\Client\Exception`. See the [http client exceptions](http://docs.php-http.org/en/latest/httplug/exceptions.html) and the [client and server errors](http://docs.php-http.org/en/latest/plugins/error.html). If you want to catch errors you can wrap your API call into a try/catch block:

```php
try {
    $users = $client->users->list();
} catch(Http\Client\Exception $e) {
    if ($e->getCode() == '404') {
        // Handle 404 error
        return;
    } else {
        throw $e;
    }
}
```


