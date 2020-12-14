That is a base project DDD With Doctrine Service Lumen 5.3 and Doctrine.
 
A Microservice for register Petshop companies, managers and customers.
- The Companies are registred if their CNPJ belongs to the interest range.
- If a company is approved the service stores it's localization coordinates and sends a welcome email.
- All the login proccess relies uppon JWT Tokens.

After Cloning the project 

# Installing Composer Components 

`cd dev-api `

`composer install `



# Setup Database and seed data 

(Create Database Locally Name it on .env File)

`cd Application/Src`

`php artisan doctrine:schema:update --force`

`php artisan db:seed --class=DatabaseSeeder`



# Running the project 

`cd Application/Src`


`php -S localhost:8001 -t public`


# project Infrastructure 

Working On it !

