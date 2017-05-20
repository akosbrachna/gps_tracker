# gps_tracker
GPS tracking web application - This project is still under development.

This is a map tracking application where you can register and track other registered users 
if they accepted your tracking request by email requests.
If you open the page on your phone it will be sending your gps coordinates to the server so long as 
your phone's browser is running. You will also see other people on the map who you are allowed to follow.

An android application is being under development too and as a native application it will run as a foreground service.

The project uses the codeigniter https://www.codeigniter.com framework and runs on apache-php-mysql and google map.
I'm no sure about legal issues with using google map but because this is a free project i'm hoping there's no problem with it.
As far as i'm aware google map can not be used in commercial applications for free.

Setting up the project

The mysql database info will be added later.

In application/config/config.php file the base url shoud be set: $config['base_url']

In application/config/database.php file your database server parameters should be set

In application/config/email.php your smtp provider should be set
