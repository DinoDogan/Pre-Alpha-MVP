<?php

// email field
$email = filter_input(INPUT_POST, "email");

// special instructions field
$message = filter_input(INPUT_POST, "message");

$storage_path = "../db/uploads/";

// turn on json mode
header("Content-Type: application/json");

$output = array("status" => 200, "errors" => array(), "messages" => array(), "data" => array());

// check for files existing
if (isset($_FILES["files"])) {

    $counter_path = $storage_path . "counter.db";
    $db_path = $storage_path . "db.xml";

    if (!is_file($counter_path))
        file_put_contents($counter_path, "-1");

    if (!is_file($db_path))
        file_put_contents($db_path, '<?xml version="1.0"?><uploads></uploads>');

    // load counter
    $counter = file_get_contents($counter_path);

    // load database
    $db = simplexml_load_file($db_path);

    foreach ($_FILES["files"]["name"] as $i => $name) {

        $file = array(
            "name" => $name,
            "tmp_name" => $_FILES["files"]["tmp_name"][$i],
            "type" => $_FILES["files"]["type"][$i],
            "error" => $_FILES["files"]["error"][$i]
        );

        switch ($file["error"]) {
            case UPLOAD_ERR_OK:

                // increment
                $counter++;

                // build up path
                $upload_path = $storage_path . $counter . ".pdf";

                if (move_uploaded_file($file["tmp_name"], $upload_path) !== false) {
                    array_push($output["errors"], "");

                    $new_file_entry = $db->addChild('file');
                    $new_file_entry->addChild('name', $file["name"]);
                    $new_file_entry->addChild('email', $email);
                    $new_file_entry->addChild('message', $message);

                } else {
                    array_push($output["errors"], "Error uploading file.");
                }

                break;
            case UPLOAD_ERR_INI_SIZE:
                array_push($output["errors"], "Files greater than " . ini_get("upload_max_filesize") . " are not allowed.");
                break;
            case UPLOAD_ERR_PARTIAL:
                array_push($output["errors"], "Only part of a file was received.");
                break;
            case UPLOAD_ERR_NO_FILE:
                array_push($output["errors"], "No file was received.");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                array_push($output["errors"], "Internal error: tmp dir is missing. "
                    . "Please contact this site administrator and provide the "
                    . "above details.");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                array_push($output["errors"], "Invalid permissions.");
                break;
            case UPLOAD_ERR_EXTENSION:
                array_push($output["errors"], "An internal PHP extension stopped "
                    . "file uploads. Please contact this site admin for "
                    . "details.");
                break;
            default:
                array_push($output["errors"], "An unknown error occurred.");
                break;
        }
    }

    // save
    file_put_contents($counter_path, $counter);
    $db->asXML($db_path);

} else {
    array_push($output["errors"], "File size exceeded or file not uploaded.");
}

echo json_encode($output);

?>