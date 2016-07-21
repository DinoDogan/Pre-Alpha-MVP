<?php

    require "../inc/UploadsDB.php";

    $email = filter_input(INPUT_POST, "email");
    $message = filter_input(INPUT_POST, "message");

    // turn on json mode
    header("Content-Type: application/json");

    $output = array("status" => 200, "error" => "", "message" => "");

    if (trim($email) != "") {

        // validate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {

            // check for special instructions

            if (trim($message) != "") {

                // check for files existing
                if (isset($_FILES["files"])) {

                    $uploadsdb = new UploadsDB();

                    foreach ($_FILES["files"]["name"] as $i => $name) {

                        $file = array(
                            "name" => $name,
                            "tmp_name" => $_FILES["files"]["tmp_name"][$i],
                            "type" => $_FILES["files"]["type"][$i],
                            "error" => $_FILES["files"]["error"][$i]
                        );

                        switch ($file["error"]) {
                            case UPLOAD_ERR_OK:

                                // build up path
                                $upload_path = $uploadsdb->root . $uploadsdb->counter . ".pdf";

                                if (move_uploaded_file($file["tmp_name"], $upload_path) !== false) {
                                    $uploadsdb->add_file($file["name"], $email, $message);

                                } else {
                                    $output["error"] .= "Error uploading file. ";
                                }

                                break;
                            case UPLOAD_ERR_INI_SIZE:
                                $output["error"] .= "Files greater than " . ini_get("upload_max_filesize") . " are not allowed. ";
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $output["error"] .= "Only part of a file was received. ";
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $output["error"] .= "No file was received. ";
                                break;
                            case UPLOAD_ERR_NO_TMP_DIR:
                                $output["error"] .= "Internal error: tmp dir is missing. "
                                    . "Please contact this site administrator and provide the "
                                    . "above details. ";
                                break;
                            case UPLOAD_ERR_CANT_WRITE:
                                $output["error"] .= "Invalid permissions. ";
                                break;
                            case UPLOAD_ERR_EXTENSION:
                                $output["error"] .= "An internal PHP extension stopped "
                                    . "file uploads. Please contact this site admin for "
                                    . "details. ";
                                break;
                            default:
                                $output["error"] .= "An unknown error occurred. ";
                                break;
                        }

                        // break out of loop if one file fails
                        if ($file["error"] !== UPLOAD_ERR_OK) {
                            break;
                        }
                    }

                    // save
                    $uploadsdb->save();

                } else {
                    $output["error"] .= "File size exceeded or file not uploaded. ";
                }
            } else {
                $output["error"] .= "Special instructions field required! ";
            }
        } else {
            $output["error"] .= "Invalid email address. ";
        }
    } else {
        $output["error"] .= "Email address required. ";
    }

    // trim off whitespace
    $output["error"] = trim($output["error"]);

    echo json_encode($output);

?>