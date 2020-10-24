# Edfa3ly Back-end coding challenge
This is the required task, implemented and tested well to handle all cases and to be production ready

## Requirements
- PHP 7.*
- Mysql 3.*
- Composer
- Apache server to run the API localy (you can use Xampp or Wamp)
- 
## Installation
In order to install and run the project follow this commands
- `` git clone https://github.com/saadadel/edfa3ly-task.git ``
- `` cd to/project/path ``
- `` composer install ``
- `` php artisan migrate:fresh --seed ``
- to run test cases `` php artisan test ``
- `` php artisan serve ``
- use Postman to run the API **localhost:8000/api/cart** and send the array of products you wish to calculate the receipt for
![alt text](https://github.com/saadadel/edfa3ly-task/blob/master/storage/app/public/Capture.PNG?raw=true)

-**Note**: you can change currency by sending the currency code at the "currency" header variable
![alt text](https://github.com/saadadel/edfa3ly-task/blob/master/storage/app/public/Capture2.PNG?raw=true)


## the problem
managing e-commerce user cart by:
    1- adding products 
    2- handl sales like 10% sale on shoes for one month
    3- handl offers like buy 2 T-shirts and get 50% sale on one jacket 
    4- display the price depend on the selected user currency
    5- includ tax

## the solution
   1- make table for products having (name, price, sale_id) and calculating the receipt take the product names from REST API
    2- create table for sales having (starts_at, ends_at, percentage) with relation one-to-many with products table (one sale has many products)
    3-create table for offers having (buy_product_id, offer_product_id, buy_amount, offer_amount, and percentage)
    and ofr the above example we insert (t-shirt_id, jacket_id, 2, 1, 50.00)
    4-insert all prices in USD, take the user desired currency from the header, and integrate currency_layer service to get the latest rates to swap between currencies
    5-create taxes table with(title, precentage) and insert ('Value added tax', 14.00) and multiply the percentage with the subtotal price in receipt
    
# How it works

**ERD**

![alt text](https://github.com/saadadel/edfa3ly-task/blob/master/storage/app/public/edfa3ly-erd.png?raw=true)

    
**Algorithm**

    -Validate the entered data on form of array with names exits in products table
    - $products <- combine matched names under one array item with its amount
    - for $product <- $products
        -$subtotal +<- $product.price * $product.amount
    -calculate $tax by getting the tax entry percentage named 'Value added tax' from taxes table and multiply it by the $subtotal
    -$total <- $subtotal + $tax
    
    -calculate $sales by :
        - for $products as ($product, $amount)
            - if product has sale 
                -for $i <- $amount
                    -$sales.push($product sale percentage * $product price)
                    -$total -= $product sale percentage * $product price
                -end for
            -end if
        -end for
        
    -calculate $offers by:
        - for $products as ($product, $amount)
            -$offers = $product offers which has minimum buy amount <= $amount
            - for $offer <- $offers
                -if the cart have the offer sale-on product
                    -for $i <- 1 to (offer sale-on product amount) and (offer sale-from product's bought amount / offer sale-from product must buy amount)
                        -$offers.push(offer sale percentage * offer sale-on product price)
                        -$total -= offer sale percentage * offer sale-on product price
                    -end for
                -end if
            -end for
        -end for
        
    return $subtotal, $tax, $sales and $offers merged, and $total
    

## Design patterns used
This patterns are implemented at Laravel by default and I used it

 - MVC
 - Factory
 - Strategy
 - Provider
 - Repository
 - Facade

