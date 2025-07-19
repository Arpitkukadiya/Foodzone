<?php
include("connection/config.php"); //connection to db
error_reporting(0);
session_start();


// sending query
mysqli_query($db,"DELETE FROM orders WHERE id = '".$_GET['order_del']."'"); // deletig records on the bases of ID
header("location:orders.php");  //once deleted success redireted back to current page

?>
