# Task
## Description
* Create a Symfony - or use another PHP framework - to build a web application.
* Use Bootstrap as a design tool.
* The web application has to perform CRUD operations for an entity **User** having the following properties:
    * Email _(required)_
    * Name _(required)_
    * Roles _(required)_
* The user using the web application is able to list the users with sort option for name end email column - 
the first click sorts ascending, the second reverses the sort.
* For the CRUD operations use forms.
* Build the web application as if you are starting to develop a system of 500 entities.

## Tips and clarifications
* You can use SQL database or TXT files to store the data (e.g. in JSON format).

# Installation
You can run this project locally by using Homestead. 

## Install VirtualBox and Homestead
Check the following instructions:
[https://laravel.com/docs/8.x/homestead#installation-and-setup](https://laravel.com/docs/8.x/homestead#installation-and-setup)

## Clone the repository
Create a new directory on your machine where you're going to store the current project.

```
mkdir /PATH_TO_PROJECT
```
 
Go inside the directory and clone the project.

```
cd /PATH_TO_PROJECT
git clone -b build-web-application https://github.com/pavel-tashev/laravel-bootstrap-crud-entity.git .
```

## Configure Homestead
Check the following instructions: 
[https://laravel.com/docs/8.x/homestead#configuring-homestead](https://laravel.com/docs/8.x/homestead#configuring-homestead)

In addition, below you can find configurations I used to set up the project.

Open the directory where Homestead is located and open Homestead.yaml configuration file. Here is an example 
configuration that you can use:

```
...

folders:    
    - map: /PATH_TO_PROJECT
      to: /home/vagrant/project

sites:    
    - map: project.test
      to: /home/vagrant/project/public
      
database:
    - project
...
```
After updating the Homestead.yaml file, be sure to re-provision the machine by executing the following command:
```
vagrant reload --provision
```

## Hosts file
Open the _hosts_ file and add the following line of code at the very bottom where IP_ADDRESS should match the ip address 
from Homestead.yaml file.
```
IP_ADDRESS project.test
```
Save and close the file.

## Configure the web application
Open the folder where Homestead is located and type the following command in the Terminal to run Homestead:
```
vagrant up
```

Log in to the virtual machine:
```
vagrant ssh
```

Install the required package _(make sure you have composer installed)_:
```
composer update
```

Copy .env.example and set a new value to APP_KEY parameter:
```
cp .env.example .env
php artisan key:generate
```

Open .env file and change the following lines:
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

to:

```
DB_HOST=localhost
DB_PORT=33060
DB_DATABASE=project
DB_USERNAME=homestead
DB_PASSWORD=secret
```

The username "homestead" and the password "secret" are default value provided by Homestead.

Build database and seed with data:
```
php artisan migrate:refresh --seed
```

To run tests:
```
php artisan test
```



# Run the project
Open the Terminal, access the directory where Homestead is located and type the following command:
```
vagrant up
```

Open your web browser and type _project.test_ to access the project.

# Stop Homestead
Open the Terminal, access the directory where Homestead is located and type the following command:
```
vagrant halt
```

# Useful
## Rebuild the database and populate with fresh data
```
php artisan migrate:refresh --seed
```

## Run tests
```
php artisan test
```
