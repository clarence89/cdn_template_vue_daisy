<?php
include("config.php");
ob_start();
include("auth.php");
if ($_SESSION['iuid']) {
    if ($_SESSION['iupriv'] == 1)
        header("location: dashboard.php");
    elseif ($_SESSION['iupriv'] == 0)
        header("location: dashboard.php");
    else
        header("location: dashboard.php");
    ob_end_flush();;
}
if ($_POST['username'] && $_POST['password']) {
    if ($_SESSION['logctr'] > 10)
        $errmsg = "Maximum login attempts exceeded";
    else {
        $username = $db->real_escape_string($_POST['username']);
        $password = $db->real_escape_string($_POST['password']);

        $result = $db->query("SELECT * FROM users WHERE username='$username'");
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['userpass'])) {
                $_SESSION['iuid'] = $row['userid'];
                $_SESSION['ifname'] = $row['fname'];
                $_SESSION['iupriv'] = $row['userprivilege'];
                if ($_POST['chkremember'] == '1') {
                    $_SESSION['iremember'] = 1;
                    setcookie('hrem', $_SESSION['iuid'], time() + (3600 * 60), '/');
                    setcookie('hrei', base64_encode($_SESSION['ifname']), time() + (3600 * 60), '/');
                    setcookie('hrep', base64_encode($_SESSION['iupriv']), time() + (3600 * 60), '/');
                }
                header("location: index.php");
                ob_end_flush();;
            } else {
                $errmsg = "Incorrect password";
            }
        } elseif ($row['userstatus'] != 0) {
            $errmsg = "User is not allowed to log in";
        } else {
            if (!$_SESSION['logctr'])
                $_SESSION['logctr'] = 0;
            $_SESSION['logctr'] = $_SESSION['logctr'] + 1;
            if ($_SESSION['logctr'] > 10)
                $errmsg = "Maximum login attempts exceeded";
            $errmsg = "Incorrect username";
        }
    }
}
