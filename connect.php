<?php


$con = new mysqli('localhost', 'root', '', 'edujournal');

if (!$con) {
    die("Connection failed: " . $con->connect_error);
}
