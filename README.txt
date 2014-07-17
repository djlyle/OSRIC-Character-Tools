OSRIC Character Tools

Original Project Name: OSRIC Character Tools
Original Project Creator: Daniel Lyle
Original Project Start Date: July 15, 2014

The goal of this project is to create some tools to aid in playing a character in an OSRIC (Old School Reference and Index Compilation) style Role Playing Game.

The original OSRIC manual can be found at the following URL:
http://www.knights-n-knaves.com/osric/downloads/OSRIC.pdf

The tools are implemented as a web application using the following stack of components:
1)a database engine (MySQL) to store character data in tables (model)
2)a server side script language (PHP) to create dynamic web page content (view and business logic) 
3)a web server (Apache Web Server) capable of translating html requests into serving the aforementioned dynamic web page content supplied by executing requested pages containing php script (controller/server)

Instructions to setup OSRIC Character Tools:
1)Download a version of this project from github (e.g. the version containing this README.txt file)
2)Download and install a MySQL,PHP,Apache bundle installer like XAMPP available at:
https://www.apachefriends.org/download.html
3)Copy this project's osric_character_tools folder into xampp's htdocs folder (e.g. if XAMPP is installed at C:\\xampp then copy this project's osric_character_tools folder into C:\xampp\htdocs).
4)Launch the XAMPP Control Panel application
5)Click the Start button in the MySQL Module's row in the XAMPP Control Panel
6)Click the Start button in the Apache Module's row in the XAMPP Control Panel
7)Click the Admin button in the MySQL Module's row in the XAMPP Control Panel
8)This launches phpMyAdmin web application that allows creating and editing databases and their tables via a web browser.
9)Click the New database in the treeview of databases in the left panel of phpMyAdmin and name the new database "osric_db".
10)Select the newly created osric_db database in phpMyAdmin and click the Import tab.
11)Import the osric_db.sql file inside this project by browsing to it's location and importing it.  
12)The following tables should now exist in the osric_db in phpMyAdmin:
	a)characters
	b)character_items
	c)items
13)Launch a webbrowser and navigate to the start page for OSRIC tools, e.g. if running the browser on the local machine the url would be as follows:
http://localhost/osric_character_tools/characters.php