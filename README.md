# Wowza Streaming Engine Live Dashboard
is based on my previous version of wowza live charts. That project is deleted and merged and improved in this project.
Its version 1.0 and im already building on version 1.1. but its the first stable release. 

#Demopage:
http://vanmarion.nl/projects/Wowza_Dashboard
username: demo / password: demo

#Demo Wowza Page
If you want to test the dashboard just open this page and start the vod movie. within 60seconds the dashboard will update and you will see the results there
http://vanmarion.nl/projects/wowza_demo/index.php
(works with desktop, android, iphone) windows phone not tested.

#Requirements
- Valid Wowza 4.x environment (development or production)
- valid (free or paid) Jwplayer license
- webserver where you can run this dashboard from
- Wowza server: open port 8086 in your firewall, edit VHost.xml (see below)
- webhosting: 
		php 5.3+, apache, MySQL
		allow_url_open = On (or 1)
		allowing of retreiving external connections
		simpleXML enabled
		
#screenshots 
http://vanmarion.nl/blog/blog/wowza-dashboard-1-0/
and see install directory

#Setup:
What you need is a webserver with php 5.3+, apache and mysql installed
external connections should be allowed by your webhosting provider. (see troubleshooting if you run into problems).
Create a database:
 - run the scripts in the /install/mysql_tables.sql
 - edit the file :/Wowza_Dashboard/inc/general_conf.inc.php and fill in the credentials of your database.
```
$DOCUMENT_ROOT = '/projects/Wowza_Dashboard_1.1'; // set your webroot directory: NO trailerslash!!!
date_default_timezone_set('Europe/Amsterdam');
```
change DOCUMENT_ROOT to your directory where you want to upload the dashboard
change your default_timezone in case its not the same.
upload the contents of the Wowza_Dashboard directory to your root or a directory of choice to your webhost
dont upload the install directory

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
This requires a restart of your WowzaStreamingEngine, its up to you when its the best time to restart your StreamingEngine (in case of running applications)

#Version 1.2
- added troubleshooting in the readme file
- added contact info in the footer
- added check scripts in case of trouble shooting

#Upgrading from version 1.0 to 1.1/1.2?
- just copy all the files (except the /inc/general.conf.inc.php)
- no mysql tables have changed, only files

#Version 1.1
- added detailed info of a application (extraction of serverinfo based on application name)
- added datatransfer information
- code cleaning/optimalisation
- better usage of error reporting
- changed datatransfer rate
- added extra page all applications that are on the wowza server with the status (loaded, unloaded)
- updated demo environment with version 1.1

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

#Troubleshooting
1. When receiving errors like this in the dashboard:
```
Warning: simplexml_load_file(http://...@IPADDRESS:8086/connectioncounts) 
[function.simplexml-load-file]: failed to open stream: Connection refused in ............ /products/wowza/xml/extract_connectioncounts.php on line 28
```
this means your webhost has disabled external connections on your account to port 8086. Its a known issue at GoDaddy which only allows connecting to port 80 and 443. Only solution will be if Godaddy would allow port 8086
or you have to find another webhost for this script.

You can check if the simplexml module is installed in php. 
run the scripts:
/checks/check_extensions.php  to see if the libxml module is installed
/checks/ext_connections.php to see if it shows the google page (that means libxml is working on port 80)


2. the icons keep spinning on the wowza_overview.php page or no data is updated.
- wait for about 30 seconds to see any changes (it used to be 60seconds before any data would show).
- Please check if you have any streams online (or play any vod from your wowza server). 
- check the /usr/local/WowzaStreamingEngine/conf/VHost.xml if you have set the authentication to admin-basic for connectioncounts* and serverinfo* (a restart of the streamingEngine is needed)

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