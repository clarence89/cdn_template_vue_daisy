<?php
header('Content-Type: application/json');
session_start();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'config.php';

    $rfid = $_POST["rfid"];
    $option = $_POST["option"];

    if (empty($rfid) || empty($option)) {
        $response["error"] = "RFID and option are required.";
        echo json_encode($response);
        exit;
    }

    $sql = "SELECT * FROM students WHERE rfid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rfid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        $sql = "INSERT INTO student_logs (student_id, type, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $student['id'], $option);
        $stmt->execute();

        $response["success"] = "Log inserted successfully.";
        echo json_encode($response);
        exit;
    } else {
        $response["error"] = "No student found with the provided RFID.";
        echo json_encode($response);
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once 'config.php';

    if (!isset($_GET["student_id"])) {
        $response["error"] = "Student ID is required for GET request.";
        echo json_encode($response);
        exit;
    }

    $student_id = $_GET["student_id"];

    $sql = "SELECT type, created_at FROM student_logs WHERE student_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $groupedLogs = [];

        foreach ($logs as $log) {
            $date = date('F j, Y', strtotime($log['created_at']));
            if (!isset($groupedLogs[$date])) {
                $groupedLogs[$date] = [];
            }
            $groupedLogs[$date][] = $log;
        }

        $response["student"] = $groupedLogs;
        echo json_encode($response);
        exit;
    } else {
        $response["error"] = "No student logs found with the provided ID.";
        echo json_encode($response);
        exit;
    }
}
