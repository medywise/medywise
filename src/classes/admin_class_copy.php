<?php 
    class AdminCOPY extends Main
    {
        protected static $tableName = "admin";
        protected static $dbTableFields = array('username', 'password', 'first_name', 'last_name', 'email', 'profile_pic', 'validation_code', 'active');

        public $id;
        public $username;
        public $password;
        public $first_name; 
        public $last_name;
        public $email;
        public $profile_pic;
        public $validation_code;
        public $active;

        public $adminImagesDirectory = "admin_pics";
        public $defaultAdminImagePlaceholder = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . 'defaults' . 'image_not_available.jpg';

        public $tmp_path;
        public $customErrors = array();
        public $adminImageUploadErrorsArray = array(
            UPLOAD_ERR_OK           =>  "There is no error.",
            UPLOAD_ERR_INI_SIZE     =>  "The uploaded file exceeds the upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE    =>  "The uploaded file exceeds thr MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL      =>  "The uploaded file was partially uploaded.",
            UPLOAD_ERR_NO_FILE      =>  "No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR   =>  "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE   =>  "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION    =>  "A PHP extension stopped the file upload."
        );

        public static function findAllAdmins()
        {
            return self::findAdminByQuery("SELECT * FROM " . self::$tableName . " ");
        }

        public static function findAdminById($id)
        {
            global $database;

            $resultArray = self::findAdminByQuery("SELECT * FROM " . self::$tableName . " WHERE id=$id LIMIT 1");
            return !empty($resultArray) ? array_shift($resultArray) : false;
        }

        public static function findAdminByEmail($email)
        {
            global $database;

            $resultArray = "SELECT * FROM " . self::$tableName . " WHERE email=$email LIMIT 1";
            if ($database->query($resultArray))
            {
                //$this->id = $database->insertId();
                return true;
            }
            else
            {
                return false;
            }
            //return !empty($resultArray) ? array_shift($resultArray) : false;
        }

        public static function findAdminByQuery($sql)
        {
            global $database;

            $resultSet = $database->query($sql);
            $adminObjectArray = array();
            while ($row = $database->fetchArray($resultSet))
            {
                $adminObjectArray[] = self::autoInstantiation($row);
            }
            return $adminObjectArray;
        }

        public static function autoInstantiation($adminRecord)
        {
            $adminObject = new self();

            foreach ($adminRecord as $attribute => $value)
            {
                if ($adminObject->hasAttribute($attribute))
                {
                    $adminObject->$attribute = $value;
                }
            }
            return $adminObject;
        }

        private function hasAttribute($attribute)
        {
            $adminObjectProperties = get_object_vars($this);
            return array_key_exists($attribute, $adminObjectProperties);
        }

        public static function verifyAdmin($username, $password)
        {
            global $database;

            $username = $database->escapeString($username);
            $password = $database->escapeString($password);

            $sql = "SELECT * FROM " . self::$tableName . " WHERE ";
            $sql .= "username = '{$username}' ";
            $sql .= "AND password = '{$password}' ";
            $sql .= "LIMIT 1";
            $resultArray = self::findAdminByQuery($sql);
            
            return !empty($resultArray) ? $database->arrayShift($resultArray) : false;
        }

        public function deleteAdmin()
        {
            if ($this->delete())
            {
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'admin_pics' . DS . $this->profile_pic;
                return unlink($targetPath) ? true : false;
            }
            else
            {
                return false;
            }
        }

        public function setFile($file)
        {
            if (empty($file) || !$file || !is_array($file))
            {
                $this->customErrors[] = "There is no image uploaded.";
                return false;
            }
            elseif ($file['error'] !=0)
            {
                $this->customErrors[] = $this->adminImageUploadErrorsArray[$file['error']];
                return false;
            }
            else
            {
                $this->profile_pic = basename($file['name']);
                $this->tmp_path = $file['tmp_name'];
            }
        }

        public function save()
        {
            //Check if Image id already exists.
            if ($this->id)
            {
                $this->update();
            }
            else
            {
                //If $customErrors not empty, then return false.
                if(!empty($this->customErrors))
                {
                    return false;
                }

                //Checks if $profile_pic is empty or $tmp_path is empty or not.
                if (empty($this->profile_pic) || empty($this->tmp_path))
                {
                    $this->customErrors[] = "Image file not available";
                    return false;
                }

                //Sets image file to $targetPath
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . $this->adminImagesDirectory . DS . $this->profile_pic;

                //Checks if file already exists or not.
                if(file_exists($targetPath))
                {
                    $this->customErrors[] = "The file {$this->profile_pic} already exists";
                    return false;
                }

                if(move_uploaded_file($this->tmp_path, $targetPath))
                {
                    if ($this->create())
                    {
                        unset($this->tmp_path);
                        return true;
                    }
                }
                else
                {
                    $this->customErrors[] = "The file directory doesn't have Read/Write permissions";
                    return false;
                }
            }
        }

        public function adminPicturePath()
        {
            $targetPath = "../../../assets/images/admin_pics";
            return $targetPath . DS . $this->profile_pic;
            //return $this->companyImagesDirectory . DS . $this->profile_pic;
        }

        public function adminImagePathAndPlaceholder()
        {
            return empty($this->profile_pic) ? $this->defaultAdminImagePlaceholder : $this->adminImagesDirectory . DS . $this->profile_pic;
        }

        //Function not working!!!!
        public function ajaxUpdateAdminImage($profile_pic, $adminId)
        {
            global $database;

            $profile_pic = $database->escapeString($profile_pic);
            $adminId = $database->escapeString($adminId);

            $this->profile_pic = $profile_pic;
            $this->id = $adminId;

            $sql = "UPDATE " . self::$tableName . " SET profile_pic = '{$this->profile_pic}' ";
            $sql .= "WHERE id = {$this->id} ";
            $updateImage = $database->query($sql);

            echo $this->adminImagePathAndPlaceholder();

            /*$this->save();*/
        }//ajaxUpdateAdminImage(); End

        public function updateAdmin($username, $pwd, $first_name, $last_name, $email)
        {
            if (isset($_POST['update']))
            {
                $username = $_POST['username'];
                $pwdStr = $_POST['password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];

                if(strlen($username) > 50 || strlen($username) < 5)
                {
                    $message = "Username must be between 5 and 50 characters"; 
                }
                else
                {
                    //Sets Password Encryption
                    $pwd = md5($pwdStr);

                    if(strlen($first_name) > 50 || strlen($first_name) < 5)
                    {
                        $message = "First Name must be between 5 and 50 characters"; 
                    }
                    else
                    {
                        if(strlen($last_name) > 50 || strlen($last_name) < 5)
                        {
                            $message = "Last Name must be between 5 and 50 characters"; 
                        }
                        else
                        {
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                            {
                               $message = "Invalid format, please re-enter valid email"; 
                            }
                            else
                            {
                                $this->username = $username;
                                $this->password = $pwd;
                                $this->first_name = $first_name;
                                $this->last_name = $last_name;
                                $this->email = $email;

                                $this->save();
                            }
                        }
                    }
                }
            }
        }//updateAdmin(); End

        public function validateAdminRegistration()
        {
            $errors = [];
            $min = 3;
            $max = 20;

            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $username           = $this->clean($_POST['username']);
                $pwdStr             = $this->clean($_POST['password']);
                $first_name         = $this->clean($_POST['first_name']);
                $last_name          = $this->clean($_POST['last_name']);
                $email              = $this->clean($_POST['email']);
                $confirm_password   = $this->clean($_POST['confirm_password']);

                if(strlen($first_name) < $min)
                {
                    $errors[] = "First Name cannot be less than {$min} characters.</br>";
                }

                if(strlen($first_name) > $max)
                {
                    $errors[] = "First Name cannot be more than {$max} characters.</br>";
                }

                if(strlen($last_name) < $min)
                {
                    $errors[] = "Last Name cannot be less than {$min} characters.</br>";
                }

                if(strlen($last_name) > $max)
                {
                    $errors[] = "Last Name cannot be more than {$max} characters.</br>";
                }

                if(strlen($username) < $min)
                {
                    $errors[] = "Username cannot be less than {$min} characters.</br>";
                }

                if(strlen($username) > $max)
                {
                    $errors[] = "Username cannot be more than {$max} characters.</br>";
                }

                if($this->usernameExists($username))
                {
                    $errors[] = "Username already taken.</br>";
                }

                if($this->emailExists($email))
                {
                    $errors[] = "Email already registered.</br>";
                }

                if($password !== $confirm_password)
                {
                    $errors[] = "Your Passwords donot match.</br>";
                }

                if(!empty($errors))
                {
                    foreach ($errors as $error)
                    {
                        echo $this->validationErrors($error);
                    }
                }
                else
                {
                    if($this->registerAdmin($username, $password, $first_name, $last_name, $email))
                    {
                        $this->setMessage("<p class='bg-success text-center'>Please check your Email for activation Link.</p>");
                        $this->redirect("../login.php");
                    }
                    else
                    {
                        $this->setMessage("<p class='bg-danger text-center'>Sorry we could not register the user.</p>");
                        $this->redirect("../login.php");
                    }
                }
            }
        }//validateAdminRegistration(); End

        public function registerAdmin($username, $password, $first_name, $last_name, $email)
        {
            global $database;

            $username   = $database->escape($username);
            $password   = $database->escape($password);
            $first_name = $database->escape($first_name);
            $last_name  = $database->escape($last_name);
            $email      = $database->escape($email);

            if($this->emailExists($email))
            {
                return false;
            }
            elseif($this->usernameExists($username))
            {
                return false;
            }
            else
            {
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
                $validation_code = md5($username . microtime());

                $sql = "INSERT INTO admin(username, password, first_name, last_name, email)";
                $sql .= " VALUES('$username', '$password', '$first_name', '$last_name', '$email')";
                $result = $database->query($sql);

                return true;
            }
        }//registerAdmin(); End

        /*Login Methods*/
        public function validateAdminLogin()
        {
            global $database;
            $errors = [];
            $min = 3;
            $max = 20;

            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $email      =  $database->escape($_POST['email']);
                $password   = $this->clean($_POST['password']);
                $remember   = $this->clean(isset($_POST['remember']));

                if(empty($email))
                {
                    $errors[] = "Email Field Cannot Be Empty!";
                }

                if(empty($password))
                {
                    $errors[] = "Password field cannot be empty!";
                }

                if(!empty($errors))
                {
                    foreach ($errors as $error)
                    {
                        echo $this->validationErrors($error);
                    }
                }
                else
                {
                    if($this->loginAdmin($email, $password, $remember))
                    {
                        $this->redirect("index.php");
                    }
                    else
                    {
                        echo $this->validationErrors("Your credentials are incorrect");
                    }
                }
            }
        }

        public function loginAdmin($email, $password, $remember)
        {
            global $database;

            $sql = "SELECT password, id FROM admin WHERE email = '".$database->escape($email)."' AND active = 1";
            $result = $database->query($sql);
            if($database->numRows($result) == 1)
            {
                $row = $database->fetchArray($result);
                $dbPassword = $row['password'];

                if(password_verify($password, $dbPassword))
                {
                    if($remember == "on")
                    {
                        setcookie('email', $email, time() + 86400);
                    }

                    $_SESSION['email'] = $email;
                    return true;
                }
                else
                {
                    return false;
                }

                return true;
            }
            else
            {
                return false;
            }
        }//loginAdmin(); End

        public function adminLoggedIn()
        {
            if(isset($_SESSION['email']) || isset($_COOKIE['email']))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /*Recover Password Methods*/
        public function recoverAdminPassword()
        {
            global $database;
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token'])
                {
                    $email = $this->clean($_POST['email']);

                    if($this->emailExists($email))
                    {
                        $validation_code = md5($email . microtime());

                        setcookie('temp_access_code', $validation_code, time()+900);

                        $sql = "UPDATE admin SET validation_code = '".$database->escape($validation_code)."' WHERE email = '".$database->escape($email)."'";
                        $result = $database->query($sql);

                        $subject = "Please Reset Your Password";
                        $message = "Here is your Password Reset code {$validation_code} <a href=\"".Config::ADMIN_URL."/code.php?email=$email&code=$validation_code\">Click Here </a>to reset your password";
                        $header = "From: noreply@website.com";

                        $this->sendEmail($email, $subject, $message, $header);
                        $this->setMessage("<p class='bg-success text-center'>Please Check Your Email for Password Reset Code</p>");
                        $this->redirect("index.php");
                    }
                    else
                    {
                        echo $this->validationErrors("This email does not exists");
                    }
                }
                else
                {
                    $this->redirect("index.php");
                }

                if(isset($_POST['cancel_submit']))
                {
                    $this->redirect("login.php");
                }
            }
        }

        /*Code Validation Method*/
        public function codeValidation()
        {
            global $database;

            if(isset($_COOKIE['temp_access_code']))
            {
                if(!isset($_GET['email']) && !isset($_GET['code']))
                {
                    $this->redirect("login.php");
                }
                elseif (empty($_GET['email']) || empty($_GET['code']))
                {
                    $this->redirect("login.php");
                }
                else
                {
                    if(isset($_POST['code']))
                    {
                        $email = $this->clean($_GET['email']);
                        $validation_code = $this->clean($_POST['code']);

                        $sql = "SELECT id FROM admin WHERE validation_code = '".$database->escape($validation_code)."' AND email = '".$database->escape($email)."'";
                        $result = $database->query($sql);

                        if($database->numRows($result) == 1)
                        {
                            setcookie('temp_access_code', $validation_code, time()+900);

                            $this->redirect("register.php?email=$email&code=$validation_code");
                        }
                        else
                        {
                            echo $this->validationErrors("Sorry, wrong validation code!!");
                        }
                    }
                }
            }
            else
            {
                $this->setMessage("<p class='bg-danger text-center'>Sorry, Validation Session Expired!!</p>");
                $this->redirect("recover.php");
            }
        }

        /*Reset Password Method*/
        public function passwordReset()
        {
            global $database;
            if(isset($_COOKIE['temp_access_code']))
            {
                if(isset($_GET['email']) && isset($_GET['code']))
                {
                    if(isset($_SESSION['token']) && isset($_POST['token']))
                    {
                        if($_POST['token'] === $_SESSION['token'])
                        {
                            if($_POST['password'] === $_POST['confirm_password'])
                            {
                                //$updatedPassword = md5($_POST['password']);
                                $updatedPassword =password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost'=>12));

                                $sql = "UPDATE admin SET password = '".$database->escape($updatedPassword)."', validation_code = 0, active = 1 WHERE email = '".$database->escape($_GET['email'])."'";
                                $database->query($sql);

                                $this->setMessage("<p class='bg-success text-center'>Password Updated! Please Login</p>");
                                $this->redirect("login.php");
                            }
                            else
                            {
                                $this->setMessage("<p class='bg-danger text-center'>Passwords Don't Match</p>");
                            }
                        }
                    }
                }
            }
            else
            {
                $this->setMessage("<p class='bg-danger text-center'>Sorry, Session Expired</p>");
                $this->redirect("recover.php");
            }
        }//passwordReset(); End

        public function validateNewAdminRequest()
        {
            $errors = [];
            $min = 3;
            $max = 20;

            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $email = $this->clean($_POST['email']);

                if($this->emailExists($email))
                {
                    $errors[] = "Email already registered.</br>";
                }

                if(!empty($errors))
                {
                    foreach ($errors as $error)
                    {
                        echo $this->validationErrors($error);
                    }
                }
                else
                {
                    if($this->sendJoinRequestToNewAdmin($email))
                    {
                        $this->setMessage("<p class='bg-success text-center'>Please ask new Admin to check email for registration link.</p>");
                        $this->redirect("view.php");
                    }
                    else
                    {
                        $this->setMessage("<p class='bg-danger text-center'>Sorry, we could not send register request.</p>");
                        $this->redirect("view.php");
                    }
                }
            }
        }//validateNewAdminRequest(); End

        public function sendJoinRequestToNewAdmin($email)
        {
            global $database;

            $email = $database->escape($email);

            if($this->emailExists($email))
            {
                return false;
            }
            else
            {   
                $validation_code = md5($email . microtime());

                $sql = "INSERT INTO admin(email, validation_code, active)";
                $sql .= " VALUES('$email', '$validation_code', 0)";
                $result = $database->query($sql);

                $subject = "Welcome To Mediwise - Open To Join As Admin";
                $msg = "Welcome To Mediwie. Please click the link to register your Account and join Mediwise as Admin.<a href=\"".Config::ADMIN_URL."/reg_code.php?email=$email&code=$validation_code\"> Link Here </a>";
                $header = "From: noreply@mediwise.com";

                $this->sendEmail($email, $subject, $msg, $header);

                return true;
            }
        }//sendJoinRequestToNewAdmin(); End

        public function newAdminCodeValidation()
        {
            global $database;

            /*if(isset($_COOKIE['temp_access_code']))
            {*/
                if(!isset($_GET['email']) && !isset($_GET['code']))
                {
                    $this->redirect("login.php");
                }
                elseif (empty($_GET['email']) || empty($_GET['code']))
                {
                    $this->redirect("login.php");
                }
                else
                {
                    if(isset($_POST['code']))
                    {
                        $email = $this->clean($_GET['email']);
                        $validation_code = $this->clean($_POST['code']);

                        $sql = "SELECT id FROM admin WHERE validation_code = '".$database->escape($validation_code)."' AND email = '".$database->escape($email)."'";
                        $result = $database->query($sql);

                        if($database->numRows($result) == 1)
                        {
                            setcookie('temp_access_code', $validation_code, time()+900);

                            $this->redirect("register.php?email=$email&code=$validation_code");
                        }
                        else
                        {
                            echo $this->validationErrors("Sorry, wrong validation code!!");
                        }
                    }
                }
            // }
            // else
            // {
            //     $this->setMessage("<p class='bg-danger text-center'>Sorry, Validation Session Expired!!</p>");
            //     $this->redirect("login.php");
            // }
        }

    }
?>