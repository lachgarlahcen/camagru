<?php
 
class  Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function windex()
    {
        $this->view('inc/404');
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
            if ($this->userModel->findUserByUsername($data['username']))
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
        else if (!$this->userModel->findUserByUsername($data['username'])){
            $data['username_err'] = 'Username Dose Not exist !!';
        }
        //validate password
        if (empty($data['password']))
        {
            $data['password_err'] = 'Plese Enter Your Password!!';
            $error++;
        }
        return $error;
    }
    public function wregister()
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
                    flash('register_success', 'YOU ARE REGISTRED NOW JUST CONFIRM YOUR EMAIL TO LOGIN');
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
    public function wlogin()
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
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if ($loggedInUser)
                {
                    //create session
                    $this->craeteUserSession($loggedInUser);
                }
                else
                {
                    $data['password_err'] = 'Password Incorrect';
                    $this->view('users/login', $data);
                }
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
    public function craeteUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->username;
        redirect('pages/index');
    }
    public function wlogout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id']))
        {
            return  true;
        }
        else
        {
            return false;
        }
    }
}