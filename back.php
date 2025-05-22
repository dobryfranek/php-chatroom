<?php

session_start();


if (isset($_POST["set_user"])) {
    $demanded_login = $_POST["set_user"];
    if (str_contains($demanded_login, "|")) {
        $_SESSION["login"] = "konformista";
    } else {
        $_SESSION["login"] = substr($demanded_login, 0, 64); //limit username length
    }
}

if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = "konformista";
}

if (isset($_POST["get_user"])) {
    echo $_SESSION["login"];
    die();
}

define("MESSAGES_FILE_PATH", "messages.txt");

if (!file_exists(MESSAGES_FILE_PATH)) {
    touch(MESSAGES_FILE_PATH);
}

$messages_file_array = file(MESSAGES_FILE_PATH);

function echo_messages() {
    global $messages_file_array;
    echo implode("", array_slice($messages_file_array, -32));
}

if (isset($_POST["message"])) {
    $timestamp = date("H:i:s");
    $message = $_SESSION["login"] . "|||" . $_POST["message"];

    $messages_file = fopen(MESSAGES_FILE_PATH, "a");
    fwrite($messages_file, $message . "\n");
    fclose($messages_file);
}

echo_messages();

?>
