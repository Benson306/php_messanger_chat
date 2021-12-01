
<?php
require("connection.php");
	session_start();
	if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $receiver_email = $_SESSION['sender_session'];

        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <!--  <meta http-equiv="refresh" content="20"> refresh page after 20 secs -->
    <link href="style3.css" rel="stylesheet">
    <title>Chat Inbox</title>

    
</head>
<body>
    <br>
<a href="logout.php" class="btn1">Logout (<?php echo $email?>)</a>
<br>
<a href="message.php" class="btn2">Leave Chat</a>
    
        <br>
<div class="chat">
    <div class="header">
        Inbox
    </div>
    <div class="body" id="body">
            <?php 

            $sql = "SELECT * FROM (SELECT * FROM messages c WHERE c.receiver = '$email' AND c.sender = '$receiver_email' UNION SELECT d.* FROM messages d WHERE d.receiver = '$receiver_email' AND d.sender = '$email'  ORDER BY time DESC LIMIT 5) Var1 ORDER BY time ASC; ";
           
            $run = mysqli_query($conn, $sql);
            while( $rows= mysqli_fetch_assoc($run) ) {
                if($email == $rows['sender']){
                    echo "
                
                <div class='result'>
                <font color='maroon'><u><i>$rows[sender]: </u></i></font>
                <br>
                <font color='cornsilk'>$rows[message] </font>
                <hr>
                <font size='2'><i>$rows[time]</i></font>
            
                <br>
                </div>
                </table>
                
                ";
                }else if($email != $rows['sender']){
                    echo "
                <div class='result2'>
                <font color='maroon'><u><i>$rows[sender]: </u></i></font>
                <br>
                <font color='cornsilk'>$rows[message] </font>
                <hr>
                <font size='2'><i>$rows[time]</i></font>
            
                <br>
                </div>
                
                ";
                }
                
            }
            ?>

    </div>
    <div class="footer">
        <form> 
            <input type="text" placeholder="Text Message" class="send_message" name="send_message" required>
            <input type="submit" name="reply_btn" class="reply_btn" value="Send">
        </form>
    </div>
</div>  



</body>
</html>

<?php 
if(isset($_GET['reply_btn'])){
    $message =  mysqli_real_escape_string($conn, $_GET['send_message']);
    //$receiver_
    $sender_email = $email;
    $send_sql = "INSERT INTO messages(message, sender, receiver, been_read) VALUES('$message','$sender_email', '$receiver_email', 0)";
    if(mysqli_query($conn, $send_sql)){
        ?>
        <script>
           window.location="chat.php";
        </script>
        <?php
    }
}
?>



<?php } else{ ?>
		<script>window.alert("You have not Logged in");window.location="index.php";</script>
	<?php }

?>
<script> 
$(document).ready(function(){
setInterval(function(){
    $("#body").load(" #body > *");
}, 5000);
});
</script>
<script>
   $(document).ready(function(){
    $('#chats').animate({scrollTop:1000000},800);
   });
</script>