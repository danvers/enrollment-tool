# What is this subscription system?

This is a simple registration tool for courses or other lists. It's based on the Nova Framework (formerly known as Simple MVC Framework, Version 2.2), which is a PHP 5.5 MVC system. 

## Documentation

Full docs & tutorials are available at [novaframework.com](http://novaframework.com)

##Requirements

 The framework requirements are limited

 - Apache Web Server or equivalent with mod rewrite support.
 - PHP 5.5 or greater is required

 Although a database is not required, if a database is to be used the system is designed to work with a MySQL database. The framework can be changed to work with another database type.

## Installation

1. Download the application
2. Unzip the package.
3. To run composer, navigate to your project on a terminal/command prompt then run 'composer install' that will update the vendor folder. Or use the vendor folder as is (composer is not required for this step)
Upload the framework files to your server. Normally the index.php file will be at your root.
4. Open app/Core/Config.example.php and set your base path (if the framework is installed in a folder the base path should reflect the folder path /path/to/folder/ otherwise a single / will do. and database credentials (if a database is needed). Set the default theme. When you are done, rename the file to Core/Config.php
5. Edit .htaccess file and save the base path. (if the framework is installed in a folder the base path should reflect the folder path /path/to/folder/ otherwise a single / will do.
