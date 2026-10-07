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

if (strpos($message, "projector") !== false) {
    $equipment = "Projector";
} elseif (strpos($message, "speaker") !== false) {
    $equipment = "Speaker";
} elseif (strpos($message, "lan cable") !== false || strpos($message, "network cable") !== false) {
    $equipment = "LAN Cable";
} elseif (strpos($message, "hdmi") !== false) {
    $equipment = "HDMI Cable";
}

if ($equipment) {
    $reply = "I can help you find a " . $equipment . ". Please check the available equipment or submit a borrowing request.";
} else {
    $reply = "I can help you search for campus equipment, post equipment, or request to borrow equipment.";
}

echo json_encode([
    "success" => true,
    "message" => $message,
    "detected_equipment" => $equipment,
    "reply" => $reply
]);

?>