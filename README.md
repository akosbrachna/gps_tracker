# gps_tracker

About the application

GPS tracker is a simple web based map tracking application which is still under development.
There's no license on it. It can be used freely.

A device with a web browser and gps capability is needed to send gps locations to the website which can be 
installed on any web server that runs on apache php mysql.
Registered users share their gps locations through the website and can track each other on the map.
Registered users have to send tracking requests to others on the website.
Contact settings such as permissions or visibility can be enabled or disabled dynamically on each user.
Contacts can be added or removed as well.
Categories can be made such as friends, family etc. 
Category settings (permission, visibility) are applied to all users in the selected category.

If the website is running in a phone's browser it will be periodically sending the gps coordinates 
to the server so long as your phone's browser is open. You will also see other registered users 
on the map that granted you permission on following them.

An android application is being under development too and as a native application 
it will be running as a foreground service.
That project will also be shared on github and the apk will be available on the website too.


The project

The project uses the codeigniter php framework ( https://www.codeigniter.com ) and runs on apache-php-mysql 
and it uses google map.
I'm no sure about legal issues on google map but because this is a free project 
hopefully there's no problem with it.
As far as i'm aware google map can not be used in commercial applications for free.

Setting up the project

The mysql database info will be added later...

In application/config/config.php file - the base url shoud be set: $config['base_url']

In application/config/database.php file - database server parameters should be set

In application/config/email.php file - the smtp provider should be set

in project root folder in .htaccess file the base directory name may need to be changed:
RewriteBase /gps_tracker/