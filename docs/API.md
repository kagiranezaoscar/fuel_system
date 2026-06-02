# API Documentation

All protected routes require a Sanctum bearer token.

## Register

`POST /api/register`

```json
{
  "name": "Customer One",
  "email": "customer@example.com",
  "username": "customer_one",
  "password": "password",
  "password_confirmation": "password"
}
```

Returns `201` with `user` and `token`.

## Login

`POST /api/login`

```json
{
  "email": "customer@example.com",
  "password": "password"
}
```

Returns `user` and `token`.

## Fuels

`GET /api/fuels`

Returns paginated fuel inventory.

`POST /api/fuels` manager only.

```json
{
  "fuel_name": "Petrol",
  "price_per_liter": 1650,
  "available_quantity": 5000,
  "description": "Premium petrol"
}
```

## Sales

`GET /api/sales`

Managers see all sales. Customers see their own sales.

`POST /api/sales` manager only.

```json
{
  "customer_id": 1,
  "payment_method": "cash",
  "status": "completed",
  "items": [
    {"fuel_id": 1, "liters": 20}
  ]
}
```

Sales are written in a database transaction and stock rows are locked before quantity is reduced.

## Reports

`GET /api/reports` manager only.

Returns report generation audit records.

