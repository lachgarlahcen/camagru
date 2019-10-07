<?php
 
class  Users extends Controller
{
    public function __constract()
    {

    }

    public function register()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //prossess the form 
        }
        else
        {
            //init data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //load view
            $this->view('users/register', $data);
           
        }
    }
}