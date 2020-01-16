<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // get user by username
    public function findUserByUsername($username)
    {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        //check row count
        if ($this->db->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //get user by email     
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        // check row
        if ($this->db->rowCount() > 0)
        {
            return $row;
        }else {
            return false;
        }
    }
    //register user
    public function register($data)
    {
        $this->db->query('INSERT INTO users (username, email, password,verification_key ) VALUES (:username, :email, :password, :verification_key)');
        $verification_key = md5(bin2hex(random_bytes(14)));
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':verification_key', $verification_key);
        return $this->db->execute();
    }
    //login user
    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();
        if (!$row)
            return false;
        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password))
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    /*
    SEND VIREFICATION TOKEN TO THE USER BY EMAIL
    */
    public function userVerification($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $user = $this->db->single();
        if ($this->db->rowcount() > 0)
        {
            $token = $user->verification_key;
            $message = "Your Activation Code is " .$token . "";
            $to = $user->email;
            $subject = "Activation Code For Camagru";
            $from = 'no-reply@camagru.com';
            $body='<html xmlns:v="urn:schemas-microsoft-com:vml"><body>Your Activation Code is '.$token.' Please Click On This link <a href="http://localhost/users/verification/'.$token.'">Link</a> to activate  your account.</body></html>';
            $headers = "From:".$from;
            mail($to,$subject,$body,$headers);
            return true;
        }else{
            return false;
        }
    }

    /*
        VERIFIE THAT THE TOKEN IS RIGHT AND APPROVE IT
    */
    public function verifieToken($token)
    {
        $this->db->query('SELECT * FROM users WHERE verification_key = :token AND is_verfied = 0');
        $this->db->bind('token', $token);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0)
        {
            $this->db->query('UPDATE users SET verification_key = :token, is_verfied = :verfied  WHERE verification_key = :rowtoken');
            $this->db->bind(':token', '');
            $this->db->bind(':verfied', 1);
            $this->db->bind(':rowtoken',$row->verification_key);
            $this->db->execute();
            return true;
        }
        else {
            return false;
        }
    }
    /*
    RECOVER PASSWORD 
    */
    public function passwordRecover($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email AND is_verfied = 1');
        $this->db->bind('email', $email);
        $user = $this->db->single();
        if ($this->db->rowCount() > 0)
        {
            if ($token = $this->addToken($user))
            {
                $message = '';
                $to = $user->email;
                $subject = "Reset your password";
                $from = 'no-reply@camagru.com';
                $body= 'No need to worry, you can reset your Camagru password by clicking the link below to activate  your account:<br>
                <a href="http://localhost/users/resetpassword/'.$token.'">Link </a><br>' . 'Your username is: '. $user->name;
                $headers = "From:".$from;
                if (mail($to,$subject,$body,$headers))
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        else
        {
            return false;
        }
    }
    /*
    RECREATE THE TOKEN FOR RECOVER AND OTHER OPERATIONS
    */
    public function addToken($user)
    {
        $token = md5(bin2hex(random_bytes(14)));
        $this->db->query('UPDATE users SET verification_key = :verification_key WHERE email = :email');
        $this->db->bind('verification_key', $token);
        $this->db->bind('email', $user->email);
        if ($this->db->execute())
        {
            return $token;
        }else {
            return false;
        }
    }
    /* 
    CHECK IF THE TOKEN IS VALIDE
    */
    public function checkToken($token)
    {
        $this->db->query('SELECT * FROM users WHERE verification_key = :token AND is_verfied = 1');
        $this->db->bind('token', $token);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0)
        {
            $_SESSION['Token'] = $token;
            return true;
        }
        else
        {
            return false;
        }
    }
    /* 
    RESET PASSWORD FROM TOKEN
    */
    public function resetPassword($newpassword)
    {
        if (empty($_SESSION['Token']))
            return false;
        $this->db->query('UPDATE users SET password = :password WHERE verification_key = :verification_key AND is_verfied = 1');
        $this->db->bind(':verification_key', $_SESSION['Token']);
        $this->db->bind(':password', $newpassword);
        // Execute
        if ($this->db->execute())
        {
            $this->db->query('UPDATE users SET verification_key = :token WHERE verification_key = :rowtoken');
            $this->db->bind(':token', '');
            $this->db->bind(':rowtoken',$_SESSION['Token']);
            $this->db->execute();
            unset($_SESSION['Token']);
            return true;
        }
        else
        {
            return false;
        }
    }
    /*
    GET THE NOTIFICATION IF TRUE OR FALSE
    */
    public function getNofication()
    {
        // query our data
        $this->db->query('SELECT * FROM users WHERE username = :name');
        // bind our value
        $this->db->bind(':name', $_SESSION['user_name']);
        // execute our data
        $result = $this->db->single();
        return $result;
    }
    /*
    UPDATE USER INFO IN SETTINGS
    */
    public function updateUser($data)
    {
        $this->db->query('UPDATE users SET username = :username , email = :email, is_notifi = :is_notifi, password = :password WHERE id = :id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['new_password']);
        $this->db->bind(':is_notifi', $data['notifications']);
        return $this->db->execute();
    }

}