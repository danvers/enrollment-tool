# What is this subscription system?

This is a simple registration tool for courses or other lists. It's based on the Nova Framework (formerly known as Simple MVC Framework, Version 2.2), which is a PHP 5.5 MVC system. 

## Documentation

Full docs & tutorials concerning the nova framework are available at [novaframework.com](http://novaframework.com)

For questions and hints please contact me at [pixelspace.org] (https://pixelspace.org)

##Requirements

 - Apache Web Server or equivalent with mod rewrite support.
 - PHP 5.5 or newer is required.
 - A MySql database is required for data storage and course management.

## Installation

1. Download the application.
2. Unzip the package.
3. Upload the framework files to your server. Normally the index.php file will be at your root.
4. Open app/Core/Config.example.php and set your base path (if the framework is installed in a folder the base path should reflect the folder path /path/to/folder/ otherwise a single / will do. and database credentials (if a database is needed). Set the default theme. When you are done, rename the file to Core/Config.php
5. Edit .htaccess file and save the base path. (if the framework is installed in a folder the base path should reflect the folder path /path/to/folder/ otherwise a single / will do.
6. import the enrollments.sql into your database and make sure to edit the user and pass (which is by default demo and demo).
7. Enjoy.

## Dependencies

 - php-export-data by Eli Dickinson (http://github.com/elidickinson/php-export-data)
 - ExportDataExcel, based on Excel XML code from Excel_XML (http://github.com/oliverschwarz/php-excel) by Oliver Schwarz
 - JQuery multiselect plugin based on Twitter Bootstrap (http://davidstutz.github.io/bootstrap-multiselect/)
 - The tinymce Editor (https://www.tinymce.com/)
 - Moment.js (http://momentjs.com/), (https://github.com/moment/moment) 
 - Bootstrap Datetimepicker by Jonathan Peterson (https://github.com/Eonasdan/bootstrap-datetimepicker)