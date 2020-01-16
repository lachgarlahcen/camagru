<?php
session_start();

//flash message helper
function flash($name = '', $message = '', $class = 'alert alert-success text-center')
{
    if (!empty($name))
    {
        if (!empty($message) && empty($_SESSION[$name]))
        {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class; 
        }
        else if (empty($message) && !empty($_SESSION[$name]))
        {
            echo '<div class="'.$_SESSION[$name . '_class'].'" id = "msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name . '_class']);
            unset($_SESSION[$name]);
        }
    }    
}