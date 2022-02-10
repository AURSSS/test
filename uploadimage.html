<?php
session_start();

require("connection.php");
require("functions.php");

error_reporting(1);

$user_data = check_login($conn);


$filename = $_FILES["fileToUpload"]["name"];

$file_new = uniqid('img_',$filename).time();
$extension  = strtolower(pathinfo( $filename, PATHINFO_EXTENSION ));
$basename   = $file_new . "." . $extension;
$target_dir = "uploads/".$basename;
$uploadOk = 1;


$default_img = "uploads/default.jpg";

if(file_exists($target_dir)){
  $profile_picture = $target_dir;
}else{
  $profile_picture = $default_img;
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($filename)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($extension != "jpg" && $extension != "png" && $extension != "jpeg"
&& $extension != "gif" ) {
  echo "Sorry, only jpg, jpeg, png & gif files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir)) {
    $namefile = $_FILES["fileToUpload"]["name"];
    $wid = $_SESSION['user_id'];

    $sql = "UPDATE wuser SET img_dir=? WHERE wid=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$target_dir, $wid]);

    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

echo $user_data['image'];
?>

<!DOCTYPE html>
<html>
<body>

<form action="uploadimage.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
  <?php
echo "<img src='".$target_dir."'>";
?>
</form>

</body>
</html>