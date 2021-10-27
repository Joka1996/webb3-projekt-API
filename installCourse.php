<?php
include("includes/config.php");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db -> connect_errno > 0){
    die("Fel uppstod vid anslutning till servern:" . $db ->connect_error);
}

// skapa tabeller med sql
$sql = "DROP TABLE IF EXISTS course_list2;";
$sql = "CREATE TABLE course_list2(id INT(11) PRIMARY KEY AUTO_INCREMENT,
course_school VARCHAR(200) NOT NULL, 
course_time VARCHAR(64) NOT NULL,
course_name VARCHAR(64) NOT NULL, 
course_syllabus VARCHAR(500) NOT NULL, 
course_grade VARCHAR(64) NOT NULL,  
created TIMESTAMP NOT NULL DEFAULT current_timestamp());";



// test 
echo "<pre>$sql</pre>";

// skicka $sql till databasen
if($db->multi_query($sql)) {
    echo "Tabell skapad.";
} else {
    echo "Error: Tabell ej skapad.";
}