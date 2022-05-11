<?php
$target_dir = "img/";
$target_file = $target_dir. basename($_FILES["file"]["name"]);
$uploadOk = 1;

if(isset($_POST["upload"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
    }
  }
if($uploadOk == 1){
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        echo $target_file;
    }else{
        echo 0;
    }
}

?>