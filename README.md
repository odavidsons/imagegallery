# imagegallery

Simple self hosted image gallery, allowing users to create an account and share their own images or browse what other people have uploaded.

![image](https://github.com/odavidsons/imagegallery/assets/122760540/a75fa31a-9eca-4df3-acb8-14158c5d0e3a)

![image](https://github.com/odavidsons/imagegallery/assets/122760540/326271a7-5732-4ceb-8184-8a4061a39b8e)

## Dependencies
- Web server such as apache <br>
- Postgresql

## Installation
#1 - Either place the project folder or clone the repository into your server folder (ex: for apache, the default path is "/var/www/html/"

#2 - <b>Important!</b> Change the "uploads/" folder owner and permissions to your web server proccess owner, otherwide the files uploaded won't be able to be moved to this location. <br>
Explanation/Further instructions can be found in this answered thread: https://stackoverflow.com/questions/8103860/move-uploaded-file-gives-failed-to-open-stream-permission-denied-error <br><br>
Example for Apache service on Ubuntu: <br>
`imagegallery# chown www-data uploads/` <br>
`imagegallery# chmod 755 uploads/` <br><br>
It should look something like this <br>
![image](https://github.com/odavidsons/imagegallery/assets/122760540/d76a2ea3-7ee8-4969-aab5-8525db991681)

#3 - Connect to postgres <br><br>
`psql -U postgres`

#4 - Create a database called "imagegallery" <br><br>
`postgres=# CREATE DATABASE imagegallery` <br>

#5 - Connect to the new databse <br><br>
`postgres=# \c imagegallery`

#6 - Import the SQL dump file into this new database. It is located in the SQL/ folder inside the project <br><br>
`imagegallery=# \i "local path to the dump file"` <br><br>
Apache default: <br><br>
`imagegallery=# \i /var/www/html/imagegallery/SQL/imagegallery_db.sql`

#7 - Change the configuration variables located in the config file 'config.php to match your host system's postgres credentials and website folder path <br>
```php
$_dbhost = 'localhost';
$_dbusername = 'postgres';
$_dbport = '5432';
$_dbpassword = 'postgres';
$_dbname = 'imagegallery';

$_path_access = '/var/www/html/imagegallery'
``` 
<br>
You're done!
