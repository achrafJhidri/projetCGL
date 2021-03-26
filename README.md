### All about needed to run this project
- Technical Requirements, install:
  * PHP >=7.4 
  * Composer
  * MySQL or MariaDB (Phpmyadmin if you want)
  * Nodejs and npm or yarn
  * Symfony CLI (for dev)
 ***
- steps for run app
  * Go to the root of the project, execute : **composer install**
  * Then execute, **npm i** or **yearn install** and **npm run watch** (for dev)
  * finally, launch symfony server with the command : **symfony server:start**
 ***
- config Database 
  * go to .env file and provide your own db_user:db_password (notice: db_user default is root and db_password is empty)
  * execute : **php bin/console d:d:c**
  * then, execute: **php bin/console d:s:u --force**
  * finally, execute: **php bin/console doctrine:fixtures:load** (this command populates the database).
 ***
Notice: about Database, we use MySQL but you can use other, in this case you should provide the good data requirements.
  