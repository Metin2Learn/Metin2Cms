================================================================
INSTALL:
================================
first:
Open mt2grand.sql
search for "http://localhost/mt2grand-cms" and replace ALL with your url (for example: http://yoursite.com )
....
search "noxel" and replace with your username (you will get admin rights to this username to control your CMS)
----------------------------------------------------------------------------------------------------------------------------------
1) Make new database on your GAME SERVER and give it name "mt2grand"
2) Open mt2grand.sql and copy all text
	Open your new database "mt2grand" and make new query.
	Copy your mt2grand.sql text into query.
	Run query... now wait until query is finished... it can take up to 5 minutes.
3) Upload files (folder "files_upload_to_web") to your web server
4) Go to your web server and open file - "inc/init.php"
	Change your mysql name, password, host.
5) Set CHMOD 777 to these folders:
	assets/images/avatars
	assets/images/avatars/team
	assets/images/itemshop
	assets/images/news
	assets/images/referral
	assets/images/slider
6) Execute account.sql into your account DB
7) Open index.php and search for : http://localhost/mt2grand-cms/ -> edit with your URL
8) Finished !
================================================================

================================================================
QUESTIONS:
================================
1) How to use automatic paypal payments:
	1.1) - Rename paypal.php to random name with .php extension(prevention against fake POST requests) i.e: fd45fwqe56fw54.php
	1.2) - Create paypal bussiness account
	1.3) - Enable IPN on your paypal account - follow screenshots in "paypal-setup" folder
	1.4) - in CMS administration - Edit your paypal email and your currency that is your paypal account using
	---finished---
2) How to translate website ?
	2.1) - Open "inc/classes/Language.class.php"
	2.2) - Find "$phrases = array(" and below you can translate every string used on website.
	for example: "register" => "Register", // the second string (after =>) is translation
	so when you want to translate it into Czech language - "register" => "Registrace"
================================================================