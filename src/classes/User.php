<?php 
class User extends Main
{
    protected static $tableName = "users";
    protected static $dbTableFields = array('first_name', 'last_name', 'username', 'password', 'email', 'date_of_birth', 'sex', 'address', 'counrty', 'contact', 'profile_pic', 'register_date', 'subscription_status', 'validation_code', 'active');

    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $password;
    public $email;
    public $date_of_birth;
    public $sex;
    public $address;
    public $counrty;
    public $contact;
    public $profile_pic;
    public $register_date;
    public $subscription_status;
    public $validation_code;
    public $active;

    public $userImagesDirectory = "user_pics";
    public $defaultUserImagePlaceholder = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . 'defaults' . 'image_not_available.jpg';

    public $tmp_path;
    public $customErrors = array();
    public $userImageUploadErrorsArray = array(
        UPLOAD_ERR_OK => "There is no error.",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds thr MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "The uploaded file was partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
    );


    /********************************* Core Methods *********************************/

    public static function findAllUsers()
    {
        return self::findUserByQuery("SELECT * FROM users");
    }

    public static function findUserById($id)
    {
        global $database;

        $resultArray = self::findUserByQuery("SELECT * FROM users WHERE id=$id LIMIT 1");
        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function findUserByQuery($sql)
    {
        global $database;

        $resultSet = $database->query($sql);
        $userObjectArray = array();
        while ($row = $database->fetchArray($resultSet)) {
            $userObjectArray[] = self::autoInstantiation($row);
        }
        return $userObjectArray;
    }

    //Could Check that $record Exists and is an Array.
    //Dynamic, Short-form Approach.
    public static function autoInstantiation($userRecord)
    {
        $userObject = new self();

        foreach ($userRecord as $attribute => $value) {
            if ($userObject->hasAttribute($attribute)) {
                $userObject->$attribute = $value;
            }
        }
        return $userObject;
    }

    private function hasAttribute($attribute)
    {
        //get_object_vars Returns an Associative Array with All Attributes
        //(Including Private ones) as the Key and their Current Values as the Value.
        $userObjectProperties = get_object_vars($this);

        //We don't Care About the Value, We Just Want to Know if the Key Exists
        //Will Return True or False
        return array_key_exists($attribute, $userObjectProperties);
    }


    /********************************* Check If "User Is Logged In" Method *********************************/

    public function userLoggedIn()
    {
        if (isset($_SESSION['givenName']) || isset($_COOKIE['givenName'])) {
            return true;
        } else {
            return false;
        }
    }


    /********************************* Set File For Image Upload Method *********************************/
        
    // Pass in $_FILE(['uploaded_file']) as an argument
    public function setFile($file)
    {
        // Perform error checking on the form parameters
        if (empty($file) || !$file || !is_array($file)) {
            // error: nothing uploaded or wrong argument usage
            $this->customErrors[] = "There is no image uploaded.";
            return false;
        } elseif ($file['error'] != 0) {
            // error: report what PHP says went wrong
            $this->customErrors[] = $this->userImageUploadErrorsArray[$file['error']];
            return false;
        } else {
            // Set object attributes to the form parameters.
            $this->profile_pic = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            // Don't worry about saving anything to the database yet.
        }
    }


    /********************************* Methods Related To Image Paths *********************************/

    public function userPicturePath()
    {
        $targetPath = "../../../assets/images/user_pics";
        return $targetPath . DS . $this->profile_pic;
        //return $this->companyImagesDirectory . DS . $this->profile_pic;
    }


    /********************************* Update Method *********************************/

    public function save()
    {
        //Check if Image id already exists.
        if ($this->id) {
            // Really just to update
            $this->update();
        } else {
            // Make sure there are no errors
            // Can't save if there are pre-existing errors
            if (!empty($this->customErrors)) {
                return false;
            }
                
            // Can't save without filename and temp location
            // Checks if $profile_pic is empty or $tmp_path is empty or not.
            if (empty($this->profile_pic) || empty($this->tmp_path)) {
                $this->customErrors[] = "Image file not available";
                return false;
            }

            //Sets image file to $targetPath
            $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . $this->userImagesDirectory . DS . $this->profile_pic;

            // Make sure a file doesn't already exist in the target location
            if (file_exists($targetPath)) {
                $this->customErrors[] = "The file {$this->profile_pic} already exists";
                return false;
            }
                
            // Attempt to move the file
            if (move_uploaded_file($this->tmp_path, $targetPath)) {
                // Success
                // Save a corresponding entry to the database
                if ($this->create()) {
                    // We are done with temp_path, the file isn't there anymore
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->customErrors[] = "The file directory doesn't have Read/Write permissions";
                return false;
            }
        }
    }



    /********************************* Delete Method *********************************/

    public function deleteUser()
    {
        // First remove the database entry
        if ($this->delete()) {
            // then remove the file
            // Note that even though the database entry is gone, this object
            // is still around (which lets us use $this->profile_pic()).
            $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . 'user_pics' . DS . $this->profile_pic;
            return unlink($targetPath) ? true : false;
        } else {
            // database delete failed
            return false;
        }
    }


    /********************************* Login Methods *********************************/

    public function validateUserLogin()
    {
        global $database;
        $errors = [];
        $min = 3;
        $max = 20;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $database->escape($_POST['email']);
            $password = $this->clean($_POST['password']);
            $remember = $this->clean(isset($_POST['remember']));

            if (empty($email)) {
                $errors[] = "Email Field Cannot Be Empty!";
            }

            if (empty($password)) {
                $errors[] = "Password field cannot be empty!";
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $this->validationErrors($error);
                }
            } else {
                if ($this->loginUser($email, $password, $remember)) {
                    if(isset($_GET) && !empty($_GET['redirect_to'])){
                        $this->redirect($_GET['redirect_to']);
                    }else{
                        $this->redirect("index");
                    }
                    
                } else {
                    echo $this->validationErrors("Your credentials are incorrect");
                }
            }
        }
    }

    public function loginUser($email, $password, $remember)
    {
        global $database;

        $sql = "SELECT username, password, id FROM users WHERE email = '" . $database->escape($email) . "' AND active = 1";
        $result = $database->query($sql);
        if ($database->numRows($result) == 1) {
            $row = $database->fetchArray($result);
            $dbPassword = $row['password'];

            if (password_verify($password, $dbPassword)) {
                if ($remember == "on") {
                    // guess what we'e using to save remember me?
                    // that's right
                    // we're using cookies
                    // yeah I went there
                    // we storin this for 3 years, people
                    // mmh cookie
                    setcookie('email', $email, time() + 86400);
                }

                $_SESSION['email'] = $email;
                $_SESSION['givenName'] = $row['username'];
                return true;
            } else {
                return false;
            }

            return true;
        } else {
            return false;
        }
    }


    /********************************* Password Reset Methods *********************************/

    public function recoverUserPassword()
    {
        global $database;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                $email = $this->clean($_POST['email']);

                if ($this->emailExists($email)) {
                    $validation_code = md5($email . microtime());

                    setcookie('temp_access_code', $validation_code, time() + 900);

                    $sql = "UPDATE users SET validation_code = '" . $database->escape($validation_code) . "' WHERE email = '" . $database->escape($email) . "'";
                    $result = $database->query($sql);

                    $subject = "Please Reset Your Password";
                    $message = "Hello, <br><br>Here is your Password Reset code:  {$validation_code} <br>Please<a href=\"" . Config::DEVELOPMENT_URL . "/code?email=$email&code=$validation_code\"> Click Here </a>to reset your password.<br><br>Thanks,<br>Team Medywise";
                    $header = "From: noreply@website.com";

                    $this->sendMail($email, $subject, $message, $header);
                    $this->setMessage("<p class='bg-success text-center'>Please Check Your Email for Password Reset Code</p>");

                    $this->redirect("index");
                } else {
                    echo $this->validationErrors("This email does not exists");
                }
            } else {
                $this->redirect("index");
            }

            if (isset($_POST['cancel_submit'])) {
                $this->redirect("login");
            }
        }
    }

    public function codeValidation()
    {
        global $database;

        if (isset($_COOKIE['temp_access_code'])) {
            if (!isset($_GET['email']) && !isset($_GET['code'])) {
                $this->redirect("index");
            } elseif (empty($_GET['email']) || empty($_GET['code'])) {
                $this->redirect("index");
            } else {
                if (isset($_POST['code'])) {
                    $email = $this->clean($_GET['email']);
                    $validation_code = $this->clean($_POST['code']);

                    $sql = "SELECT id FROM users WHERE validation_code = '" . $database->escape($validation_code) . "' AND email = '" . $database->escape($email) . "'";
                    $result = $database->query($sql);

                    if ($database->numRows($result) == 1) {
                        setcookie('temp_access_code', $validation_code, time() + 900);

                        $this->redirect("reset?email=$email&code=$validation_code");
                    } else {
                        echo $this->validationErrors("Sorry, wrong validation code!!");
                    }
                }
            }
        } else {
            $this->setMessage("<p class='bg-danger text-center'>Sorry, Validation Session Expired!!</p>");
            $this->redirect("recover");
        }
    }

    public function passwordReset()
    {
        global $database;
        if (isset($_COOKIE['temp_access_code'])) {
            if (isset($_GET['email']) && isset($_GET['code'])) {
                if (isset($_SESSION['token']) && isset($_POST['token'])) {
                    if ($_POST['token'] === $_SESSION['token']) {
                        if ($_POST['password'] === $_POST['confirm_password']) {
                            $updatedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 12));

                            $sql = "UPDATE users SET password = '" . $database->escape($updatedPassword) . "', validation_code = 0, active = 1 WHERE email = '" . $database->escape($_GET['email']) . "'";
                            $database->query($sql);

                            $this->setMessage("<p class='bg-success text-center'>Password Updated! Please Login</p>");
                            $this->redirect("login");
                        } else {
                            $this->setMessage("<p class='bg-danger text-center'>Passwords Don't Match</p>");
                        }
                    }
                }
            }
        } else {
            $this->setMessage("<p class='bg-danger text-center'>Sorry, Session Expired</p>");
            $this->redirect("recover");
        }
    }


    /********************************* Methods To Register For New User *********************************/

    public function registerUser($first_name, $last_name, $username, $email, $password, $sex, $address, $counrty, $contact)
    {
        global $database;

        $first_name = $database->escape($first_name);
        $last_name = $database->escape($last_name);
        $username = $database->escape($username);
        $email = $database->escape($email);
        $password = $database->escape($password);
        $sex = $database->escape($sex);
        $address = $database->escape($address);
        $counrty = $database->escape($counrty);
        $contact = $database->escape($contact);

        if ($this->emailExists($email)) {
            return false;
        } elseif ($this->usernameExists($username)) {
            return false;
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
            $validation_code = md5($username . microtime());

            $sql = "INSERT INTO users(first_name, last_name, username, email, password, register_date, sex, address, counrty, contact, validation_code, active)";
            $sql .= " VALUES('$first_name', '$last_name', '$username', '$email', '$password', NOW(), '$sex', '$address', '$counrty', '$contact', '$validation_code', 0)";
            $result = $database->query($sql);

            $subject = "Activate Account";
            $msg = "Hello, <br><br>Welcome To Medywise.<br><br>Please click the link below to activate your Account<br><a href=\"" . Config::DEVELOPMENT_URL . "/activate?email=$email&code=$validation_code\"> Link Here </a>.<br><b>Enjoy yor 30-day Free Trial.</b><br><br>Thanks,<br>Team Medywise";
            $header = "From: noreply@website.com";

            $this->sendMail($email, $subject, $msg, $header);

            return true;
        }
    }
    public function validateUserRegistration()
    {
        $errors = [];
        $min = 3;
        $max = 20;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $first_name = $this->clean($_POST['first_name']);
            $last_name = $this->clean($_POST['last_name']);
            $username = $this->clean($_POST['username']);
            $email = $this->clean($_POST['email']);
            $password = $this->clean($_POST['password']);
            $confirm_password = $this->clean($_POST['confirm_password']);
            $sex = $this->clean($_POST['sex']);
            $address = $this->clean($_POST['address']);
            $counrty = $this->clean($_POST['counrty']);
            $contact = $this->clean($_POST['contact']);
            $register_date = date('Y-m-d');

            if (strlen($first_name) < $min) {
                $errors[] = "First Name cannot be less than {$min} characters.</br>";
            }

            if (strlen($first_name) > $max) {
                $errors[] = "First Name cannot be more than {$max} characters.</br>";
            }

            if (strlen($last_name) < $min) {
                $errors[] = "Last Name cannot be less than {$min} characters.</br>";
            }

            if (strlen($last_name) > $max) {
                $errors[] = "Last Name cannot be more than {$max} characters.</br>";
            }

            if (strlen($username) < $min) {
                $errors[] = "Username cannot be less than {$min} characters.</br>";
            }

            if (strlen($username) > $max) {
                $errors[] = "Username cannot be more than {$max} characters.</br>";
            }

            if ($this->usernameExists($username)) {
                $errors[] = "Username already taken.</br>";
            }

            if ($this->emailExists($email)) {
                $errors[] = "Email already registered.</br>";
            }

            if ($password !== $confirm_password) {
                $errors[] = "Your Passwords donot match.</br>";
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $this->validationErrors($error);
                }
            } else {
                if ($this->registerUser($first_name, $last_name, $username, $email, $password, $sex, $address, $counrty, $contact, $register_date)) {
                    $this->setMessage("<p class='bg-success text-center'>Please check your Email for activation Link.</p>");
                    $this->redirect("index");
                } else {
                    $this->setMessage("<p class='bg-danger text-center'>Sorry we could not register the user.</p>");
                    $this->redirect("index");
                }
            }
        }
    }

    public function activateUser()
    {
        global $database;

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_GET['email'])) {
                $email = $this->clean($_GET['email']);
                $validation_code = $this->clean($_GET['code']);

                $selectQuery = "SELECT id FROM users WHERE email = '" . $database->escape($_GET['email']) . "' AND validation_code = '" . $database->escape($_GET['code']) . "' ";
                $result = $database->query($selectQuery);

                if ($database->numRows($result) == 1) {
                    $updateQuery = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '" . $database->escape($email) . "' AND validation_code = '" . $database->escape($validation_code) . "' ";
                    $result2 = $database->query($updateQuery);

                    $this->setMessage("<p class='bg-success'>Your Account Has Been Activated. Please Login!</p>");
                    $this->redirect("login");
                } else {
                    $this->setMessage("<p class='bg-danger'>Sorry! Your Account Could Not Been Activated.</p>");
                    $this->redirect("login");
                }
            }
        }
    }


    /********************************* Method To Check Subscription Status of the User *********************************/

    
    /* I have no idea why this function works, but it does,
    so it's probably best to leave it alone unless you
    know how/why it works */
    public function checkSubscriptionStatus()
    {
        global $database;

        $q = 'Select * from users where email="' . $_SESSION['email'] . '"';
        $result = mysqli_fetch_object($database->query($q));

        $date1 = date_create($result->register_date);
        $date2 = date_create(date("Y-m-d"));
        $days = date_diff($date1, $date2)->days;
        // print_r($days);
        if ($days > 21) { // 21 days check
            if (!$result->subscription_status && !$result->tranxid) {
                header("Location: /subscribe");
            }
        }
    }//checkSubscriptionStatus(); End
    
    public function checkSubscriptionStatusOnSubscribePage()
    {
        global $database;

        $q = 'Select * from users where email="' . $_SESSION['email'] . '"';
        $result = mysqli_fetch_object($database->query($q));

        $date1 = date_create($result->register_date);
        $date2 = date_create(date("Y-m-d"));
        $days = date_diff($date1, $date2)->days;
        if ($days > 21) { // 21 days check
            if (!$result->subscription_status && !$result->tranxid) {
                echo "<h1 class='bg-danger'>It seems like your trial period has expired!!</h1/>";
            }
        }
    }


    /********************************* Contact Us Method *********************************/

    
    public function contactUs()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $this->clean($_POST['name']);
            $mobile_nmbr = $this->clean($_POST['mobile_nmbr']);
            $email = $this->clean($_POST['email']);
            $msg = $this->clean($_POST['message']);

            $to = "info.medywise@gmail.com";

            $subject = "New Message From Contact Page";
            $message = "Hello, <br><br>{$name}, {$mobile_nmbr} sends you a message..<br> This is your message <br>'{$msg}'";

            if($this->sendContactEmail($to, $email, $name, $message))
            {
                $this->setMessage("<p class='bg-success text-center'>Message successfully sent</p>");
                $this->redirect("contact");
            }
            // } else {
            //     echo $this->validationErrors("Message sending failed");
            // }
        } 
    }//contactUs(); End
}//End of Class
