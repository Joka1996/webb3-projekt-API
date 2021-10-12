<?php 
// ändra till false när man publicerar
$devMode = true;
if($devMode) {
    // Rapportera fel
    error_reporting(-1);
    ini_set("display_errors", 1);
}
// sökväg och ladda klsserna
spl_autoload_register(function($class_name) {
include "classes/" . $class_name . ".class.php";
});


if($devMode) {
    // anslutsinställnigar 
    define("DBHOST", "localhost");
    define("DBUSER", "webb3project");
    define("DBPASS", "password");
    define("DBDATABASE", "webb3project");
} else {
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "joka2005");
    define("DBPASS", "password");
    define("DBDATABASE", "joka2005");
}