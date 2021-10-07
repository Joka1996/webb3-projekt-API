<?php 
include("includes/config.php");

$c = new Course(); 

// test av delete
// $c->deleteCourse(8);

// test för att se anslutning
// var_dump($c);

// test för att lägga till
// var_dump($c->setCourse("TEST", 
// "TEST", "",
//  "TEST", "TEST" ));


// uppdatera
$c->updateCourse(14,"NY1","NY1","NY1","NY1","NY1");

// Test för att se alla en eller en specefik. 
echo"<pre>";
var_dump($c->getCourses());
echo "</pre>";