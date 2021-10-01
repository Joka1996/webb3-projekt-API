<?php 
// sökväg och ladda klsserna
spl_autoload_register(function($class_name) {
include "classes/" . $class_name . ".class.php";
});

$devMode = true;
if($devMode) {
    // Rapportera fel
    error_reporting(-1);
    ini_set("display_errors", 1);

    // anslutsinställnigar 
    define("DBHOST", "localhost");
    define("DBUSER", "webb3mom5");
    define("DBPASS", "password");
    define("DBDATABASE", "webb3mom5");
} else {
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "joka2005");
    define("DBPASS", "3hUPF8fFAC");
    define("DBDATABASE", "joka2005");
}