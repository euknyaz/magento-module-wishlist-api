# Wishlist API

Adds an API to interact with the Magento2 wishlist.

## Getting Started

Install the module via composer

```
$ composer require "euknyaz/magento-module-wishlist-api: dev-master"
```

Enable the module

```
$ ./bin/magento module:enable Euknyaz_WishlistApi
```

Upgrade your Magento database schemas

```
$ ./bin/magento setup:upgrade
```

### Usage

The module adds six new API endpoints that allow you to interact with the Magento 2 wishlist.

You can define $customerId to request wishlist of specific user.
If there's no customer session available, the current customer is received through the customer token.

**GET** `/rest/V1/wishlist` - Get the wishlist for the current user.
**GET** `/rest/V1/customer/:customerId/wishlist` - Get the wishlist for the user identified by $customerId.
**PUT** `/rest/V1/wishlist/:sku` - Add product to wishlist of current user
**PUT** `/rest/V1/wishlist/customer/:customerId/:sku` - Add product to wishlist of specific user by $customerId
**DELETE** `/rest/V1/wishlist/:itemId` - Remove an item from current user wishlist.
**DELETE** `/rest/V1/wishlist/customer/:customerId/:itemId` - Remove an item from specific user wishlist.

### Examples


**GET** `/rest/V1/wishlist`

Get the wishlist for the current user.

**Example:**

```
$ curl -X GET http://magento.example.com/rest/V1/wishlist --header "Authorization: Bearer pbhercbtk6dd3eatf1pyx8jj45avjluu"
```

**PUT** `/rest/V1/wishlist/:sku`

Add the product to the users wishlist.

**Example:**

```
$ curl -X PUT http://magento.example.com/rest/V1/wishlist/24-MB01 --header "Authorization: Bearer pbhercbtk6dd3eatf1pyx8jj45avjluu"
```

**DELETE** `/rest/V1/wishlist/:itemId`

Remove an item from the users wishlist.

**Example:**

```
$ curl -X DELETE http://magento.example.com/rest/V1/wishlist/1 --header "Authorization: Bearer pbhercbtk6dd3eatf1pyx8jj45avjluu"
```

## License

MIT 
