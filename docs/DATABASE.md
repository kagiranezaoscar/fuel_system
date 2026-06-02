# Database Schema Explanation

The database is normalized around inventory, sale headers, sale detail lines, and stock movement audit records.

## Tables

- `users`: stores managers and customers. The `role` column drives access control.
- `fuel_types`: one row per fuel product, including current price and available stock.
- `fuel_sales`: one row per transaction or purchase request.
- `fuel_sale_details`: one or more fuel line items per sale.
- `stock_movements`: immutable audit records for inventory increases and decreases.
- `reports`: audit records showing what reports were generated and by whom.

## Integrity

Foreign keys connect sales to customers, details to sales/fuels, movements to fuels, and reports to users. Sale creation uses database transactions and row locks on `fuel_types` to avoid concurrent overselling.

