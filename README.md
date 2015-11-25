# Wowza Live Dashboard 1.1
I have been searching for a live dashboard, but never could find one, so i decided to build one myself. 
The dashboard relies on 2 xml output pages which are created by wowza itself. The connectioncounts and serverinfo pages. I keep on developing this dashboard to my needs.
If you have any problems or remarks, just leave a note or send an email how you think about it. Im alwasy open to feedback.

This version is for Wowza Streaming Engine 4.x. I also have one for Wowza Media Server 2.2.4 (i rebuild this version on a user request). If you need this one, just let me know

#Demopage:
http://vanmarion.nl/projects/Wowza_Dashboard_1.1
username: demo / password: demo

#Demo Wowza Page
If you want to test the dashboard just open this page and start the vod movie. within 30 seconds the dashboard will update and you will see the results there
http://vanmarion.nl/projects/wowza_demo/index.php
(works with desktop, android, iphone) windows phone not tested.

#Requirements
- Valid Wowza 4.x StreamingEngine environment (development or production)
- webserver where you can run this dashboard from
- Wowza server: open port 8086 in your firewall, edit VHost.xml (see below)

#screenshots 
http://vanmarion.nl/blog/blog/wowza-dashboard-1-0/
and see install directory

#Setup:
What you need is a webserver with php 5.3+, apache and mysql installed
- Create a database in mysql
- run the scripts in the /install/mysql_tables.sql
- edit the file :/Wowza_Dashboard/inc/general_conf.inc.php and fill in the credentials of your database.
- also change (if needed) the webdirectory and your timezone
```
$dbUserName = "DBUSERNAME"; 
$dbUserPasswd = "DBUSERPASSWORD"; 
$dbHost = "localhost"; 
$dbName = "DBNAME"; 

$DOCUMENT_ROOT = '/projects/Wowza_Dashboard_1.1'; // set your webroot directory: NO trailerslash!!!
date_default_timezone_set('Europe/Amsterdam');
```
the document_root to your needs.
upload the contents of the Wowza_Dashboard directory to your root or a directory of choice to your webhost

#Wowza create user
you have to create a user in the enginemanager with read only rights.
make sure port 8086 is open in your firewall. 
you can test if your account works in your browser:
http://wowza_ipaddress:8086/connectioncounts
and login with the credentials you have set. you should see the xml output

Check the settings below, cause you have to change the authentication method

#wowza adjustments
open the file /usr/local/WowzaStreamingEngine/conf/VHost.xml
find these lines:
```
<HTTPProvider>
<BaseClass>com.wowza.wms.http.HTTPConnectionCountsXML</BaseClass>
	<RequestFilters>connectioncounts*</RequestFilters>
	<AuthenticationMethod>admin-digest
	</AuthenticationMethod>
</HTTPProvider>
```
and change the authentication method from admin-digest 
to:
admin-basic
```
<HTTPProvider>
	<BaseClass>com.wowza.wms.http.HTTPConnectionCountsXML</BaseClass>
	<RequestFilters>connectioncounts*</RequestFilters>
	<AuthenticationMethod>admin-basic</AuthenticationMethod>
</HTTPProvider>
```

edit the file (or create one in wowza streaming manager)
```
/usr/local/WowzaStreamingEngine/conf/admin.password 
```
you have to add a user.
(example:
```
wowza_dashboard 123456
```
save the file and restart the StreamingEngine and the StreamingEngineManager
if you have a firewall running make sure port 8086 is accessible
Test the link in your browser with the login credentials you have set in the previous step:
http://<YOURSERVER_IPADRESS>:8086/connectioncounts

#Version 1.1
- added detailed info of a application (extraction of serverinfo based on application name)
- added datatransfer information
- code cleaning/optimalisation
- better usage of error reporting
- changed datatransfer rate
- added extra page all applications that are on the wowza server with the status (loaded, unloaded)
- updated demo environment with version 1.1

#Upgrading from version 1.0 to 1.1?
- just copy all the files (except the /inc/general.conf.inc.php)
- no mysql tables have changed, only files

#[Archive]Version 1.0:
- designed for mobile first
- dashboard setup with basic userlogin
- create and delete users (change of password will come in later version)
- configuration page for wowza connnections setup
- protected pages
- extracting of connectioncounts (xml) and inserting into mysql. 
- show which application is online/offline and bandwith 
- suitable for versions starting from 4.0.0 and up
- minor configuration needed in Wowza Streaming Engine (create read account)


/*
 * Copyright (c) 2015 Jeroen van Marion <jeroen@vanmarion.nl>
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */