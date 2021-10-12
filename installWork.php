<?php
include("includes/config.php");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db -> connect_errno > 0){
    die("Fel uppstod vid anslutning till servern:" . $db ->connect_error);
}

// skapa tabeller med sql
$sql = "DROP TABLE IF EXISTS work_list;";
$sql = "CREATE TABLE work_list(id INT(11) PRIMARY KEY AUTO_INCREMENT, 
work_place VARCHAR(200) NOT NULL,
work_title VARCHAR(200) NOT NULL, 
work_year VARCHAR(200) NOT NULL, 
created TIMESTAMP NOT NULL DEFAULT current_timestamp());";



// test 
echo "<pre>$sql</pre>";

// skicka $sql till databasen
if($db->multi_query($sql)) {
    echo "Tabell skapad.";
} else {
    echo "Error: Tabell ej skapad.";
}