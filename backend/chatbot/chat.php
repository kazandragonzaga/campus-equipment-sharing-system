<?php

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Only POST requests are allowed."
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data["message"])) {
    echo json_encode([
        "success" => false,
        "message" => "Please provide a message."
    ]);
    exit;
}

$message = strtolower($data["message"]);

$equipment = null;
$date = null;
$time = null;

// Detect equipment
if (strpos($message, "projector") !== false) {
    $equipment = "Projector";
} elseif (strpos($message, "speaker") !== false) {
    $equipment = "Speaker";
} elseif (
    strpos($message, "lan cable") !== false ||
    strpos($message, "network cable") !== false
) {
    $equipment = "LAN Cable";
} elseif (strpos($message, "hdmi") !== false) {
    $equipment = "HDMI Cable";
}

// Detect date
if (strpos($message, "tomorrow") !== false) {
    $date = "Tomorrow";
} elseif (strpos($message, "today") !== false) {
    $date = "Today";
}

// Detect time
if (strpos($message, "morning") !== false) {
    $time = "Morning";
} elseif (strpos($message, "afternoon") !== false) {
    $time = "Afternoon";
} elseif (strpos($message, "evening") !== false) {
    $time = "Evening";
}

// Generate reply
if ($equipment) {

    $reply = "I found your request for a " . $equipment;

    if ($date) {
        $reply .= " on " . $date;
    }

    if ($time) {
        $reply .= " in the " . strtolower($time);
    }

    $reply .= ". Please check the available equipment or submit a borrowing request.";

} else {

    $reply = "I can help you search for campus equipment, post equipment, or request to borrow equipment.";
}

echo json_encode([
    "success" => true,
    "message" => $message,
    "detected_equipment" => $equipment,
    "detected_date" => $date,
    "detected_time" => $time,
    "reply" => $reply
]);

?>