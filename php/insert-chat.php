<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : "";
    $image_url = ""; // Mặc định không có ảnh

    // Kiểm tra nếu có file được tải lên
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $img_name = $_FILES['file']['name'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($img_ext, $allowed_ext)) {
            $new_img_name = time() . "_" . uniqid() . "." . $img_ext;
            $upload_path = "images/" . $new_img_name;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
                $image_url = $upload_path;
                $message = ""; // Nếu là hình ảnh thì không cần lưu text
            }
        }
    }

    // Kiểm tra nếu có nội dung để lưu
    if (!empty($message) || !empty($image_url)) {
        $sql = "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg, image_url, timestamp)
                VALUES ({$outgoing_id}, {$incoming_id}, ?, ?, NOW())";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $message, $image_url);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die("Lỗi SQL: " . mysqli_error($conn));
        }

        mysqli_stmt_close($stmt);
    }
} else {
    header("location: ../view/login.php");
}
