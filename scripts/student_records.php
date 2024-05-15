<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require 'config.php'; // Assuming 'config.php' contains your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create
    if (isset($_POST['create'])) {
        $student_id_number = $_POST['student_id_number'];
        $rfid = $_POST['rfid'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        $sql = "INSERT INTO students (student_id_number, rfid, first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $student_id_number, $rfid, $first_name, $last_name, $email, $username, $password);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Update
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $student_id_number = $_POST['student_id_number'];
        $rfid = $_POST['rfid'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $sql = "UPDATE students SET student_id_number = ?, rfid = ?, first_name = ?, last_name = ?, email = ?, username = ?, password = ? WHERE id = ? AND deleted_at IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $student_id_number, $rfid, $first_name, $last_name, $email, $username, $password, $id);
        } else {
            $sql = "UPDATE students SET student_id_number = ?, rfid = ?, first_name = ?, last_name = ?, email = ?, username = ? WHERE id = ? AND deleted_at IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $student_id_number, $rfid, $first_name, $last_name, $email, $username, $id);
        }

        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Soft Delete
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "UPDATE students SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Restore
    if (isset($_POST['restore'])) {
        $id = $_POST['id'];

        $sql = "UPDATE students SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Record restored successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Read
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);

    if ($result) {
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode($students);
    } else {
        echo "Error: " . $conn->error;
    }
}
