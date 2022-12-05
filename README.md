##  E-Commerce Shipping Challenge

This is a simple web application that calculates shipping dates for arbitrary products. Data associated with these products is stored in a MySQL database. The main focus of this project is to calculate when a product is to be shipped. This is determined by when the product was ordered, whether or not the product ships on weekends, and what holidays are observed by the product manufacturer (Mfr). 

When the app is running, a list of products is displayed. Included for each product is its name, quantity, whether it ships on weekends, the max shipping days and the ship date. A user may change the order date to be any valid date that they wish. By default, the Manufacturer ID is 1 for all products. This essentially means that holidays are not used in the calculation of the ship date. If a product has Manufacturer ID 2, then the product will not ship on federal holidays. New Manufacturers (Mfr's) and associated holidays can be added to configure what days to exclude from shipping certain products. The tables associated with this are Holidays, Manufacturers and Manufacturers_Holidays. Data manipulation may be done using PHPMyAdmin.

## Setup

Download the repository onto your machine:

`git clone https://github.com/CodebaseWes/laravel_webapp.git`

Navigate to the project directory:

`cd laravel_webapp`

If Docker Desktop is not installed on your machine, please install it from this [link](https://www.docker.com/products/docker-desktop/). Docker is a useful deployment tool that ensures that apps can be run successfully anywhere. Apps can run in containers which are similar to virtual machines. The app and its dependencies are installed onto a container, which can be run independent of the base architecture and configuration of the machine in which it is executed. Once Docker desktop is installed, execute the following command:

`docker compose up --build`

This builds the Docker image of the project and launches a container. Within this container are three sub-containers. 

- The Laravel App 
- A MySQL Database Server
- PHPMyAdmin 

It may take several minutes to build and run the containers the first time this command is executed. Subsequent builds will be faster due to caching.

Once the container is up and running. Navigate to http://localhost in your browser. The application will display an error indicating that a table has not been found. To fix the issue, seed the database by clicking the "Run Migrations" button displayed on the page. You will not need to do this for every build as data will be persisted in a docker volume.

![Illustration of Button](https://github.com/CodebaseWes/laravel_webapp/blob/master/seed_database_illustration.png?raw=true)

After refreshing the page, you should be good to go!

To work with the database, navigate to PHPMyAdmin located at http://localhost:7000 . No username or password is necessary; you should be logged into the database already.

## Alternative Setup

If running this as a Docker container is not convenient, you may run this project on a machine that has PHP and MySQL support. I cannot guarantee this will work because the app has specific dependency requirements. To see what those requirements are, see the [Dockerfile](https://github.com/CodebaseWes/laravel_webapp/blob/master/Dockerfile). Also, be sure to update the environment variables in `.env` to point to your database server. It is typically not good practive to commit this file, but for convenience and because this is a toy app, it is included in the repository. In addition, import [app.sql](https://github.com/CodebaseWes/laravel_webapp/blob/master/app.sql) into your database. 

Assuming that all the dependencies have been installed, you may run the app by executing the following commands:

`composer install`

`php artisan serve`

Navigate to http://localhost:8000 to view the application.
