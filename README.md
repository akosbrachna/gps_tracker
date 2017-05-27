# gps_tracker

About the application

GPS tracker is a simple web based map tracking application.

A device with a web browser and gps capability is needed to send gps locations to the website which can be 
installed on any web server that runs apache php mysql.

Registered users share their gps locations through the website and can track each other on the map.

Registered users have to send tracking requests to others on the website.

Contact settings such as permission or visibility can be enabled or disabled dynamically on each user.
Contacts can be added or removed.

Categories can be made such as friends, family etc. 
Category settings (permission, visibility) are applied to all users in the selected category.

If the website is running in a phone's browser it will be periodically sending the gps coordinates 
to the server so long as the phone's browser is open. You will also see your contacts' location on the map.

An android application is being developed too. The android application as a foreground service 
can continuously be sending the gps locations from the phone to the server without having to keep 
the browser window open.
That project is also shared on
<a href="https://github.com/akosbrachna/gps_tracking_android" target="_blank">github</a> 
    

The project

The project uses the codeigniter php framework ( https://www.codeigniter.com ) and runs on apache php mysql 
and it uses google map.
As far as i know google map can not be used in commercial applications for free.

This project can be used or modified freely.

Setting up the project

1. In the project root folder in the .htaccess file the base directory name may need to be changed:
RewriteBase /gps_tracker/

2. application/config/config.php - the base url shoud be set: $config['base_url']

3. application/config/database.php - database server parameters should be set

4. run http://localhost/gps_tracker/database/tables/create
this will create the tables in the database. 
Replace localhost with your server domain.

5. application/config/email.php - the smtp provider should be set

A working example can be found here: https://akosbrachna.000webhostapp.com/