<?php

session_start();

//login todo here

if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = "konformista";
}

define("MESSAGES_FILE_PATH", "messages.txt");

if (!file_exists(MESSAGES_FILE_PATH)) {
    touch(MESSAGES_FILE_PATH);
}

$messages_file_array = file(MESSAGES_FILE_PATH);

function echo_messages() {
    global $messages_file_array;
    echo implode("", array_slice($messages_file_array, -128));
}

if (isset($_POST["message"])) {
    $message = $_SESSION["login"] . "|||" . $_POST["message"];

    $messages_file = fopen(MESSAGES_FILE_PATH, "a");
    fwrite($messages_file, $message . "\n");
    fclose($messages_file);
}

echo_messages();

?>
