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
    

    /************
    REGISTER FUNCTIONS
    ************/

    public function validate_register(&$data)
    {
        $error = 0;
        //VALIDATE THE EMAIL
        if (empty($data['email']))
        {
            $data['email_err'] = 'Plese Enter A Email !!';
            $error++;
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            $data['email_err'] = 'Please entre a valid email';
            $error++;
        }
        else if ($this->userModel->findUserByEmail($data['email']))
        {
            $data['email_err'] = 'Email is already exist';  
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
            if (strlen($data['username']) <= 4 || strlen($data['username']) > 20)
            {
                $data['username_err'] = 'Name should be between 5 and 20 characters';
                $error++;
            }
        }
        //validate password
        if (empty($data['password']))
        {
            $data['password_err'] = 'Plese Enter A Password!!';
            $error++;
        }
        else  
        {
            $uppercase = preg_match('@[A-Z]@', $data['password']);
            $lowercase = preg_match('@[a-z]@', $data['password']);
            $number    = preg_match('@[0-9]@', $data['password']);
            $specialChars = preg_match('@[^\w]@', $data['password']);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($data['password']) < 8)
            {
                $data['password_err'] = 'Password should be at least 8 lenght and include at least one upper case letter, one number or one special character.';
                $error++;
            };
        }
        // conferm password
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
                'username' => isset($_POST['username']) ? trim($_POST['username']) :'',
                'email' => isset($_POST['email'])? trim($_POST['email']) : '',
                'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                'confirm_password' => isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $error = $this->validate_register($data);
            if(!$error)
            {
                //validated
                //hash password
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                //register user
                if ($this->userModel->register($data))
                {
                    $this->userModel->userVerification($data['email']);
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
    /************
    REGISTER FUNCTIONS ENDED
    ************/


    /************
    LOGING FUNCTIONS
    ************/
    
    public function validate_login(&$data)
    {
        $error = 0;
        
        //validate username
        if (empty($data['username']))
        {
            $data['username_err'] = 'Plese Enter Your Username !!';
            $error++;
        }
        else {
            $user = $this->userModel->findUserByUsername($data['username']);
            if (!$user)
            {
                $data['error'] = 'Username or password is Incorrect.';
                $error++;
            }
        }
        //validate password
        if (empty($data['password']))
        {
            $data['password_err'] = 'Plese Enter Your Password!!';
            $error++;
        }
        return $error;
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
                'username' => isset($_POST['username']) ? trim($_POST['username']) : '',
                'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                'username_err' => '',
                'password_err' => '',
                'error' => ''
            ];
            $error = $this->validate_login($data);
            if(!$error)
            {
                //validated
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if ($loggedInUser)
                {
                    if($loggedInUser->is_verfied == 0)
                    {
                        $data['error'] = 'Please verfie your email then login.';
                        $this->view('users/login', $data);
                    }
                    else
                        $this->craeteUserSession($loggedInUser);
                }
                else
                {
                    $data['error'] = 'Username or password is Incorrect';
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
                'error' => ''
            ];
            //load view
            $this->view('users/login', $data);
           
        }
    }
    /************
    LOGING FUNCTIONS ENDED
    ************/


    /************
    VERIFICATION FUNCTIONS 
    ************/
    public function wverification($token = 1)
    {
        if ($row = $this->userModel->verifieToken($token))
        {
            flash('register_success', 'YOUR EMAIL IS VERIFIED YOU CAN LOGIN NOW.');
            redirect('users/login');
        }
        else {
            $this->view('inc/404');
        }
    }
    /************
    VERIFICATION FUNCTIONS ENDED
    ************/

    /************
    RECOVER PASS FUNCTIONS
    ************/
    
    public function wrecover()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // init data
            $data = [
                'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
                'error' => '',
            ];
            if (empty($data['email']))
            {
                $data['error'] = 'Please entre your email';
            }else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            {
                $data['error'] = 'Please entre a valide email.'; 
            }
            else
            {
                $user = $this->userModel->findUserByEmail($data['email']);
                if (!$user)
                {
                    $data['error'] = "No user with that email.";
                    $this->view('users/recover',$data);
                }
                else
                {
                        if ($this->userModel->passwordRecover($user->email))
                        {
                            flash('register_success', 'We Send You a Mail To Recover Your Password.');
                            redirect('users/login');
                        }
                        else
                        {
                            $data['error'] = "Somthing Went Wrong please try again.";
                            $this->view('users/recover',$data);
                        }
                }
            }
            $this->view('users/recover',$data);
        }
        else {
            //if get load view
            $data = [
                'email' => '',
                'error' => '',
            ];
            $this->view('users/recover',$data);
    }
    }

    /************
    RECOVER PASS FUNCTIONS ENDED
    ************/

    /************
    RESET PASSWORD FUNCTIONS
    ************/
    public function validate_newpassword(&$data)
    {
        $error = 0;
        if (empty($data['password']))
        {
            $data['password_err'] = 'please enter a password.';
            $error++;
        }
        else
        {
            $uppercase = preg_match('@[A-Z]@', $data['password']);
            $lowercase = preg_match('@[a-z]@', $data['password']);
            $number    = preg_match('@[0-9]@', $data['password']);
            $specialChars = preg_match('@[^\w]@', $data['password']);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($data['password']) < 8)
            {
                $data['password_err'] = 'Password should be at least 8 lenght and include at least one upper case letter, one number or one special character.';
                $error++;
            }
        }
        if ($data['password'] != $data['password2'])
        {
            $data['password2_err'] = 'Please Confirm Password.';
            $error++;
        }
        return $error;
    }

    public function wresetpassword($token = 1)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // sanitize data 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // init data 
            $data = [
                'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                'password2' => isset($_POST['password2']) ? trim($_POST['password2']) : '',
                'password_err' => '',
                'password2_err' => ''
            ];

            $error = $this->validate_newpassword($data);
            if (!$error)
            {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->resetPassword($data['password']))
                {
                    flash('register_success', 'You Can Log In With Your new Password');
                    redirect('users/login');
                }
                else
                    die ('Something Goes Wrong');
            }
            else
                $this->view('users/resetpassword', $data);
        } 
        else
        {
            if ($row = $this->userModel->checkToken($token))
             {
                 $data = [
                     'password' => '',
                     'password2' => '',
                     'password_err' => '',
                     'password2_err' => ''
                 ];
                $this->view('users/resetpassword',$data);
             }
             else
             {
                $this->view('inc/404');
             }
        }
    }
    /************
    RESET PASSWORD FUNCTIONS ENDED
    ************/

    /************
    SETTING AND IFO EDIT FUNCTIONS ENDED
    ************/
    public function validate_settings(&$data, $post)
    {
        $error = 0;
        //VALIDATE USERNAME SeTTING
        if(!isset($post['username']) || empty($post['username']))
        {
            $data['username_err'] = "please fill your username.";
            $error++;
        }
        else
        {
            //check that username is uniqe
            if ($this->userModel->findUserByUsername($post['username']) && $post['username'] != $_SESSION['user_name'])
            {
                $data['username_err'] = 'Username is already exist';
                $error++;
            }
            if (strlen($post['username']) <= 4 || strlen($post['username']) > 20)
            {
                $data['username_err'] = 'Name should be between 5 and 20 characters';
                $error++;
            }
        }
        //Vlidate EMAIL For settings
        if (!isset($post['email']) || empty($post['email']))
        {
            $data['email_err'] = 'Plese Enter A Email !!';
            $error++;
        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
        {
            $data['email_err'] = 'Please entre a valid email';
            $error++;
        }
        else if ($this->userModel->findUserByEmail($post['email']) && $post['email'] != $_SESSION['user_email'])
        {
            $data['email_err'] = 'Email is already exist';  
            $error++;
        }

        if (!isset($post['confirm_password']) || empty($post['confirm_password']))
        {
            $data['confirm_password_err'] = 'please fill password';
            $error++;
        }
        else if (!($loggedInUser = $this->userModel->login($_SESSION['user_name'], $post['confirm_password'])))
        {
            $data['confirm_password_err'] = 'Password Incorect.';
            $error++;
        }
        if (isset($post['notifications']) && $post['notifications'] == 'yes')
        {
            $data['notifications'] = 1;
        }
        else
        {
            $data['notifications'] = 0;   
        }
        // NEW PASSWORD VALIDATION
        if (!isset($post['password']))
        {
            $data['new_password_err'] = 'please fill the new password.';
            $error++;
        }
        else if (!empty($post['password']))
        {
            $uppercase = preg_match('@[A-Z]@', $post['password']);
            $lowercase = preg_match('@[a-z]@', $post['password']);
            $number    = preg_match('@[0-9]@', $post['password']);
            $specialChars = preg_match('@[^\w]@', $post['password']);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($post['password']) < 8)
            {
                $data['new_password_err'] = 'Password should be at least 8 lenght and include at least one upper case letter, one number or one special character.';
                $error++;
            };
        }

        if (!isset($post['password2']))
        {
            $data['confirm_password2_err'] = "please confirm password";
            $error++;
        }
        else if (!empty($post['password2']))
        {
            if ($post['password2'] != $post['password'])
            {
                $data['confirm_password2_err'] = "Passwords don't match";
                $error++;
            }
        }

        return $error;
    }

    public function wsettings()
    {
        if (!$this->isLoggedIn())
        {
            redirect('users/login');
            return ;
        }
        $user = $this->userModel->findUserByEmail($_SESSION['user_email']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // sanitize data 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => $user->username,
                'email' => $user->email,
                'new_password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',  
                'confirm_password_err' => '',
                'new_password_err' => '',
                'confirm_password2_err' => '',
                'notifications' => $user->is_notifi
            ];
            $error = $this->validate_settings($data, $_POST);
            if (!$error)
            {
                $data['username'] = $_POST['username'];
                $data['email'] = $_POST['email'];
                $data['new_password'] = empty($_POST['password']) ? $user->password : password_hash($_POST['password'], PASSWORD_DEFAULT) ;
                if ($this->userModel->updateUser($data))
                {
                    $this->craeteUserSession($this->userModel->findUserByEmail($data['email']));
                    flash('settings_message', 'info updated successfuly', 'alert alert-success text-center');
                }
                else
                {
                    flash('settings_message', 'somthing wrong happend', 'alert alert-danger text-center');
                }
                redirect('users/settings');
            }
            else
                $this->view('users/settings',$data);
        }
        else
        {
            $data = [
                'username' => $user->username,
                'email' => $user->email,
                'confirm_password' => '',
                'new_password_err' => '',
                'confirm_password2_err' => '',
                'username_err' => '',
                'email_err' => '',  
                'confirm_password_err' => '',
                'notifications' => $user->is_notifi
            ];
            //Load view
            $this->view('users/settings',$data);
        }
    }
    /************
    SETTING AND IFO EDIT FUNCTIONS ENDED
    ************/
    
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