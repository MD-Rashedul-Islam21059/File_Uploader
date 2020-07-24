<?php

if(isset($_POST['madeBy'])){

    $count = 0;

    foreach($_FILES as $file){
        move_uploaded_file($file['tmp_name'], "uploadedFiles/".$file['name']);
        $count++;
    }
    if($count == 1){
        echo $file['name']." Is Successfully Uploaded.";
    }else{
        echo "$count Files Successfully Uploaded.";
    }
    
}

?>