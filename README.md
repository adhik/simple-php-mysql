# Simple Example for PHP + MySQL

## Setup

### 1. Create a MySQL database/schema

You can use your database client app (ex. DataGrip) to create a new database,
or if you can't (probably due to incorrect permission), use the following steps in terminal (Ubuntu):

```
sudo mysql -u root -p
```
Enter your user's password first, then enter any password to use the mysql-client terminal app.
In the mysql-client terminal app:

```
create database <DBNAME>;
```
Please change `<DBNAME>` accordingly.

Then grant privileges to your db user:
```
grant all privileges on <DBNAME>.* to '<DBUSER>'@'localhost';
```
Please change `<DBNAME>` and `<DBUSER>` accordingly.

Then finally reload the database permissions:
```
flush privileges;
```

You can now exit the mysql-client terminal app.

### 2. Importing database objects

Make sure that you selected the newly created database (step 1 above) in your client app (ex. DataGrip)!
Clicking the Refresh button will help when the new database is not listed.

The run the following script in the Query Console editor:

```sql
DROP TABLE IF EXISTS `persons`;

CREATE TABLE `persons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
```

### 3. Configure database connection

Open `includes/db.php` file and change the variables inside according to your scenario.

- `$host` for the MySQL database server host name. it should be `localhost` if the database is in your local computer. 
- `$user` for the database username (ex. `<DBNAME>` from step 1 above).
- `$passwd` for password of the given database user (ex. `<DBUSER>` from step 1 above).
- `$schema` for the database name (from step 1 above)

### 4. Run 

We can use the built-in PHP server for running this application. 
Run the following command in the project folder:
```
php -S localhost:8000
```

the application should be available in http://localhost:8000