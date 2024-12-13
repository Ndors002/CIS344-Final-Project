<?php
// Include the RestaurantServer.php file
require_once 'RestaurantServer.php';

// Create and run the portal
$portal = new RestaurantPortal();
$portal->handleRequest();