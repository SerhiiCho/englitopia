<?php session_start();

// Define base params
define( 'BASE_DIR', dirname(dirname(__FILE__)) );

require_once(BASE_DIR . '/libs/rb.php');
require_once(BASE_DIR . '/config.php');

// Database connection
R::setup( 'mysql:host=' . DB_HOST.';dbname=' . DB_NAME, DB_USER, DB_PASSWORD );
R::freeze( false );