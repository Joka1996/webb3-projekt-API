<?php
include("includes/config.php");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db -> connect_errno > 0){
    die("Fel uppstod vid anslutning till servern:" . $db ->connect_error);
}

// skapa tabeller med sql
$sql = "DROP TABLE IF EXISTS website_list;";
$sql = "CREATE TABLE website_list(id INT(11) PRIMARY KEY AUTO_INCREMENT, 
website_name VARCHAR(100) NOT NULL, 
website_url VARCHAR(500) NOT NULL, 
website_course VARCHAR(200) NOT NULL, 
website_img VARCHAR(200) NOT NULL,
website_about VARCHAR(500) NOT NULL,
created TIMESTAMP NOT NULL DEFAULT current_timestamp());";



// test 
echo "<pre>$sql</pre>";

// skicka $sql till databasen
if($db->multi_query($sql)) {
    echo "Tabell skapad.";
} else {
    echo "Error: Tabell ej skapad.";
}