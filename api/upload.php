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

                    // array of filenames for emailing
                    $filenames = array();

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
                                    array_push($filenames, $file["name"]);
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

                    $email_to = 'dino.dogan@gmail.com';
                    $email_subject = 'New PDFs Uploaded - MagAdmin';

                    // message
                    $email_message = '<html><head><title>' . $email_subject . '</title></head><body>'
                        . '<h1>New Uploads</h1>'
                        . '<p>The following files have been uploaded to Magnificent by <em>' . $email . '</em>:</p>'
                        . '<ul>';

                    foreach ($filenames as $i => $filename) {
                        $email_message .= "<li>$filename</li>";
                    }

                    $email_message .= '</ul>'
                        . '<p><a href="http://' . $_SERVER["HTTP_HOST"] . '/admin/">View the new uploads &rsaquo;</a></p>'
                        . '<p><small><em>You\'re receiving this email because you\'ve been designated '
                        . 'as the server admin. To unsubscribe, delete your email account.</em></small></p>'
                        . '</body></html>';

                    // To send HTML mail, the Content-type header must be set
                    $email_headers = 'MIME-Version: 1.0' . "\r\n";
                    $email_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    // Additional headers
                    $email_headers .= 'To: Server Admin <' . $email_to . '>' . "\r\n";
                    $email_headers .= 'From: Magnificent <noreply@app.magnificent.com>' . "\r\n";

                    // Mail it
                    mail($email_to, $email_subject, $email_message, $email_headers);

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