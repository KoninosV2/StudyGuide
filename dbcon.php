<?php
session_start();
$user = "dit13023";
$pass = "2441995KoN!";
try {
    $db = new PDO('mysql:host=localhost;dbname=dit13023_course_guide', $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>