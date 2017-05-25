<?php
include_once (ROOT.'/models/Artists.php');

class ArtistsController
{

    public function actionIndex(){

        require_once (ROOT.'/views/artists/index.php');
        return true;
    }

    public function actionJoin() {
        if(!isset($_COOKIE["Authorized"])) {
            header('Refresh: 2, /welcome');
            print_r("Пожалуйста, авторизуйтесь чтобы добавлять изображения!");
        } else {
            require_once(ROOT.'/views/artists/join.php');
        }

        return true;
    }

    public function actionUpload() {

        Artists::uploadImage();
        return true;
    }
}