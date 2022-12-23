<?php

session_start();

$HOST = 'localhost';
$DB_PWD = '';
$USERNAME = 'root';
$DATABASE = 'trydominoes';

$conn = new mysqli($HOST, $USERNAME, $DB_PWD, $DATABASE);

if ($conn->connect_error) {
    die('Connection Failed' . $conn->connect_error);
}





