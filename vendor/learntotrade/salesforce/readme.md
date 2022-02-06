# Salesforce API

This is the Salesforce API for Learn-to-Trade.

## Installation

- Add `learntotrade\salesforce\SalesforceServiceProvider::class` to your app's service providers
- Set up the config values in your app's .env file (see config/salesforce.php for the required variables)

## Usage

To use, initiate the client and then pass this to one of the object classes. For example, to get a Person Account record:-

```php
$Client = new \learntotrade\salesforce\Client;
$Person = new \learntotrade\salesforce\Person($Client);
$data = $Person->get('0012X00001ponRzQAI');
```

### Create a Person Account

To create a new Person Account use the `create` method passing in the data you want the record creating with:-

```php
$Client = new \learntotrade\salesforce\Client;
$Person = new \learntotrade\salesforce\Person($Client);
$accountId = $Person->create([
    \learntotrade\salesforce\fields\PersonFields::FIRST_NAME => 'Joe',
    \learntotrade\salesforce\fields\PersonFields::LAST_NAME => 'Bloggs',
    \learntotrade\salesforce\fields\PersonFields::EMAIL => 'joe@example.com',
    \learntotrade\salesforce\fields\PersonFields::MOBILE => '07123 456789',
]);
```

Use the `PersonFields` class constants for the field keys so that these are easily maintained and any typos can be quickly spotted.

- `LAST_NAME` and `EMAIL` are required fields, if these are forgotten an exception will be thrown
- The returned value is the new account ID which will be a string token that we need to store for future calls on the account.

### Update a Person Account

To update an account pass the account ID and any data that wants updating:-

```php
$Client = new \learntotrade\salesforce\Client;
$Person = new \learntotrade\salesforce\Person($Client);
$accountId = $Person->update('0012X00001ponRzQAI', [
    \learntotrade\salesforce\fields\PersonFields::FIRST_NAME => 'Joseph',
    \learntotrade\salesforce\fields\PersonFields::HOME_CITY => 'Sheffield',
]);
```

Like creating accounts, use the `PersonFields` class constants for the field keys.

### Find a Person Account

To find an account by email address:-

```php
$Client = new \learntotrade\salesforce\Client;
$Person = new \learntotrade\salesforce\Person($Client);
$accounts = $Person->findByEmail('joe@example.com');
```

### Salesforce Objects

To get a full list of available Salesforce objects:-

```php
$Client = new \learntotrade\salesforce\Client;
$Objects = new \learntotrade\salesforce\Objects($Client);
$data = $Objects->getObjectsList();
```

You can get information about an object using `describe` and `fields`:-

```php
$Client = new \learntotrade\salesforce\Client;
$Person = new \learntotrade\salesforce\Person($Client);
$data = $Person->describe();
$fields = $Person->fields();
```

- `describe` contains details about the object including detailed descriptions of the object's fields
- `fields` returns a simple list of all the available field names for the object

## Caching

Some API calls only need to be made once or infrequently. For example, the API call to get an access token or to retrieve a picklist. We use caching for these calls via the `Cache` class defined in this repository. This is a wrapper for Laravel's `Cache` object that will tag cached values with `salesforce`.

```php
$cache = new \learntotrade\salesforce\Cache;
$cache->put('foo', 'bar', 60); // cache the value 'bar' to 'foo' for 60 minutes
$cache->get('foo'); // get 'foo' from the cache, should return 'bar'
$cache->flush(); // clears all the Salesforce cached items
```

As we are using tagging for the cache you must set up Laravel to use either Memcached or Redis (we plan to use Redis for LTT). If you don't set this up it will still work, but tags won't be used so flushing the cache will remove all cached items.

See the Laravel [documentation on caching](https://laravel.com/docs/5.7/cache) for further details.

## Developer Notes

- This repo uses PSR-2 coding standards.
- We're using class constants to define the object fields. These want to be used whenever we want to key by a field. If a new field is added it will want adding as a constant to the relevant object fields class. This will keep things well documented, ensure the code is easy to maintain if the field name changes and reduces the risk of typos in the HTTP request calls.
