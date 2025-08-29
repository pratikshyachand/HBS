<?php
require_once "func.php";
header("Content-Type: application/json");

$conn = dbConnect();
$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'] ?? '';

if ($action === "list") {
    $res = $conn->query("SELECT id, name FROM tbl_amenities WHERE is_delete=0 ORDER BY id DESC");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
    exit;
}

if ($action === "add") {
    $name = trim($input['name'] ?? '');
    if (!$name) {
        echo json_encode(["success" => false, "message" => "⚠️ Amenity name required"]);
        exit;
    }

    // Check uniqueness
    $stmt = $conn->prepare("SELECT id FROM tbl_amenities WHERE name=? AND is_delete=0");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "⚠️ Amenity already exists"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO tbl_amenities (name, is_delete) VALUES (?, 0)");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    echo json_encode(["success" => true]);
    exit;
}

if ($action === "update") {
    $id = intval($input['id'] ?? 0);
    $name = trim($input['name'] ?? '');
    if (!$id || !$name) {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit;
    }

    // Check uniqueness
    $stmt = $conn->prepare("SELECT id FROM tbl_amenities WHERE name=? AND id!=? AND is_delete=0");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "⚠️ Amenity already exists"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tbl_amenities SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    echo json_encode(["success" => true]);
    exit;
}

if ($action === "delete") {
    $id = intval($input['id'] ?? 0);
    if (!$id) {
        echo json_encode(["success" => false, "message" => "Invalid ID"]);
        exit;
    }

    // Soft delete
    $stmt = $conn->prepare("UPDATE tbl_amenities SET is_delete=1 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(["success" => true]);
    exit;
}
?>
