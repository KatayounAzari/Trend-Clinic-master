<?php

/* 2016 all rights reserved by web-brick design, author: Jasmine Khalimova */

$to = "info@trendhealthandbeauty.com";
$subject = "New booking from trendhealthandbeauty.com";
$errorMessages = array();
$name = $phone = $emailBody = $fromEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    array_push($errorMessages, "Name is required.");
  }
  else {
    $name = process_form_input($_POST["name"]);
  }

  if (empty($_POST["phone"])) {
    array_push($errorMessages, "Phone number is required.");
  }
  else {
    $phone = process_form_input($_POST["phone"]);
  }

  if (empty($_POST["email"])) {
    array_push($errorMessages, "Email is required.");
  }
  else {
    $isEmailValid = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if ($isEmailValid) {
        $fromEmail = process_form_input($_POST["email"]);
    }
    else {
        array_push($errorMessages, "Email is invalid.");
    }
  }

  if (empty($_POST["message"])) {
      array_push($errorMessages, "Message is required.");
  }
  else {
      $emailBody = process_form_input($_POST["message"]);
  }

  if (!empty($errorMessages)) {
    $success = "Message Sending Failed, try again";
      // Your message was not sent
      redirect("../contact.php?responseMessage=Your message was not sent. Please email us at info@trendhealthandbeauty.com.#form");
  }
  else {
    $headers = "From: ".$name." <".$fromEmail.">";
    $emailBody = "Name: ".$name."\nEmail: ".$fromEmail."\nPhone: ".$phone."\n\n".$emailBody;
    if (mail($to, $subject, $emailBody, $headers)) {
       $success = "Message successfully sent";
      redirect("../contact.php?responseMessage=Your message was sent. We will get back to you soon.#form");
    }
  }
}
else {
  $success = "Message Sending Failed, try again";
  // "Your message was not sent
  redirect("../contact.php?responseMessage=Your message was not sent. Please email us at info@trendhealthandbeauty.com.#form");
}

/* Generic form processing:
1. Put form input through htmlspecialchars() to prevent basic code injection attacks.
2. Strip unnecessary characters, e.g. extra spaces.*/
function process_form_input($inputValue) {
  $inputValue = trim($inputValue);
  $inputValue = htmlspecialchars($inputValue);
  return $inputValue;
}

function redirect($url) {
  header('Location: '.$url);
  exit();
}

?>