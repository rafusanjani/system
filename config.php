<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/



// Try connecting to the Database
$conn = new mysqli("localhost","root","","login");

//Check the connection
if($conn == false){
    dir('Error: Cannot connect');
}

?>
