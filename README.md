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

#Setup:
What you need is a webserver with php 5.3+, apache and mysql installed
Create a database:
 - run the scripts in the /install/mysql_tables.sql
 - edit the file :/Wowza_Dashboard/inc/general_conf.inc.php and fill in the credentials of your database. And edit 
the document_root to your needs.
upload the complete folder Wowza_Dashboard to your webhost

#Wowza create user
you have to create a user in the enginemanager with read only rights.
make sure port 8086 is open in your firewall. 
you can test if your account works in your browser:
http://your_ipaddress:8086/connectioncounts
and login with the credentials you have set. you should see the xml output

Check the settings below, cause you have to change the authentication method

#wowza adjustments
open the file /usr/local/WowzaStreamingEngine/conf/VHost.xml

find this line:
```
<HTTPProvider><BaseClass>com.wowza.wms.http.HTTPConnectionCountsXML</BaseClass<RequestFilters>connectioncounts*</RequestFilters><AuthenticationMethod>admin-digest</AuthenticationMethod></HTTPProvider>
```
and change the authentication method from admin-digest 
to:
admin-basic
```
<HTTPProvider><BaseClass>com.wowza.wms.http.HTTPConnectionCountsXML</BaseClass<RequestFilters>connectioncounts*</RequestFilters><AuthenticationMethod>admin-basic</AuthenticationMethod></HTTPProvider>
```
edit the file
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

#Version 1.0:
- designed for mobile first
- dashboard setup with basic userlogin
- create and delete users (change of password will come in version 1.1)
- configuration page for wowza connnections setup
- protected pages
- extracting of connectioncounts (xml) and inserting into mysql. best to use a cronjob, or wait for 60seconds.
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