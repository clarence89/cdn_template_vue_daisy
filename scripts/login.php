<?php
header('Content-Type: application/json');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

$response = array();

include("config.php");
ob_start();
include("auth.php");

if ($_SESSION['iuid']) {
    if ($_SESSION['iupriv'] == 1 || $_SESSION['iupriv'] == 0) {
        $response["redirect"] = "dashboard.php";
    } else {
        $response["error"] = "Invalid user privilege.";
    }
    echo json_encode($response);
    exit;
}

if ($_POST['username'] && $_POST['password']) {
    if ($_SESSION['logctr'] > 10) {
        $response["error"] = "Maximum login attempts exceeded.";
    } else {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password'];
        $result = $conn->query("SELECT * FROM students WHERE username='$username' AND deleted_at IS NULL");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['iuid'] = $row['id'];
                $_SESSION['stud_id'] = $row['student_id_number'];
                $_SESSION['ifname'] = $row['first_name'];
                $_SESSION['iupriv'] = $row['user_privilege'];
                if ($_POST['chkremember'] == '1') {
                    $_SESSION['iremember'] = 1;
                    setcookie('hrem', $_SESSION['iuid'], time() + (3600 * 60), '/');
                    setcookie('hrei', base64_encode($_SESSION['ifname']), time() + (3600 * 60), '/');
                    setcookie('hrep', base64_encode($_SESSION['iupriv']), time() + (3600 * 60), '/');
                }
                $response["redirect"] = "index.php";
            } else {
                $response["error"] = "Incorrect password.";
            }
        } else {
            if (!isset($_SESSION['logctr']))
                $_SESSION['logctr'] = 0;
            $_SESSION['logctr']++;
            if ($_SESSION['logctr'] > 10) {
                $response["error"] = "Maximum login attempts exceeded.";
            } else {
                $response["error"] = "Incorrect username.";
            }
        }
    }
} else {
    $response["error"] = "Username and password are required.";
}

echo json_encode($response);
ob_end_flush();
