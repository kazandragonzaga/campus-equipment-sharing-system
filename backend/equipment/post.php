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

if (
    empty($data["name"]) ||
    empty($data["category"]) ||
    empty($data["condition"]) ||
    empty($data["availability"])
) {
    echo json_encode([
        "success" => false,
        "message" => "Please provide all required equipment information."
    ]);
    exit;
}

$newEquipment = [
    "id" => rand(100, 999),
    "name" => $data["name"],
    "category" => $data["category"],
    "condition" => $data["condition"],
    "availability" => $data["availability"],
    "location" => $data["location"] ?? "RTU Pasig Campus"
];

echo json_encode([
    "success" => true,
    "message" => "Equipment posted successfully.",
    "equipment" => $newEquipment
]);

?>