<?php
require("connection.php");
	session_start();
	if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style3.css" rel="stylesheet">
    <title>Chat Box</title>
        <!-- bootstrap -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- icons -->
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


<!-- End of bootsrap -->

</head>
<body>
    <br>
        <a href="logout.php" class="btn1">Logout (<?php echo $email?>)</a>
        <br>
        <br>
        <br>
    <div class="inbox">
        <div class="messages">
            <h3>Recent Chats</h3>

            <?php

       // $message_sql = "SELECT * FROM messages WHERE receiver = '$email' GROUP BY sender ORDER BY time DESC";
     $message_sql2="SELECT
                                    *
                                FROM
                                    messages 
                                    JOIN(
                                            SELECT
                                                MAX(time) AS maxTime,
                                                sender
                                            FROM
                                                messages
                                            GROUP BY
                                                sender
                                        ) AS Latest
                                    ON messages.time=Latest.maxTime
                                    AND messages.sender=Latest.sender
                                    WHERE receiver = '$email'
                                    ORDER BY time DESC LIMIT 10";

	 $run = mysqli_query($conn, $message_sql2);

		 echo "
		 <table class='table table-condensed'>
	 			<thead>
	 				<tr>
	 					<th>S.No.</th>
	 					<th>From:</th>
	 					<th>Message</th>
	 					<th>Received on:</th>
						 <th></th>
	 				</tr>
	 			</thead>
	 		<tbody>
		 "; 
		 $num = 1;
		 while($rows = mysqli_fetch_assoc($run) ) {
           $senda = $rows["sender"];
		 	echo "
		 		<tr>
		 		<td>$num</td>
		 		<td>$rows[sender]</td>
		 		<td>$rows[message]</td>
		 		<td>$rows[time]</td>
                
	 			<th><a href='message.php?sender_id=$rows[sender]' class='btn btn-primary'>Open Chat</button></a></th>
		 		</tr>
		 	";
		 $num++;
         if(isset($_GET['sender_id'])){
            $_SESSION['sender_session']=mysqli_real_escape_string($conn, $_GET['sender_id']);
           ?> <script>window.location="chat.php"</script><?php
        }
    
		 }
		
		 echo "</table>"; 
		?>

        

        </div>

        <div class="send">
            <h3>Start a Conversation</h3>
                <form class="form-group1">
                Recepients Email:
                 <input type="email" name="r_email" class="form-control1" placeholder="Recepients email" required>
                 <br>
                 Message:
                 <textarea name="content" class="form-control1" placeholder="Message" required></textarea>
                <br>
                <input type="submit" value="Send" class="send_btn"name="send">
                <br>
                 </form>
    
        </div>
    </div>
</body>
</html>


<?php } else{ ?>
		<script>window.alert("You have not Logged in");window.location="index.php";</script>
	<?php }

?>
<?php 
if(isset($_GET['send'])){
    $sender = $_SESSION['email'];
    $r_email = mysqli_real_escape_string($conn, $_GET['r_email']);
    $content = mysqli_real_escape_string($conn, $_GET['content']);
     $sql = "INSERT INTO messages(message, sender , receiver, been_read)VALUES('$content', '$sender','$r_email', 0)";
     
     ;
     if(mysqli_query($conn, $sql)){
        ?> 
        <script>
        alert("Message Sent!");
        window.location="message.php"; 
        </script>
        <?php
     }else{ ?>
     <script>
         alert("Message Not Sent!");
        window.location="message.php";
        </script>
        <?php
     }
}

?>

