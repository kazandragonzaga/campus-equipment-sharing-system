<?php

header("Content-Type: application/json");

$search = $_GET["q"] ?? "";

$equipment = [
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

$results = [];

foreach ($equipment as $item) {

    if (
        stripos($item["name"], $search) !== false ||
        stripos($item["category"], $search) !== false
    ) {
        $results[] = $item;
    }
}

echo json_encode([
    "success" => true,
    "query" => $search,
    "results" => $results
]);

?>