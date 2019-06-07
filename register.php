<!doctype html>
<html>
<head
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Cinzel|Shadows+Into+Light" rel="stylesheet">
<title>Register</title>
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

    <center><h1>MORALE BOOST REGISTRATION</h1></center>

   <div align="center">
      <p> <a href="index.php">Login</a></p>
<form action="" method="POST">

Username: <input type="text" name="user"><br /><br />
Password: <input type="password" name="pass"><br /><br />
<input type="submit" value="Register" name="submit" />

</form>
</div>
<?php
include 'connect.php';
$conn = OpenCon();
if(isset($_POST["submit"])){
if(!empty($_POST['user']) && !empty($_POST['pass'])) {
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $query=mysqli_query($conn,"SELECT * FROM login WHERE username='".$user."'");
    $numrows=mysqli_num_rows($query);
    if($numrows==0)
    {
    $result=mysqli_query($conn,"INSERT INTO login(username,password) VALUES('$user','$pass')");
        if($result){
    echo "Account Successfully Created";
    } else {
    echo "Failure!";
    }

    } else {
    echo "That username already exists! Please try again with another.";
    }

} else {
    echo "All fields are required!";
}
}
?>
</body>
</html>
