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
to the server so long as the phone's browser is open. You will also see your contacts' locations on the map.

An android application has been developed too. The android application as a foreground service 
is continuously sending the gps locations from the phone to the server. The android application can also send 
the coordinates to a given phone number as an sms text message in case no server or 3G connection is available.
That project is also shared on <a href="https://github.com/akosbrachna/gps_tracking_android" target="_blank">github</a>
<br />
<img src="https://github.com/akosbrachna/gps_tracker/blob/master/web/pics/gps_tracker_android.png" height="240" width="135">
    

The project

The project uses the codeigniter php framework ( https://www.codeigniter.com ) and runs on apache php mysql 
and it uses google map.
Google map can not be used for free in such commercial applications that offer map related sevices.
https://www.google.com/intl/en-US_US/help/terms_maps.html

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
I use gmail as an smtp relay to send out confirmation emails on registration requests. If you set up the project locally you can bypass the email confirmaton by setting the confirm field to 1 in the user table as shown in the picture: <img src="https://github.com/akosbrachna/gps_tracker/blob/master/web/pics/reg.png">

At the time i created the project i used xampp 5.6.15 which can be accessed here:

Windows:
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/5.6.15/

Mac OS:
https://sourceforge.net/projects/xampp/files/XAMPP%20Mac%20OS%20X/5.6.15/

Linux:
https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/5.6.15/

Unfortunately i don't have time to maintain and upgrade the project to newer versions and this project does not work with the latest server environments.
