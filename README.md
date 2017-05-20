# gps_tracker
GPS tracking web application - This project is still under development.

This is a map tracking application where you can register and track other registered users 
if they accepted your tracking request by email requests.
If you open the page on your phone it will be sending your gps coordinates to the server so long as 
your phone's browser is running. You will also see other people on the map who you are allowed to follow.

An android application is being under development too and as a native application it will run as a foreground service.

The project uses the codeigniter https:www.codeigniter.com framework and runs on apache-php-mysql and google map.
I'm no sure about legal issues with using google map but because this is a free project i'm hoping there's no problem with it.
As far as i'm aware google map can not be used in commercial applications for free.

Setting up the project

The mysql database info will be added later.

in application/config/config.php file the base url shoud be set:

$config['base_url']

The database.php and email.php files have been left out from the config folder as they contain personal info, 
so those 2 files should be created and copied with the content below.

application/config/database.php

$active_group = 'default';
$active_record = TRUE;
//example:
$db['default']['hostname'] = "localhost";
$db['default']['username'] = 'root';
$db['default']['password'] = '';
$db['default']['database'] = 'gps_tracker';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = true;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

application/config/email.php
//example:
$config['protocol']  = 'smtp';
$config['smtp_host'] = 'ssl:smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'myusername';
$config['smtp_pass'] = 'mypassword';
$config['mailtype']  = 'html';
$config['newline']   = "\r\n";
