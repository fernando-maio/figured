## Laravel Task - Figured

This is basic software to calculate the requested fertilizer price using a CSV file as a data resource. For this project I'm just reading the csv file not executing any changes inside. For a real scenario, I would update the file everytime the user apply a new request, or even better, I would save this on DB.
For this exercise, I created a basic Blade template with some Bootstrap, but no JS was used.
To validate the value typed in the template part, I only used an input type number with a minimum value of 1 to avoid nulls or 0, but there are several validations at the server level.


* New paths for the structure
    - app
        - Contracts: Interfaces
        - Providers
            - AppServiceProvider.php: Interfaces Bind
        - Services: Layer between Controller and Model (Business)
        - Requests: Request Validations

* Used Stack:
    - Ubuntu 22.04
    - PHP 8.0.2
    - Laravel 9.19

* Instalation:
    - Create .env file;
    - Run: composer install
    - To create a symbolic link in storage path: php artisan storage:link

* Routes: routes/web.php
    - Get:
        - index: /
    - Post:
        - apply: /

### The Exercise:
Your mission, should you choose to accept it, is to write a Laravel application that helps a user understand how much quantity of a product is available for use.
The application should display an interface with a button and a single input that represents the requested quantity of a product.

When the button is clicked, the interface should show either the $ value of the quantity of that product that will be applied, or an error message if the quantity to be applied exceeds the quantity on hand.

Note that product purchased first should be used first, therefore the quantity on hand should be the most recently purchased.

A csv file is attached that you should use as your data source.

Here is a small example of inventory movements:
a. Purchased 1 unit at $10 per unit
b. Purchased 2 units at $20 per unit
c. Purchased 2 units at $15 per unit
d. Applied 2 units

After the 2 units have been applied, the purchased units in 'a' have been completely used up. Only 1 unit from 'b' has been used, so the remaining inventory looks like this:

b. 1 unit at $20 per unit c. 2 units at $15 per unit
Quantity on hand = 3 Valuation = (1 * 20) + (2 * 15) = $50

### Thank You!