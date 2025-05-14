<?php
session_start();

//login todo here

if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = "anonymous";
}

define("MESSAGES_FILE_PATH", "messages.txt");

if (!file_exists(MESSAGES_FILE_PATH)) {
    touch(MESSAGES_FILE_PATH);
}

$messages_file = file(MESSAGES_FILE_PATH);

function echo_messages() {
    echo nl2br(implode("", array_slice($messages_file, -32)));
    return 0
}

if (!isset($_POST["message"])) {
    echo_messages();
    exit(0);
}

$message = $_SESSION["login"] . ": " . $_POST["message"];

fwrite($message . "\n")

echo_messages();

?>