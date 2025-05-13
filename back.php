<?php
session_start();

$login = $_POST

define("MESSAGES_FILE_PATH", "messages.txt");

if (!file_exists(MESSAGES_FILE_PATH)) {
    touch(MESSAGES_FILE_PATH);
}

$messages_file = file(MESSAGES_FILE_PATH);

if

?>