<?php
// allow cross domain access
// header('Access-Control-Allow-Origin: *');
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
} else {
    // allow Jasmine tests to run
    header("Access-Control-Allow-Origin: http://localhost:8234/");
}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');    // cache for 1 day

// Stop caching of responses (was a problem in IE).
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    exit(0);
}

// Instantiate the Slim app
require 'lib/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

// Return the correct headers for OPTIONS requests
$app->options('/(:name+)', function() use ($app) {
    $app->response()->header('Access-Control-Allow-Origin', 'http://localhost:8234/'); //Allow JSON data to be consumed
    $app->response()->header('Access-Control-Allow-Headers', 'X-Requested-With, X-authentication, X-client'); //Allow JSON data to be consumed
});


// Include the Config class
require_once('config.php');

// Set up the database connection
$mysqli = new mysqli(Config::DB_host, Config::DB_user, Config::DB_password, Config::DB_database);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// set up the response object
$response = array(
    'success'=>FALSE,
    'action'=>NULL,
    'error'=>NULL,
    'data'=>NULL
);

// Include Web Methods
require_once('methods/todos.php');

// Run the app
$app->run();
