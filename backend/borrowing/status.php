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

if (empty($data["request_id"]) || empty($data["status"])) {
    echo json_encode([
        "success" => false,
        "message" => "Please provide request ID and status."
    ]);
    exit;
}

$allowedStatuses = [
    "Pending",
    "Approved",
    "Borrowed",
    "Returned"
];

if (!in_array($data["status"], $allowedStatuses)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid borrowing status."
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Borrowing status updated successfully.",
    "request" => [
        "request_id" => $data["request_id"],
        "status" => $data["status"]
    ]
]);

?>