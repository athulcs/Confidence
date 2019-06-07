
<?php
session_start();
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$audioFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
/*if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        echo "<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        echo "<br>";
        $uploadOk = 0;
    }
}*/
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    echo "<br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    echo "<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($audioFileType != "wav" && $audioFileType != "mp3" && $audioFileType != "ogg") {
    echo "Sorry, only WAV and MP3 files are allowed.";
    echo "<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    echo "<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
        $audioFile=basename( $_FILES["fileToUpload"]["name"]);
//        echo exec("/home/athul/server/env/bin/python audioAnalysis.py featureExtractionFile -i uploads/$audioFile -mw 1.0 -ms 1.0 -sw 0.050 -ss 0.050 -o uploads/$audioFile 2>&1");
        $out= exec("/home/athul/server/env/bin/python audioAnalysis.py classifyFile -i uploads/$audioFile --model randomforest --classifier model/ran 2>&1");
       $_SESSION["output"] = $out;
       header("Location: conf.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
        echo "<br>";
        print_r($_FILES);
    }
}
?>
