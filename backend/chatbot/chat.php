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
$purpose = null;

// Mock equipment data
$availableEquipment = [
    [
        "id" => 1,
        "name" => "Epson Projector",
        "category" => "Projector",
        "condition" => "Good",
        "availability" => "Available",
        "location" => "RTU Pasig Campus"
    ],
    [
        "id" => 2,
        "name" => "LAN Cable",
        "category" => "Networking",
        "condition" => "Good",
        "availability" => "Available",
        "location" => "RTU Pasig Campus"
    ],
    [
        "id" => 3,
        "name" => "JBL Speaker",
        "category" => "Audio Equipment",
        "condition" => "Good",
        "availability" => "Borrowed",
        "location" => "RTU Pasig Campus"
    ]
];

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

// Detect purpose
if (strpos($message, "presentation") !== false) {
    $purpose = "Presentation";
} elseif (strpos($message, "project") !== false) {
    $purpose = "Project";
} elseif (strpos($message, "report") !== false) {
    $purpose = "Report";
} elseif (strpos($message, "class") !== false) {
    $purpose = "Class";
} elseif (strpos($message, "event") !== false) {
    $purpose = "Event";
}

// Find available equipment
$recommendation = null;

foreach ($availableEquipment as $item) {

    if (
        $equipment &&
        $item["category"] === $equipment &&
        $item["availability"] === "Available"
    ) {
        $recommendation = $item;
        break;
    }
}

// Generate reply
if ($recommendation) {

    $reply = "I found an available " .
        $recommendation["name"] .
        " at " .
        $recommendation["location"] . ".";

} elseif ($equipment) {

    $reply = "I could not find an available " .
        $equipment .
        " right now.";

} else {

    $reply = "I can help you search for campus equipment, post equipment, or request to borrow equipment.";
}

echo json_encode([
    "success" => true,
    "message" => $message,
    "detected_equipment" => $equipment,
    "detected_date" => $date,
    "detected_time" => $time,
    "detected_purpose" => $purpose,
    "recommendation" => $recommendation,
    "reply" => $reply
]);

?>