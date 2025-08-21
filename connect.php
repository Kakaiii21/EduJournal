<?php


$con = new mysqli('localhost', 'root', '', 'threadly');

if (!$con) {
    die("Connection failed: " . $con->connect_error);
}
