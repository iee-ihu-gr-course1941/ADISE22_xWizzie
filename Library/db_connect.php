<?php
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


$HOST = 'localhost';
$DB_PWD = '';
$USERNAME = 'root';
$DATABASE = 'trydominoes';

$conn = new mysqli($HOST, $USERNAME, $DB_PWD, $DATABASE);

if ($conn->connect_error) {
    die('Connection Failed' . $conn->connect_error);
} else {
    console_log('Connection Initialized');
}


