<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function findUserByUsename($username)
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
    //register user
    public function register($data)
    {
        $this->db->query('INSERT INTO users (username, email, pass ) VALUES (:username, :email, :password)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();

    }
}