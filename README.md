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
    - [Country](#country)
        - [List all countries](#list-all-countries)
        - [Retrieve a country](#retrieve-a-country)
    - [Discount](#discount)
        - [List all discounts](#list-all-discounts)
        - [Retrieve a discount](#retrieve-a-discount)
    - Image
    - Order
    - Product
    - [Variant](#variant)
        - [List all variants](#list-all-variants)
        - [Retrieve a variant](#retrieve-a-variant)
    - [Zone](#zone)
        - [List all zones](#list-all-zones)
        - [Retrieve a zone](#retrieve-a-zone)

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
        "id": "26a1123f-4565-495c-8da5-8286a608a037",
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
        "id": "26a1123f-4565-495c-8da5-8286a608a037",
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

### Country

#### List all countries

```
GET /shop-api/countries
```

```
200 OK
{
    "data": [
        {
            "id": "a39aa166-a8e6-479c-a39f-81f78a303edb",
            "alpha2": "CA",
            "zone_id": "0be01f9d-60fc-41e8-8649-5fb3957345bf",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        },
        {
            "id": "489d804b-a6f6-454c-9996-d932d67f2041",
            "alpha2": "AU",
            "zone_id": "e557b951-4655-44f4-aaeb-a0cd42d63d58",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        },
        {
            "id": "8955f91d-e24c-4cb8-a03d-ae171064a8a9",
            "alpha2": "NZ",
            "zone_id": "e557b951-4655-44f4-aaeb-a0cd42d63d58",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        },
        {
            "id": "46d5ea86-0e59-4504-97c3-fd35de0bd6d1",
            "alpha2": "GB",
            "zone_id": "247a3a81-251c-4258-805f-09246c8270f2",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        },
        ...
    ]
}
```

#### Retrieve a country

```
GET /shop-api/countries/46d5ea86-0e59-4504-97c3-fd35de0bd6d1
```

```
200 OK
{
    "data": {
        "id": "46d5ea86-0e59-4504-97c3-fd35de0bd6d1",
        "alpha2": "GB",
        "zone_id": "247a3a81-251c-4258-805f-09246c8270f2",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```

### Discount

#### List all discounts

```
GET /shop-api/discounts?code=FEB20
```

```
200 OK
{
    "data": [
        {
            "id": "f0ada142-969d-4c66-8c9c-21bf3fd27fea",
            "name": "20% off your order (maximum £15)",
            "code": "FEB20",
            "percent": 20,
            "maximum": 1500,
            "limit": 10000,
            "variant_id": null,
            "started_at": "2019-02-4T00:00:00Z",
            "ended_at": "2019-02-10T23:59:59Z",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        }
    ]
}
```

#### Retrieve a discount

```
GET /shop-api/discounts/f0ada142-969d-4c66-8c9c-21bf3fd27fea
```

```
200 OK
{
    "data": {
        "id": "f0ada142-969d-4c66-8c9c-21bf3fd27fea",
        "name": "20% off your order (maximum £15)",
        "code": "FEB20",
        "percent": 20,
        "maximum": 1500,
        "limit": 10000,
        "variant_id": null,
        "started_at": "2019-02-4T00:00:00Z",
        "ended_at": "2019-02-10T23:59:59Z",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```

### Zone

#### List all zones

```
GET /shop-api/zones
```

```
200 OK
{
    "data": [
        {
            "id": "b3c9538d-fae9-4c35-ba8a-d3e448b13724",
            "name": "Europe",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        },
        {
            "id": "de6d8e01-ec98-42cb-8aa8-b924c953c894",
            "name": "North America",
            "created_at": "2019-02-01T03:45:27.612584Z",
            "updated_at": "2019-02-01T03:45:27.612584Z"
        },
        ...
    ]
}
```

#### Retrieve a zone

```
GET /shop-api/zones/b3c9538d-fae9-4c35-ba8a-d3e448b13724
```

```
200 OK
{
    "data": {
        "id": "b3c9538d-fae9-4c35-ba8a-d3e448b13724",
        "name": "Europe",
        "created_at": "2019-02-01T03:45:27.612584Z",
        "updated_at": "2019-02-01T03:45:27.612584Z"
    }
}
```
