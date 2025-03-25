<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    // Lấy trạng thái hoạt động của người nhận
    $status_query = mysqli_query($conn, "SELECT status FROM users WHERE unique_id = {$incoming_id}");
    $status_row = mysqli_fetch_assoc($status_query);
    $incoming_status = $status_row['status'];

    // Lấy tin nhắn giữa hai người
    $sql = "SELECT messages.*, 
                   sender.img AS sender_img, sender.unique_id AS sender_id, 
                   receiver.img AS receiver_img, receiver.unique_id AS receiver_id 
            FROM messages
            LEFT JOIN users AS sender ON sender.unique_id = messages.outgoing_msg_id
            LEFT JOIN users AS receiver ON receiver.unique_id = messages.incoming_msg_id
            WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) 
               OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
            ORDER BY timestamp ASC";

    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $full_datetime = date("l, d M Y - H:i", strtotime($row['timestamp']));
            $message_content = htmlspecialchars($row['msg']);
            $image_content = "";

            // Nếu tin nhắn có ảnh, hiển thị hình ảnh
            if (!empty($row['image_url'])) {
                $image_path = htmlspecialchars($row['image_url']);
                $image_content = '<img src="../php/' . $image_path . '" class="chat-image" alt="Chat Image">';
            }

            if ($row['outgoing_msg_id'] == $outgoing_id) {
                // Tin nhắn do người dùng hiện tại gửi
                $output .= '<div class="chat outgoing">
                                <div class="details" data-tooltip="' . $full_datetime . '">
                                    ' . (!empty($image_content) ? $image_content : '<p>' . $message_content . '</p>') . '
                                </div>
                            </div>';
            } else {
                // Tin nhắn nhận từ người khác
                $output .= '<div class="chat incoming">
                                <img src="../php/images/' . htmlspecialchars($row['sender_img']) . '" class="chat-avatar" alt="Avatar">
                                <div class="details" data-tooltip="' . $full_datetime . '">
                                    ' . (!empty($image_content) ? $image_content : '<p>' . $message_content . '</p>') . '
                                </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages available. Start a conversation now!</div>';
    }

    // Cập nhật trạng thái hoạt động
    $output .= "<script>document.querySelector('.chat-area header p').textContent = '" . $incoming_status . "';</script>";

    echo $output;
} else {
    header("location: ../login.php");
}
