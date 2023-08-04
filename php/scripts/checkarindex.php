<?php
// Start the session if not already started
session_start();

// Check if the user is logged in
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    // User is logged in, return a JSON response indicating authenticated
    $response = array("authenticated" => true);
} else {
    // User is not logged in, return a JSON response indicating not authenticated
    $response = array("authenticated" => false);
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>