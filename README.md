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

* [Fatfree PHP Framework Youtube-Tutorials by takacsmark](https://www.youtube.com/watch?v=DQT5sDO1_Ck)


--------


# INDEX

[#1.Composer](#1.Composer)  

[2. FatFreeFramework](#2.FatFreeFramework)  

[3. .htaccess](#3..htaccess)  

[4. apache2 Config](#4.apache2Config)  

[5. mod_rewrite](#5.mod_rewrite)  

[6. Structure I](#6.StructureI)  

[7. index.php](#7.index.php)

[8. Permissions](#8.Permissions)

[9. FirstVisit](#9.FirstVisit)

[10. Structure II](#10.StructureII)

[11. First Controllers And Routes](#11.FirstControllersAndRoutes)

[12. AnotherVisit](#12.AnotherVisit)


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

#13.Conclusion

What we have now is a fully working web application with two simple routes and a simple template.

We're also already using a Fat Free Plugin for rendering Markdown. 

Sure it's nothing compared to all the HTML5 and CSS3 but it's working like a charm.

[go back to the starting page](/gettingStarted/)
