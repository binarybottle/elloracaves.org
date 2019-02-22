
# To set up elloracaves.org locally:

1. In the elloracaves_db.php file:

	$host     = "localhost";     // mysql host server
	$db       = "elloracaves";   // database name
	$username = "root";          // mysql db - user
	$password = "root";          // mysql db - password


2. Add to bottom of /private/etc/hosts

127.0.0.1       elloracaves.org
127.0.0.1       media.elloracaves.org


3. Add to /Applications/MAMP/conf/apache/httpd.conf

NameVirtualHost *

<VirtualHost *:80>
   DocumentRoot /Applications/MAMP/htdocs
   ServerName localhost
</VirtualHost>

<VirtualHost *:80>
   DocumentRoot "/Applications/MAMP/htdocs/elloracaves.org"
   ServerName elloracaves.org
</VirtualHost>
<VirtualHost *:80>
   DocumentRoot "/Applications/MAMP/htdocs/media.elloracaves.org"
   ServerName media.elloracaves.org
</VirtualHost>
