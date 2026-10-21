# ATG Shop: CSCI 466 Final Project

A small online hardware store (screws, bolts, washers, nails, and so on) built on a MySQL database for NIU's CSCI 466 (Databases) course in fall 2021, as a group project with two classmates.

Customers browse products, add them to a cart, check out, and track their order. Employees see every order and the full inventory, and can update an order's status.

## Built with

PHP (PDO) · MySQL / MariaDB · HTML

## The database

Four tables, created by `createdb.sql`:

| Table | What it holds |
| --- | --- |
| `PRODUCT` | Each part, how many are in stock, and its price |
| `ORDER` | One order: status, shipping and payment details, total, notes |
| `ITEM_ORDER` | Which products are in which order, and how many (links `PRODUCT` and `ORDER`) |
| `CART` | What's in the cart right now |

The design is in the PDFs: `er_diagrm_handDrawn.pdf` (ER diagram), `ER_explained.pdf`, and `Relational Schema.pdf`.

## The pages

| Page | What it does |
| --- | --- |
| `index.php` | Product list; pick a part and quantity to add to the cart |
| `cartpage.php` | The cart |
| `checkoutpage.php` | Checkout: shipping and payment details |
| `ordersuccess.php` | Order confirmation |
| `ordertracking.php` | Look up an order by its number |
| `empIndex.php` | Employee view: all orders, inventory, and order status updates |

`library.php` has a shared helper that draws tables. `cart.php` is an early draft of the cart that isn't used.

## Run it

You need PHP with the PDO MySQL extension and a MySQL or MariaDB database.

1. The code was written for the course's database server. Point it at yours: change the `use` line at the top of `createdb.sql`, and the `host` and `dbname` in each page's `$dsn` connection line.
2. Create the tables, then load the sample data:
   ```
   mysql -u <user> -p <database> < createdb.sql
   mysql -u <user> -p <database> < genProducts.sql
   mysql -u <user> -p <database> < genOrders.sql
   ```
3. Put your database username and password in `creds.php`.
4. Start a local server and open http://localhost:8000:
   ```
   php -S localhost:8000
   ```

This is a course project, not a real store: it stores card details in plain text and builds some SQL queries by joining strings together, so don't use it with real data.
