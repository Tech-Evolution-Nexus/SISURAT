<?php

/**
 * Function to create and display error and success messages
 * @access public
 * @param string session name
 * @param string message
 * @param string display class
 * @return string message
 */
function flash($name = '', $message = '', $class = 'alert-success')
{
    //We can only do something if the name isn't empty
    if (!empty($name)) {
        //No message, create it
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        }
        //Message exists, display it
        elseif (!empty($_SESSION[$name]) && empty($message)) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'alert-success';
            echo '<div class="alert ' . $class . '">' . $_SESSION[$name] . '</div>';

            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}
