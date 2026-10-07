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
    empty($data["equipment_id"]) ||
    empty($data["borrower_name"]) ||
    empty($data["borrow_date"])
) {
    echo json_encode([
        "success" => false,
        "message" => "Please provide equipment ID, borrower name, and borrow date."
    ]);
    exit;
}

$request = [
    "request_id" => rand(1000, 9999),
    "equipment_id" => $data["equipment_id"],
    "borrower_name" => $data["borrower_name"],
    "borrow_date" => $data["borrow_date"],
    "status" => "Pending"
];

echo json_encode([
    "success" => true,
    "message" => "Borrow request submitted successfully.",
    "request" => $request
]);

?>