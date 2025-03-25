<?php
session_start();
include_once "config.php";

if (isset($_SESSION['unique_id'])) {
    $logout_id = $_SESSION['unique_id'];
    $status = "Offline now";

    // Kiểm tra nếu request được gửi từ beforeunload
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auto_logout'])) {
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$logout_id}'");
        exit(); // Không cần hủy session khi chỉ đóng trình duyệt
    }

    // Trường hợp người dùng click vào logout
    if (isset($_GET['logout_id'])) {
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$logout_id}'");
        if ($sql) {
            session_unset();
            session_destroy();
            header("location: ../view/login.php");
            exit();
        }
    } else {
        header("location: ../view/users.php");
        exit();
    }
} else {  
    header("location: ../view/login.php");
    exit();
}
?>