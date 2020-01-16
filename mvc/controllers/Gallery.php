<?php
class Gallery extends Controller {
    public function __construct()
    {
        //$this->galleryModel = $this->model('photo');
        $this->useryModel = $this->model('user');
    }
    public function windex()
    {
        //TODO somthing
        echo "index gallery";
    }
    /**********
        PHOTO FUNCTIONS
    *********/
    public function wphoto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = json_decode($_POST['data']);
            print_r($data->stickers);

        }
        else
        {
            $this->view('gallery/photo');
        }
    }
    /**********
        PHOTO FUNCTIONS ENDES
    *********/
}