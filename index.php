<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Cinzel|Shadows+Into+Light" rel="stylesheet">
<title>Login</title>
    <style>
        body{
    background-color: #000000;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpolygon fill='%23220000' points='1600 160 0 460 0 350 1600 50'/%3E%3Cpolygon fill='%23440000' points='1600 260 0 560 0 450 1600 150'/%3E%3Cpolygon fill='%23660000' points='1600 360 0 660 0 550 1600 250'/%3E%3Cpolygon fill='%23880000' points='1600 460 0 760 0 650 1600 350'/%3E%3Cpolygon fill='%23A00' points='1600 800 0 800 0 750 1600 450'/%3E%3C/g%3E%3C/svg%3E");
    background-attachment: fixed;
    background-size: cover;
    margin-top: 100px;
    margin-bottom: 100px;
    margin-right: 150px;
    margin-left: 80px;
    color: white;
    font-family: verdana;
    font-size: 100%

        }

 </style>

</head>
<body>
     <center><h1>MORALE BOOST LOGIN </h1></center>
<div align="center">
<p><a href="register.php">Register</a> </p>
<form action="" method="POST">
Username: <input type="text" name="user"><br /><br />
Password: <input type="password" name="pass"><br /><br />
<input type="submit" value="Login" name="submit" />
</form>
</div>
<?php
include 'connect.php';
$conn = OpenCon();
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $result=mysqli_query($conn,"SELECT * FROM login WHERE username='".$user."' AND password='".$pass."'");
    $numrows=mysqli_num_rows($result);
    if($numrows!=0)
    {
    while($row=mysqli_fetch_assoc($result))
    {
    $dbusername=$row['username'];
    $dbpassword=$row['password'];
    }

    if($user == $dbusername && $pass == $dbpassword)
    {
    session_start();
    $_SESSION['sess_user']=$user;

    /* Redirect browser */
    header("Location: morale.html");
    }
    } else {
    echo "Invalid username or password!";
    }

} else {
    echo "All fields are required!";
}
}
CloseCon($conn);
?>
</body>
</html>
