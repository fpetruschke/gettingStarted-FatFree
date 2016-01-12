<style>
body { 
    margin: 80px; 
    font-family: helvetica; 
    background-color: lightgrey;
    }

</style>

# gettingStarted FatFree

Setting up a new project can always be a little exhausting since there are so many tiny configuration steps to go through.  

If you skip one and don't know what you're doing, you're lost pretty easily.  

This project is meant to lead you to set up a working environment for using PHP Fat Free Framework.  

It is simple, it is fetherlight and makes a lot of fun.

As always: there a lot of ways to get where you want to go. This is just my way of getting into it.  

Have fun.


>_**Note**: Some chapters - e.g. the structuring of your application - are highly individual. Just try to comprehend my steps but then just go ahead and do whatever you want._

>_**Info**: for writing an own README.md like this, following link might be helpful: [https://enterprise.github.com/downloads/en/markdown-cheatsheet.pdf](https://enterprise.github.com/downloads/en/markdown-cheatsheet.pdf)_

--------

**Further Info**  

Please also note following sources for getting started or for getting detailled help:  

* [Official Fat Free Framework Documentation](http://fatfreeframework.com/user-guide)

* [Fatfree PHP Framework Youtube-Tutorials by takacsmark](https://www.youtube.com/watch?v=R-ydcTTrR5s&list=PLX0Ak4vUBQfClFDicUaSfm-urMi_kt3cg)


--------


# INDEX

## Setting up the environment

> In these chapters it's all about turning screw to the right. I'd suggest to not skip the following chapters since they save a lot of time and energy.

[1.Composer](#1composer)  

[2. FatFreeFramework](#2fatfreeframework)  

[3. .htaccess](#3htaccess)  

[4. apache2 Config](#4apache2config)  

[5. mod_rewrite](#5mod_rewrite)  

[6. Structure I](#6structurei)  

## Creating first functionality

> Now comes first functionality. You will create your first routes and work with a template

[7. index.php](#7indexphp)

[8. Permissions](#8permissions)

[9. FirstVisit](#9firstvisit)

[10. Structure II](#10structureii)

[11. First Controllers And Routes](#11firstcontrollersandroutes)

[12. AnotherVisit](#12anothervisit)

## Working with a Database

> Again: Dirty work. I always think it's a little mess to configure database connections work properly.But you will learn how to set up a database and use it in your application.

[13. Database Setup Preparation](#13databasesetuppreparation)

[14. Database Setup](#14databasesetup)

[15. App DBSetup](#15appdbsetup)

[16. Visit and Info](#16visitandinfo)

[17. Adding functionality to model](#17addingfunctionalitytomodel)

[18. refactoring](#18refactoring)

[19. arrays in templates](#19arraysintemplates)

[20. Joins](#20joins)


[Conclusion](#conclusion)




--------


#1.Composer

Make sure to have composer installed: `$ composer --version`

If "composer" is not known to your system install it:

1. `curl -sS https://getcomposer.org/installer | php`
2. `mv composer.phar /usr/local/bin/composer` (you might need sudo)
3. `cd /path/to/your/working/dir && composer --version`

When composer is installed continue...

--------

#2.FatFreeFramework

Change to the directory of your new F3-project (let's say it's in `/var/www/test/` ).

Execute following command: `$ composer require bcosca/fatfree`

(more versions on [https://packagist.org/packages/bcosca/fatfree](https://packagist.org/packages/bcosca/fatfree))

Then execute `composer update`

--------

#3..htaccess

You might have to create the .htaccess under your project root (where also the index.php will be located).

It should contain following content (**make sure you set the correct root directory for your project**):

```
RewriteEngine On
RewriteBase /test/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule .* index.php [L,QSA]

```

--------

#4.apache2Config

You might need to set the correct document root in your apache2 config:
`sudo nano /etc/apache2/conf`

Make sure following entries are set up properly:  
`sudo nano /etc/apache2/apache2.conf`

**You can outline existing configuration using '#'! You might want to keep the old config.**

**Make sure you use the correct root dir!**

```

DocumentRoot "/var/www/"
<Directory "/var/www/">
        Options -Indexes +FollowSymLinks +Includes
        AllowOverride All
        Require all granted
</Directory>


```

Then run `sudo service apache2 restart` for using the above configuration.

--------

#5.mod_rewrite

Use following command `cd /etc/apache2/mods-enabled && ll` for searching after following entry:  

'rewrite.load' (it should be a symbolic link)  

If it's not in there use following commands to install the mod and restart apache:

1. `sudo a2enmod rewrite`
2. `sudo service apache2 restart`

--------

#6.StructureI

You could adapt following dir structure (F = file, D = directory:  

```
F index.php  
F .htaccess  
F composer.json  
F composer.lock  
F README.md  
D vendor/  
D app/  
D | config/  
F | |  config.ini  
F | |  routes.ini  

```

Add the two files "config.ini" and "routes.ini" into the `app/config/`  

--------

#7.index.php

Now create a new .php-file in your projects' root: the **index.php**  

It should contain following information:  

```php

<?php

// following four lines must be included for routing
require ("vendor/autoload.php");
$f3 = \Base::instance();
$f3->config("app/config/config.ini");
$f3->config("app/config/routes.ini");

//example route
$f3->route('GET /brew/@count',
    function($f3) {
        echo $f3->get('PARAMS.count').' bottles of beer on the wall.';
    }
);

// you absolutely MUST use the 'run'-method to get things going!
$f3->run();


```

--------

#8.Permissions

This is always a wiry thing.   

Set the permission of your project root dir: `sudo chmod -R 777 /path/to/dir/`  

You might have to reconfigure the permissions later again. If not only for safety purposes.

But for now we just keep it simple and put it like that.

--------

#9.FirstVisit

Have an eye on your live-log: `sudo tail -f /var/log/apache2/error.log`  

There you can find information if your project is still misconfigured.  
Keep that console window open.  

**Now** open your browser and go to `localhost/test/gettingStarted/`   
:tada: Voíla! :tada:

--------

#10.StructureII

Let's expand our app structure like following:  
(_Note: This is just, how I like it. You can do whatever you want. But beware: You must adjust your routes._)  

```
F index.php  
F .htaccess  
F composer.json  
F composer.lock  
F README.md  
D vendor/  
D tmp/  
D app/  
D | config/  
F | |  config.ini  
F | |  routes.ini  
D | MVC/  
D | |  model/  
D | |  view/  
D | |  controller/  
D | web/  
D | |  css/  
D | |  js/  
D | |  img/  
D | log/  
F | |  activities.log  

```

--------

#11.FirstControllersAndRoutes

First of all let's take care of the debugging:  

Go into you empty `app/config/config.ini` and add following code:   

```ini

[globals]
;#############################################################
;File for configuring some global variables of the application
;#############################################################

;setting debug level (0=off, 3=max)
DEBUG=3

```

Then go into your `app/config/routes.ini` and add the following routes:

```ini

[routes]
;#############################################################
; File for configuring the routes of the application
;#############################################################

; GETs
GET /=MainController->render
GET /about=MainController->renderAbout

; POSTs

```

### Now create a template inside `app/MVC/View/` and call it: `layout.html`

```html

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>gettinStarted</title>
        <link rel="shortcut icon" href="favicon.ico" >
        <link rel="icon" href="img/animated_favicon.gif" type="image/gif" >
        <style>
        </style>
    </head>
    
    <body>
        <div>
            <h1>gettingStarted</h1>
            <p>Fat Free PHP Framework</p>
            <p>Hello {{ @name }} !</p>
        </div>
    </body>
</html>

```

### Now update your `app/config/config.ini` again and add following lines:  

```ini

;setting base dir for templates
UI=app/MVC/View/

```


### Now create two files in the `app/MVC/Controller/`:  

* Controller.php  

* MainController.php  

Put the following content in there:  

```php

<?php
class Controller {

    // function is called before every single routing!
    function beforeroute() {
    
    }

    // function is called after every single routing!
    function afterroute() {

    }
}




```


```php

<?php

class MainController extends Controller {

    function render($f3) {
        // setting a new global variable
        $f3->set('name', '"Your name could be here"');
        // instantiating new template object
        $template = new Template();
        echo $template->render('layout.html');
    }

    function renderAbout($f3) {
        // initialisation and definition of the path variable for the README
        $filePath = 'README.md';
        // read the file content
        $fileContent = $f3->read($filePath); // read file contents
        // render the content as a Mardown instance
        echo \Markdown::instance()->convert($fileContent);
    }

}

```

### Let's clean up our `index.php` file:

```php

<?php

// following four lines must be included for routing
require ("vendor/autoload.php");
$f3 = \Base::instance();
$f3->config("app/config/config.ini");
$f3->config("app/config/routes.ini");

$f3->run();

```

### Edit the `app/config/config.ini` and add following lines:  

```ini

; add your controller to the autoloading , more addable by setting pipe '|' in between
AUTOLOAD=app/MVC/Controller/

```

--------

#12.AnotherVisit

First make sure you use `sudo chmod -R 777 /path/to/your/project/` for setting permissions.  

Sind we added a lot of new directories and a few files, the default permissions might crash your app.  

Again: have an eye on your live-log: `sudo tail -f /var/log/apache2/error.log`    

Keep that console window open.  

**NOW** open your browser and go to `localhost/yourDirNameHere/gettingStarted/`   

**THEN** edit the url and change it to `localhost/yourDirNameHere/gettingStarted/about`  

--------


#13.DatabaseSetupPreparation

Now that all is up and running, we can create a database and manage it's connection to our application.

We then can read from and write into the database from our application.

First of all: there are many database management systems out there. 

For this project I'm using MySQL because it's the widespread dbms and you always find a solution for your problems.

Also you usually have it already installed when installing LAMP or XAMPP.

You might prefer another one.


For managing your databases it is easy to use the MySQLWorkbench. 

If you're runnin Ubuntu OS you can download it via the Ubuntu Software Center.

Otherwise you can download it **[here](http://www.mysql.de/products/workbench/)**.

You can find its' codumentation **[here](http://dev.mysql.com/doc/workbench/en/)**

In the MySQL Workbench you can create a new MySQL connection.

For this project let's just use a local MySQL server and use an according connection (127.0.0.1:3306)



--------

#14.DatabaseSetup

**Create a database** (aka schema) "gettingStarted" with default collation "utf8_general_ci":

```sql

CREATE SCHEMA `gettingStarted` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

```

**Add a new user** that only has (full) access to this database:

(In the workbench it's under "Users and Privileges" and then "Add account" in the lower left corner of the main window)

* Login Name: gSAdmin

* Authentication Type: Standard

* Limit Connectivity to Hosts: localhost

* Password: 1gettingstarted!


**Set privileges** of the created user:

We only want that user to have access to our created "gettingStarted" db.

In the workbench it's the tab "schema privileges"; click on "add entry" and then select our database from the list.

After that you can select "ALL" (you can ignore the GRANT OPTION). Click apply and you're ready to go.


**Add tables** to the database:

```SQL

  CREATE TABLE `gettingStarted`.`messages` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `type` INT NOT NULL,
    `message` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`));
  
  CREATE TABLE `gettingStarted`.`message_types` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `shorttitle` VARCHAR(45) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`));
    
  ALTER TABLE `gettingStarted`.`messages` 
  ADD INDEX `fk_type_idx` (`type` ASC);
  ALTER TABLE `gettingStarted`.`messages` 
  ADD CONSTRAINT `fk_type`
    FOREIGN KEY (`type`)
    REFERENCES `gettingStarted`.`message_types` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

```

**Fill in data** into created tables

```SQL

INSERT INTO `gettingStarted`.`message_types` (`shorttitle`, `title`) VALUES ('INF', 'Information');
INSERT INTO `gettingStarted`.`message_types` (`shorttitle`, `title`) VALUES ('ERR', 'Error');
INSERT INTO `gettingStarted`.`message_types` (`shorttitle`, `title`) VALUES ('PROC', 'Process');
INSERT INTO `gettingStarted`.`message_types` (`shorttitle`, `title`) VALUES ('WARN', 'Warning');

INSERT INTO `gettingStarted`.`messages` (`type`, `message`) VALUES ('1', 'This is an Information. Please note this information.');
INSERT INTO `gettingStarted`.`messages` (`type`, `message`) VALUES ('2', 'This is an Error. The application threw an error.');
INSERT INTO `gettingStarted`.`messages` (`type`, `message`) VALUES ('3', 'This is a Process. The application processes something.');
INSERT INTO `gettingStarted`.`messages` (`type`, `message`) VALUES ('4', 'This is a Warning. The application might crash.');

```

--------

#15.AppDBSetup

Now that we have created a database with a new user, two tables and a few example data we have to expand our app:

**Extend the config.ini** under `app/config/config.ini`; add following lines:

```ini

; database settings
devdb="mysql:host=127.0.0.1;port:3306;dbname=gettingStarted"
devdbusername="gSAdmin"
devdbpassword="1gettingstarted!"

```

**Extend the Controller.php** in `app/MVC/Controller/Controller.php` and add following attributes and the contructor:

```php

<?php

/**
     * @var Object  The F3 object
     */
    protected $f3;

    /**
     * @var Object  The database object
     */
    protected $db;

    function __construct() {

        // setting the f3 instance and make it useable
        $f3 = Base::instance();
        $this->f3 = $f3;

        // setting the db connection and make it useable
        $db = new DB\SQL(
            $f3->get('devdb'),
            $f3->get('devdbusername'),
            $f3->get('devdbpassword'),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
        );
        $this->db = $db;

    }

```

**Create model** that can be used in our application being the equivalent to our database tables.

The model will use the Fat Free ORM Mapper which is pretty easy to use.

(More information in their documentation **[here](http://fatfreeframework.com/databases)**)

Create a new php file into `app/MVC/Model/Messages.php`:

```php

<?php

class Messages extends DB\SQL\Mapper {

    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'gettingStarted.messages');
    }

    public function showAll() {
        $this->load();
        return $this->query;
    }

}

```

**Update the config.ini** in `app/config/config.ini` and expand the existing line:

```ini

; add your controller to the autoloading, more addable by setting pipe '|' in between
AUTOLOAD=app/MVC/Controller/|app/MVC/Model/

```

**Update MainController** in `app/MVC/Controller/MainController.php` like following:

```php

<?php

    function render($f3) {
        // setting a new global variable
        $f3->set('name', '"Your name could be here"');

        // getting messages from the databse
        $messages = new Messages($this->db);
        // counting up the array keys will return the other message texts
        $msg = $messages->showAll()[0];
        // setting the global variable for using the values in the templates
        $f3->set('msg', $msg);

        // instantiating new template object
        $template = new Template();
        echo $template->render('layout.html');
    }

```

**Update layout.html** in `app/MVC/View/layout.html` and change the code at the following point:

```HTML

        <main>
            <p><i>controller generated:</i> Hello {{ @name }} !</p>
            <p><i>database generated:</i> {{ @msg }}</p>
        </main>
```

Now we have all we need for trying it out...

------

#16.VisitAndInfo

When you now open your project page on localhost, you see that there is the HTML block on the mainpage containing the database 'generated' content.

We hard coded the output, since we've used the array key [0] when defining following variable: `$msg = $messages->showAll()[0];`

We can leave that out so we just have `$msg = $messages->showAll();` - **but** then we'd have to manage the template again and directly access the array key:

```HTML
       <p><i>database generated:</i> {{ @msg.message }}<br>
       <i>database generated:</i> {{ @msg.type }}</p>
```

For now, we stay with the {{ @msg.message }}.

--------

#17.AddingFunctionalityToModel

Now what if we don't want to query all messages but one?! Or add one? Or change one? Or delete one?

We can get this through editing the according model (`app/MVC/Model/Messages.php`)

```php

    /**
     * Get's a message by its ID
     * @param $id
     * @return array
     */
    public function getById($id) {
        $this->load(array('id=?', $id));
        return $this->query;
    }
    
    /**
     *  Stores POST values into database 
     */
    public function add() {
        $this->copyFrom('POST');
        $this->save();
    }

    /**
     * Updates a db entry at the specific id with the sent POST data
     * @param $id
     */
    public function edit($id) {
        $this->load(array('id=?', $id));
        $this->copyFrom('POST');
        $this->update();
    }

    /**
     * Drops the data with given id from database
     * @param $id
     */
    public function delete($id) {
        $this->load(array('id=?', $id));
        $this->erase();
    }

<?php

**Manually insert into database**

With following code snippet, you could easily manually insert new data into the database.

Put that snippet into your MainController at the beginning of the function "render".

Then reload the page in your browser **ONCE** !

```php

<?php

    $message = new Messages($this->db);
    $message->type = 1;
    $message->message = 'This is another Information.';
    $message->save();

```

When you check your database now, you can see a newly added entry inside the messages table.

--------

#18.Refactoring

Now that we have a little more functionality (routing, templating, databasing) we can refactor a little:


**Cleaning db and MainController**

First of all, let's clean the inserted message in the step before.

You can either manually delete it via SQL, SQL Workbench or whatever tool you prefer.

Or you just use the delete function we just added.

Call it in your script instead of the above php-snippet and give $id=5 as parameter.

```php

<?php

    $message = new Messages($this->db);
    $message->delete(5);

```

Then refresh your page **ONCE** and delete the code fragment from your MainController again.


**Using global**

Please delete the `$3` as parameter in the rendering methods of the MainController.

Then use '$this->f3` instead of `$f3` in the methods.


#19.ArraysInTemplates

Above we just read out one message from the database and put that into the template.

What we want to do now, is reading out the whole array of messages provided by the database.

Since we put `$msg = $messages->showAll()` in our MainController.php, the template already get's the whole array of data including all messages stored in the database.

We now just have to adjust the template with following html-tags:

```HTML

    <main>
        <p><i>controller generated:</i> Hello {{ @name }} !</p>
        
        <!-- Looping over all table entries -->
        <repeat group="{{ @msg }}" value="{{ @number }}">
            <!-- @key contains the table column names -->
            <repeat group="{{ @number }}" key="{{ @key }}" value="{{ @message }}">
                <!-- only display the actual message as text -->
                <check if="{{ @key2=='message' }}">
                    <p><i>database generated:</i>{{ @message }}</p><br>
                </check>
            </repeat>
        </repeat>
        
    </main>

```

> **NOTE**: You can always use `{{ var_dump(@variableName) }}` inside your templates for developing !


#20.Joins

You might have notice that even if we had a foreign key in our messages-table we only got the result of messages.

We did not get the message_types.

To get these, we'd usually do a join on the table and get the corresponding entries.

It would be something like:

```SQL

SELECT m.id, t.shorttitle, t.title, m.message FROM gettingStarted.messages m
JOIN gettingStarted.message_types t ON t.id
WHERE t.id = m.type

```

And that's what we're doing right now!

We're adding a new method to our Messages.php class:

```php

<?php

    public function showAllJoined() {
        $return = $this->db->exec(
            'SELECT m.id, t.shorttitle, t.title, m.message FROM gettingStarted.messages m
              JOIN gettingStarted.message_types t ON t.id
              WHERE t.id = m.type'
        );
        return $return;
    }

```

We use this method instead of the "showAll()" inside the MainController.php:

```php

<?php

    $msg = $messages->showAllJoined();

```

And last but not least, we need to adjust the template.html:

```HTML

    <!-- Looping over all table entries -->
    <repeat group="{{ @msg }}" value="{{ @number }}">
        <p>[[ {{ @number.shorttitle }} ]] {{ @number.message }}</p>
    </repeat>

```

It seems to be quite easy, doesn't it?

--------

#Conclusion

What we have now is a fully working web application with two simple routes and a simple template.

We're also already using a Fat Free Plugin for rendering Markdown - it's working like a charm.

[go back to the starting page](/gettingStarted/)
