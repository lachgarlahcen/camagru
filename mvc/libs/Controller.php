<?php

/*
base Controller 
load the models and views
*/

class Controller
{
    public function model($model) 
    {
        require_once '../mvc/models/'.$model.'.php';
        return new $model();
    }

    //load View
    public function view($view, $data = [])
    {
        //check for the view file 
        if (file_exists('../mvc/views/'. $view . '.php'))
        {
            require_once '../mvc/views/'. $view . '.php';
        }
        else
            {
                echo "404 error";
            }
    }
}