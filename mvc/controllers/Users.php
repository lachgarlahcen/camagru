<?php
 
class  Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function validate_register(&$data)
    {
        $error = 0;
        //VALIDATE THE EMAIL
        if (empty($data['email']))
        {
            $data['email_err'] = 'Plese Enter A Email !!';
            $error++;
        }
        //validate name
        if (empty($data['username']))
        {
            $data['username_err'] = 'Plese Enter A Username !!';
            $error++;
        }
        else
        {
            //check that username is uniqe
            if ($this->userModel->findUserByUsename($data['username']))
            {
                $data['username_err'] = 'Username is already exist';
                $error++;
            }
        }
        //validate password
        if (empty($data['password']))
        {
            $data['password_err'] = 'Plese Enter A Password!!';
            $error++;
        }
        else if (strlen($data['password'] < 6))
        {
            $data['password_err'] = 'Password Must Be At Least 6 Caracters';
            $error++;
        }
        // check 
        if (empty($data['confirm_password']))
        {
            $data['confirm_password_err'] = 'Plaese confirm password !!';
            $error++;
        }
        else if ($data['confirm_password'] != $data['password'])
        {
            $data['confirm_password_err'] = 'Passwords Do Not Match';
            $error++;
        }
        return $error;
    }
    public function validate_login(&$data)
    {
        $error = 0;
        //validate name
        if (empty($data['username']))
        {
            $data['username_err'] = 'Plese Enter Your Username !!';
            $error++;
        }
        //validate password
        if (empty($data['password']))
        {
            $data['password_err'] = 'Plese Enter Your Password!!';
            $error++;
        }
        return $error;
    }
    public function register()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //prossess the form
            //sanitize the data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $error = $this->validate_register($data);
            if(!$error)
            {
                //validated
                //hack password
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                //register user
                if ($this->userModel->register($data))
                {
                    //succsess
                    redirect('users/login');
                }
                else
                {
                    die('somthing went Worng');
                }
            }
            else{
                
                $this->view('users/register', $data);
            }
        }
        else
        {
            //init data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //load view
            $this->view('users/register', $data);
           
        }
    }
    public function login()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //prossess the form
            //sanitize the data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => ''
            ];
            $error = $this->validate_login($data);
            if(!$error)
            {
                //validated
                die('sucssess');
            }
            else{
                
                $this->view('users/login', $data);
            }

        }
        else
        {
            //init data
            $data = [
                'username' => '',
                'password' => '',

                'username_err' => '',
                'password_err' => '',
            ];
            //load view
            $this->view('users/login', $data);
           
        }
    }
}