<?php 
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if(!empty($message)){
        $sql = mysqli_query($conn, "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg, timestamp)
                                    VALUES ({$outgoing_id}, {$incoming_id}, '{$message}', NOW())") or die(mysqli_error($conn));
    }
}else{
    header("location: ../view/login.php");
}    
?>
