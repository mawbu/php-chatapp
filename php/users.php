<?php
session_start();
include_once "config.php";

if(isset($_SESSION['unique_id'])){
    $outgoing_id = $_SESSION['unique_id'];

    // Cập nhật trạng thái khi user hoạt động
    $status = "Active now";
    mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$outgoing_id}");

    // Lấy danh sách user trừ user hiện tại
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";

    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }

    // Truy vấn trạng thái của chính user
    $self_sql = "SELECT status FROM users WHERE unique_id = {$outgoing_id}";
    $self_query = mysqli_query($conn, $self_sql);
    if ($self_row = mysqli_fetch_assoc($self_query)) {
        $output .= "<span id='self-status' data-status='{$self_row['status']}'></span>";
    }

    echo $output;
} else {
    echo "No session found";
}
?>