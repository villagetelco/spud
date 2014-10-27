<?php


echo $html->addCrumb('Installation', '/install');

echo "<h1>".__('How to install SPUD',true)."</h1>";

echo "<h2>1. Install dependencies</h2>";
echo "<div class='pre'>apt-get install apache2 php5 mysql-server php5-mysql subversion</div>";

echo "<h2>2. Get the code</h2>";
echo "<div class='pre'>cd /var/www</div>";
echo "<div class='pre'>svn co http://dev.villagetelco.org/svn/villagetelco/spud/trunk spud</div>";


echo "<h2>3. Database</h2>";
echo "<div>a) Create a new database</div>";
echo "<div class='pre'>mysqladmin -u root -p create spud</div>";

echo "<div>b) Edit SPUD database settings</div>";
echo "<div class='pre'>vi /var/www/spud/app/config/database.php</div>";


echo "<pre>
	var \$default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '<password>',
		'database' => 'spud',
		'prefix' => '',
	);</pre>";


echo "c) Create database schema>";
echo "<div class='pre'>cd /var/www/spud/app/install</div>";
echo "<div class='pre'>mysql -u root spud -p < spud_db_schema.sql</div>";


echo "<h2>4. Change file permission</h2>";
echo "<div class='pre'>cd  /var/www/spud/app/</div>";
echo "<div class='pre'>chown -Rf www-data.www-data tmp/</div>";


echo "<h2>5. Enable Apache rewrite module</h2>";
echo "<div class='pre'>cd /etc/apache2</div>";
echo "<div class='pre'>a2enmod rewrite</div>";


echo "<h2>6. Edit Apache2 000-default file</h2>";
echo "<div class='pre'>vi /etc/apache2/sites-enabled/000-default</div>"; 

echo "<pre>
        <Directory /var/www/spud/>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
        </Directory>
        </pre>";


echo "<div>Restart Apache</div>";
echo "<div class='pre'>/etc/init.d/apache2 restart</div>";

echo "<h2>7. Configure VIS server</h2>";
echo "<div>a) Set the IP address/domain name of your webserver. Default value is 127.0.0.1</div>";
echo "<div>b) Set the IP addres of your VIS server. The default settings will point to the Bo Kaap VIS server.</div>";
echo "<div>c) Configure the vis mode. SPUD supports two VIS modes ('mode' => 'batman') and ('mode' => 'batman-adv') depending if you run your mesh protocol in L3 or L2</div>";
echo "<div>d) Configure the vis_version. If you run a L3 mesh network you need also to define the vis_version variable. The legacy value supports the</div>";
echo "<div>broken JSON output of some old implementations. Recent L3 VIS servers should be set up as vis_version: trunk</div>";
echo "<div class='pre'>vi /var/www/spud/app/config/config.php</div>";
echo "<pre>
     \$config['SPUD']= array(
               'host'     => '127.0.0.1'
               );
      </pre>";

echo "<pre>
     \$config['VIS']= array(                                                   
               'host'     => '41.223.35.110',
               'port'     => '2015',
               'timeout'  => '30'
   	       'vis_version' => 'legacy',
	       'mode'        => 'batman',
               );
               </pre>";



echo "<h2>8. Add VIS update to cronjob</h2>";
echo "<div>a) Open cronjob editor</div>";
echo "<pre>crontab -e</pre>";

echo "<div>b) Add the follwing line</div>";
echo "<pre>*/5 * * * * root /usr/bin/wget -O - -q -t 1 http://localhost/spud/nodes/update  >/dev/null 2>&1</pre>";

echo "<h2>9. Get started with SPUD</h2>";
echo "<div>Navigate to SPUD:</div>";
echo "<div class='pre'> http://localhost/spud</div>";




?>
