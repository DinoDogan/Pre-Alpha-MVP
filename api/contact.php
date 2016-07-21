<?php

header("Content-Type: application/json");

$output = array(
    "status" => 200,
    "message" => "",
    "data" => "",
    "error" => ""
);

$name = filter_input(INPUT_POST, "name");
$email = filter_input(INPUT_POST, "email");
$message = filter_input(INPUT_POST, "message");

if (trim($name) != "") {
    if (preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $email)) {

        if (trim($message) != "") {
            $headers = "From: " . $name . " <" . $email . ">\r\n";

            if (mail("dino.dogan@gmail.com", "Magnificent Query", $message, $headers) !== false) {
                $output["message"] = "Thanks! Your request was sent.";
            } else {
                $output["error"] = "Error sending email. Please try again.";
            }
        } else {
            $output["error"] = "Message field is required.";
        }
    } else {
        $output["error"] = "Email is blank or not in the correct format.";
    }
} else {
    $output["error"] = "Name field is required";
}

echo json_encode($output);

?>