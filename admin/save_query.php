<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false]);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$service = trim($_POST['service'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$phone) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$file = __DIR__ . '/queries.json';
$queries = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($queries)) $queries = [];

$queries[] = [
    'id'      => uniqid(),
    'name'    => htmlspecialchars($name),
    'phone'   => htmlspecialchars($phone),
    'email'   => htmlspecialchars($email),
    'service' => htmlspecialchars($service),
    'message' => htmlspecialchars($message),
    'time'    => date('d M Y, h:i A'),
    'read'    => false,
];

file_put_contents($file, json_encode($queries, JSON_PRETTY_PRINT));
echo json_encode(['success' => true]);
