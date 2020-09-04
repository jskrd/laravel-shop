# laravel-shop (work in progress)

![test](https://github.com/jskrd/laravel-shop/workflows/test/badge.svg?branch=master)

## Contents

- [Contents](#contents)
- [About](#about)
- [Database](#database)
    - [Entity-Relationship Diagram](#entity-relationship-diagram)
- [REST API](#rest-api)
    - [Address](#address)
        - [Create an address](#create-an-address)
        - [Retrieve an address](#retrieve-an-address)
        - [Update an address](#update-an-address)
        - [Delete an address](#delete-an-address)
    - [Basket](#basket)
        - [Create a basket](#create-an-basket)
        - [Retrieve a basket](#retrieve-an-basket)
        - [Update a basket](#update-an-basket)
        - [Delete a basket](#delete-an-basket)

## About

A package for Laravel based projects providing a shop web API.

## Database

### Entity-Relationship Diagram

![Image of Entity-Relationship Diagram](er-diagram.png)

## REST API

### Address

#### Create an address

```
POST /shop-api/addresses
{
    "name": "Lysanne Durgan",
    "street1": "86897 Ebony Park",
    "street2": "Suite 451",
    "locality": "South Antoniabury",
    "region": "South Carolina",
    "postal_code": "33547",
    "country": "US",
    "email": "lysanne.durgan@example.com",
    "phone": "1-594-781-8825"
}
```

```
201 Created
{
    "data": {
        "id": "5384d0d7-d372-42c2-8f41-8a0f6f3ee023",
        "name": "Lysanne Durgan",
        "street1": "86897 Ebony Park",
        "street2": "Suite 451",
        "locality": "South Antoniabury",
        "region": "South Carolina",
        "postal_code": "33547",
        "country": "US",
        "email": "lysanne.durgan@example.com",
        "phone": "1-594-781-8825",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```

#### Retrieve an address

```
GET /shop-api/addresses/5384d0d7-d372-42c2-8f41-8a0f6f3ee023
```

```
200 OK
{
    "data": {
        "id": "5384d0d7-d372-42c2-8f41-8a0f6f3ee023",
        "name": "Lysanne Durgan",
        "street1": "86897 Ebony Park",
        "street2": "Suite 451",
        "locality": "South Antoniabury",
        "region": "South Carolina",
        "postal_code": "33547",
        "country": "US",
        "email": "lysanne.durgan@example.com",
        "phone": "1-594-781-8825",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```

#### Update an address

```
PUT /shop-api/addresses/5384d0d7-d372-42c2-8f41-8a0f6f3ee023
{
    "name": "Elliot Moore",
    "street1": "0 Morgan Cove",
    "street2": "Flat 43",
    "locality": "South Johnshire",
    "region": "Peebleshire",
    "postal_code": "BL7 8BW",
    "country": "GB",
    "email": "elliot.moore@example.com",
    "phone": "08455 296005",
}
```

```
200 OK
{
    "data": {
        "id": "5384d0d7-d372-42c2-8f41-8a0f6f3ee023",
        "name": "Elliot Moore",
        "street1": "0 Morgan Cove",
        "street2": "Flat 43",
        "locality": "South Johnshire",
        "region": "Peebleshire",
        "postal_code": "BL7 8BW",
        "country": "GB",
        "email": "elliot.moore@example.com",
        "phone": "08455 296005",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:58:51.612584Z"
    }
}
```

#### Delete an address

```
DELETE /shop-api/addresses/5384d0d7-d372-42c2-8f41-8a0f6f3ee023
```

```
200 OK
{
    "data": {
        "id": "5384d0d7-d372-42c2-8f41-8a0f6f3ee023",
        "name": "Elliot Moore",
        "street1": "0 Morgan Cove",
        "street2": "Flat 43",
        "locality": "South Johnshire",
        "region": "Peebleshire",
        "postal_code": "BL7 8BW",
        "country": "GB",
        "email": "elliot.moore@example.com",
        "phone": "08455 296005",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:58:51.612584Z"
    }
}
```

### Basket

#### Create a basket

```
POST /shop-api/baskets
{
    "billing_address_id": null,
    "delivery_address_id": null
    "discount_id": null,
}
```

```
201 Created
{
    "data": {
        "id": "26a1123f-4565-495c-8da5-8286a608a037,
        "subtotal": 5235,
        "discount_amount": 0,
        "delivery_cost": 0,
        "total": 5235,
        "billing_address_id": null,
        "delivery_address_id": null
        "discount_id": null,
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```

#### Retrieve a basket

```
GET /shop-api/baskets/26a1123f-4565-495c-8da5-8286a608a037
```

```
200 OK
{
    "data": {
        "id": "26a1123f-4565-495c-8da5-8286a608a037,
        "subtotal": 5235,
        "discount_amount": 0,
        "delivery_cost": 0,
        "total": 5235,
        "billing_address_id": null,
        "delivery_address_id": null
        "discount_id": null,
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```

#### Update a basket

```
PUT /shop-api/baskets/26a1123f-4565-495c-8da5-8286a608a037
{
    "billing_address_id": "c82509df-f5f5-4665-ad1d-b70ed4675246",
    "delivery_address_id": "a16525ae-fd54-4e73-9704-f9872bdcb7c5"
    "discount_id": "voluptatem",
}
```

```
200 OK
{
    "data": {
        "id": "26a1123f-4565-495c-8da5-8286a608a037",
        "subtotal": 5235,
        "discount_amount": 500,
        "delivery_cost": 826,
        "total": 5561,
        "billing_address_id": "c82509df-f5f5-4665-ad1d-b70ed4675246",
        "delivery_address_id": "a16525ae-fd54-4e73-9704-f9872bdcb7c5"
        "discount_id": "voluptatem",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:58:51.612584Z"
    }
}
```

#### Delete a basket

```
DELETE /shop-api/baskets/26a1123f-4565-495c-8da5-8286a608a037
```

```
200 OK
{
    "data": {
        "id": "26a1123f-4565-495c-8da5-8286a608a037",
        "subtotal": 5235,
        "discount_amount": 500,
        "delivery_cost": 826,
        "total": 5561,
        "billing_address_id": "c82509df-f5f5-4665-ad1d-b70ed4675246",
        "delivery_address_id": "a16525ae-fd54-4e73-9704-f9872bdcb7c5"
        "discount_id": "voluptatem",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:58:51.612584Z"
    }
}
```
