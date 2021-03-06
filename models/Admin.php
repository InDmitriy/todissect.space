<?php


class Admin
{

    public static function login(){

        $db = Db::getConnection();

        $password = $_POST['password'];
        $login = $_POST['login'];
        $sql = $db->prepare('SELECT pass FROM kaichou WHERE login= ?');
        $sql->execute(array($login));
        foreach($sql as $row) {
            $hash = $row['pass'];
        }
        $passCheck = password_verify($password, $hash);

        if($passCheck) {
            setcookie("Name", $login, time()+60*15, '/panel', 'todissect.space');
            header('Location: /panel');
        } else {echo"Invalid Password";}

    }

    public static function authCheck(){
        if(!$_COOKIE["Name"]){
            header('Refresh: 0,Location: /admin');
        }
    }

    public function view(){



    }

public static function sendNewsData() {

    $db = Db::getConnection();
    $uploadDir = "img/";
    $target_file = $uploadDir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if($check !== false) {
//            echo "File is an image - " .$check["mime"] . ".";
            $uploadOk = 1;
        } else {
            header('Refresh: 3; Location: ../');
            echo "File is not an image.";
            $uploadOk = 0;
        }

    }
//check if file already exists
    if(file_exists($target_file)) {
        header('Refresh: 3; Location: ../');
        echo "Sorry, file already exists";
        $uploadOk = 0;
    }
//check file size
    if($_FILES["img"]["size"] > 5000000) {
        header('Refresh: 3; Location: ../');
        echo "Sorry, your file is too large";
        $uploadOk = 0;
    }
//defining allowed file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        header('Refresh: 3; Location: ../');
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
        $uploadOk = 0;
    }
    if($uploadOk == 0) {
        header('Refresh: 3; Location: ../');
        echo "Sorry, your file was not uploaded";
        //if everything is ok, try to upload file
    } else {
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            //echo "The file ". basename($_FILES["img_mini"]["name"]). " has been uploaded";
        } else {
            header('Refresh: 3; Location: ../');
            echo "Sorry, there was an error uploading your file";
        }
    }
//    print_r($_FILES);
    date_default_timezone_set('Europe/Moscow');
    $link = $_POST['link'];
    $link = str_replace(' ', '-', $link);
    $timestampPost = date("Y-m-d H:i:s");
    $postQuery = $db->prepare("INSERT INTO news(`id`, `title`, `link`, `img`, `s_descr`, `f_descr`, `timestamp`) VALUES ('', '".$_POST['title']."','".$link."','".$target_file."','".$_POST['s_descr']."','".$_POST['f_descr']."' ,'".$timestampPost."')");
    $postQuery->execute();
//    echo $target_file;
    header("Refresh: 2, ../panel");
    echo("News posted, redirecting to a main page<br>");
    echo("<a href='../panel'>Вернуться на главную страницу<a/>");

}

}