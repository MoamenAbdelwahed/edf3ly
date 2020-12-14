# Problem

Write a program that can price a cart of products, accept multiple products, combine offers, and display a total detailed bill in different currencies (based on user selection).

# Architecture
- Domain Driven Desing
- Service Oriented Architecure

# Design patterns used
- Repository
- Helper
- Service Provider
- Value object
- etc...

# Tools
- Lumen
- Doctrine ORM with yml mapping
- MySQL database

# Setup 
- create your .env file

- install dependencies
`composer install `

- create database tables
`cd Application/Src`
`php artisan doctrine:schema:update --force`

- run the project
`php -S localhost:8001 -t public`

# Test
You can hit a post request to 'http://localhost:8001/api/v1/cart'
with json body includes "productIds" array and optional "currency" string like "EGP"

# To do list
- enhance offers module to accep more types of offers
- unit testing
- seeds
- save users carts
- better response details when user request the cart price
