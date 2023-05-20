# imagegallery

Simple self hosted image gallery, allowing users to create an account and share their own images or browse what other people have uploaded.

## Dependancies
-Web server such as apache. <br>
-Postgresql.

## Installation
Either place the project folder or clone the repository into your server folder (ex: for apache, the default path is /var/www/html/

Connect to postgres <br>
`psql -U postgres`

Create a database called 'imagegallery' <br>
`postgres=# CREATE DATABASE imagegallery` <br>

Connect to the new databse <br>
`postgres=# \c imagegallery`

Import the SQL dump file into this new database. It is located in the SQL/ folder inside the project <br>
`imagegallery=# \i "local path to the dump file"`

Change the configuration variables located in the config file 'config.php to match your host system's postgres credentials and website folder path <br>
`$_dbhost = 'localhost';
 $_dbusername = 'postgres';
 $_dbport = '5432';
 $_dbpassword = 'postgres';
 $_dbname = 'imagegallery';
 
 $_path_access = '/var/www/html/imagegallery'`
