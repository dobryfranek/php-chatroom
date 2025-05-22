<?php

session_start();

define("MESSAGES_FILE_PATH", "messages.txt");
define("UPLOAD_DIR", "pliki/");
define("MESSAGE_RETURN_LIMIT", 32);
define("LOGIN_LENGTH_LIMIT", 64);

if (!file_exists(MESSAGES_FILE_PATH)) {
    touch(MESSAGES_FILE_PATH);
}
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

if (isset($_FILES["file"])) {
    move_uploaded_file($_FILES["file"]["tmp_name"], UPLOAD_DIR . $_FILES["file"]["name"]);
}

if (isset($_POST["set_user"])) {
    $demanded_login = $_POST["set_user"];
    if (str_contains($demanded_login, "|")) {
        $_SESSION["login"] = "konformista";
    } else {
        $_SESSION["login"] = substr($demanded_login, 0, LOGIN_LENGTH_LIMIT);
    }
}

if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = "konformista";
}

if (isset($_POST["get_user"])) {
    echo $_SESSION["login"];
    die();
}

if (isset($_POST["get_file_list"])) {
    echo json_encode(array_diff(scandir(UPLOAD_DIR), array("..", ".")));
    die();
}

$messages_file_array = file(MESSAGES_FILE_PATH);

function echo_messages() {
    global $messages_file_array;
    echo implode("", array_slice($messages_file_array, -1 * MESSAGE_RETURN_LIMIT));
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
