<?php

/*
 * DPTechnics CMS
 * Security module
 * Author: Daan Pape
 * Date: 18-08-2014
 */

// Load required files
require_once('password.php');
require_once('database.php');
require_once('email.php');

/* User status constants */
define('WAIT_ACTIVATION', 'WAIT_ACTIVATION');
define('ACTIVE', 'ACTIVE');
define('SUSPENDED', 'SUSPENDED');

class Security {
    
    /*
     * Hash a password with the currently used encryption standard
     */
    public static function hashPass($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /*
     * Log in a user into the current session 
     */
    public static function loginUser($username, $password) {
        // Search if the username is used 
        $userdata = UserDAO::getUserByUsername($username);

        // Check password if there is data
        if ($userdata != false) {
            // Check account status if the password is successful
            if (password_verify($password, $userdata->password)) {
                // Check if the user is active
                if ($userdata->status == ACTIVE) {
                    // Set user in session
                    $_SESSION['username'] = $username;

                    return true;
                } else {
                    // Return the current user status
                    return $userdata->status;
                }
            }
        }

        // There was an error, bad user
        return 'WrongUserPass';
    }

    /*
     * Log out a user from the system
     */
    public static function logoutUser() {
        // Clear all user data
        unset($_SESSION['username']);

        // Return success
        return true;
    }

    /*
     * Checks if there is a user logged in and if
     * so returns the username, otherwise false. 
     */
    public static function isUserLoggedIn() {
        if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
            return $_SESSION['username'];
        } else {
            return false;
        }
    }

    /*
     * Returns true if the username does not allready exist. 
     */
    public static function isUserUnique($username) {
        return UserDAO::doesUserExist($username) == false;
    }

    /*
     * Returns true if the email does not allready exist
     */
    public static function isEmailUnique($email) {
        return UserDAO::doesEmailExist($email) == false;
    }

    /*
     * Generate a unique registration token. If it takes
     * more than 10 tries the function stops. 
     */
    public static function generateRegToken() {
        //Try maximum 10 times to generate token
        for ($i = 0; $i < 10; ++$i) {
            // Generate token
            $token = sha1(mt_rand(10000, 99999) . time());

            // Check if the token is unique in the sytem
            if (!UserDAO::doesUsertokenExist($token)) {
                return $token;
            }
        }

        return false;
    }

    /*
     * Register a user in the system, returns true 
     * on succes. Return false on error.
     */
    public static function registerUser($lang, $firstname, $lastname, $username, $email, $password, $passwordconfirm) {
        // Perform simple form validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'InvalidEmail';
        }

        // Check if passwords match
        if ($password != $passwordconfirm) {
            return 'PassNotMatch';
        }

        // Check if username is unique
        if (UserDAO::doesUserExist($username)) {
            return 'NonUniqueUsername';
        }

        // No numbers are allowed in firstname or lastname
        if (preg_match('#[0-9]#', $firstname) || preg_match('#[0-9]#', $lastname)) {
            return 'NumbersInName';
        }

        // All data is checked and valid, place user in database and generate token
        $regtoken = self::generateRegToken();
        if ($regtoken == false) {
            return 'Error';
        }

        // Hash the users password 
        $hashpass = self::hashPass($password);

        // Register the user 
        if (UserDAO::createUser($lang, $email, $username, $firstname, $lastname, $hashpass, $regtoken, WAIT_ACTIVATION) == null) {
            return 'Error';
        }

        // Send registration email
        if (Email::sendActivationMail($lang, $email, $firstname, $lastname, $username, $regtoken) == false) {
            return 'Error';
        }

        // New user created and waiting for activation
        return true;
    }

    /*
     * Activate a user account given the activation token
     */
    public static function activateUser($token) {
        return UserDAO::activateUser($token);
    }

    /*
     * Returns all the user permissions for the currently logged in user
     */
    public static function getUserPermissions() {
        $current_user = self::isUserLoggedIn();
        if ($current_user === false) {
            // No user is logged in, return guest permissions 
            return UserDAO::getGuestPermissions();
        } else {
            // Get user permissions based on username
            // TODO
        }
    }

    /*
     * Returns true if a user is authorized, false otherwise. 
     */
    public static function isUserAuthorized($permission) {
        $auth = false;
        /*
         * Use star as wildcard
         */
        foreach (self::getUserPermissions() as $perm) {
            $length = strlen($permission);
            for ($i = 0; $i < $length; ++$i) {
                if($perm[$i] != $permission[$i]){
                    
                }
            }
            
            if ($perm[0] === $permission) {
                $auth = true;
                break;
            }
        }
        return $auth;
    }
}

?>