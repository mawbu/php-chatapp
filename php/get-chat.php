<?php 
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

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
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            // Lấy đúng ảnh của người gửi
            $user_img = ($row['outgoing_msg_id'] == $outgoing_id) ? $row['sender_img'] : $row['receiver_img'];

            if($row['outgoing_msg_id'] === $outgoing_id){
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>'. htmlspecialchars($row['msg']) .'</p>
                            </div>
                            </div>';
            }else{
                $output .= '<div class="chat incoming">
                            <img src="../php/images/'.$user_img.'" alt="">
                            <div class="details">
                                <p>'. htmlspecialchars($row['msg']) .'</p>
                            </div>
                            </div>';
            }
        }
    }else{
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }
    echo $output;
}else{
    header("location: ../login.php");
}
?>
