# Gradebook

The main features are:
* Monitoring student's marks and absences data
* Automatic average mark calculations
* Admin account for easy statistics gathering
* Intuitive design
* Compatible with clasic CPANEL hostings

### Prerequisites
To run this application on a server, it will need to have installed:

```
PHP >= 7.0
MySQL Database
```

### Installing

To get this application up and running is pretty straightforward, these are the stepts that have to be taken:

```
#Clonning the repository
git clone https://github.com/dragomirt/gradebook
cp gradebook/* <apache root dir> #Standart Apache Root Dir: "/var/www/html/"
```

And the next thing to do is to import the template database structure and configure the application:
* Import the database through phpMyAdmin *(<url>/phpMyAdmin)* from db_structure 
* application/config/config.php
* application/config/database.php

## Built With

* [CodeIgniter](https://codeigniter.com/) - The web framework used
* [MySQL](https://www.mysql.com/) - Database
* [phpMyAdmin](https://www.phpmyadmin.net/) - Database UI

## Authors

* **Dragomir Țurcanu** - *Full Stack Dev* - [dragomirt](https://github.com/dragomirt)

## Acknowledgments

* Enjoy!
