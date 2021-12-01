<?php 
require("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="style3.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <div class="header1">
       <h2>Login</h2>
    </div>
        <form  class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control">
                <br>
                <label>Password:</label>
                <input type="password" name="password" class="form-control">
                <br>
                <input type="submit" class="btn" value="Login" name="submit">
        </form>

</div>
</body>
</html>
<?php
if(isset($_GET['submit'])){
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $password = mysqli_real_escape_string($conn, $_GET['password']);

    $sql= "SELECT * FROM login WHERE email='$email'";
    $run = mysqli_query($conn,$sql);
    $count= mysqli_num_rows($run);
    $rows=mysqli_fetch_assoc($run);
    $passcode=$rows['password'];

    if($count>0){
        if($password==$passcode){
            ?><script>window.location="message.php";</script> <?
            session_start();
		    $_SESSION['email']=$email;
        }else{
            ?><script>window.alert("Password is incorrect");</script> <?php
        }
    }else{ 
        ?><script>window.alert("User Does Not Exist");</script> <?php
    }
    
    }
    ?>