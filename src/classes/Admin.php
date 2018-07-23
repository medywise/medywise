<?php 
    class Admin extends Main
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


        /********************************* Core Methods *********************************/
        
        public static function findAllAdmins()
        {
            return self::findAdminByQuery("SELECT * FROM " . self::$tableName . " ");
        }//findAllAdmins(); End

        public static function findAdminById($id)
        {
            global $database;

            $resultArray = self::findAdminByQuery("SELECT * FROM " . self::$tableName . " WHERE id=$id LIMIT 1");
            return !empty($resultArray) ? array_shift($resultArray) : false;
        }//findAdminById(); End

        public static function findAdminByQuery($sql)
        {
            global $database;

            $resultSet = $database->query($sql);
            $adminObjectArray = array();
            while ($row = $database->fetchArray($resultSet)) {
                $adminObjectArray[] = self::autoInstantiation($row);
            }
            return $adminObjectArray;
        }//findAdminByQuery(); End

        //Could Check that $record Exists and is an Array.
        //Dynamic, Short-form Approach.
        public static function autoInstantiation($adminRecord)
        {
            $adminObject = new self();

            foreach ($adminRecord as $attribute => $value) {
                if ($adminObject->hasAttribute($attribute)) {
                    $adminObject->$attribute = $value;
                }
            }
            return $adminObject;
        }//autoInstantiation(); End

        private function hasAttribute($attribute)
        {
            //get_object_vars Returns an Associative Array with All Attributes
            //(Including Private ones) as the Key and their Current Values as the Value.
            $adminObjectProperties = get_object_vars($this);

            //We don't Care About the Value, We Just Want to Know if the Key Exists
            //Will Return True or False
            return array_key_exists($attribute, $adminObjectProperties);
        }//hasAttribute(); End


        /********************************* Check If "Admin Is Logged In" Method *********************************/

        public function adminLoggedIn()
        {
            if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
                return true;
            } else {
                return false;
            }
        }//adminLoggedIn(); End


        /********************************* Show Admin Id Method *********************************/

        public function showAdminId($em)
        {
            global $database;

            $sql = "SELECT id FROM admin WHERE email = '{$em}' LIMIT 1";
            $result = $database->query($sql);
            $row = mysqli_fetch_array($result);
            $adId = $row['id'];

            return $adId;
        }//showAdminId(); End


        /********************************* Set File For Image Upload Method *********************************/
        
        // Pass in $_FILE(['uploaded_file']) as an argument
        public function setFile($file)
        {
            // Perform error checking on the form parameters
            if (empty($file) || !$file || !is_array($file)) {
                // error: nothing uploaded or wrong argument usage
                $this->customErrors[] = "There is no image uploaded.";
                return false;
            } elseif ($file['error'] !=0) {
                // error: report what PHP says went wrong
                $this->customErrors[] = $this->adminImageUploadErrorsArray[$file['error']];
                return false;
            } else {
                // Set object attributes to the form parameters.
                $this->profile_pic = basename($file['name']);
                $this->tmp_path = $file['tmp_name'];
                // Don't worry about saving anything to the database yet.
            }
        }//setFile(); End


        /********************************* Methods Related To Image Paths *********************************/

        public function adminPicturePath()
        {
            $targetPath = "../../../assets/images/admin_pics";
            return $targetPath . DS . $this->profile_pic;
            //return $this->companyImagesDirectory . DS . $this->profile_pic;
        }//adminPicturePath(); End

        public function adminImagePathAndPlaceholder()
        {
            return empty($this->profile_pic) ? $this->defaultAdminImagePlaceholder : $this->adminImagesDirectory . DS . $this->profile_pic;
        }//adminImagePathAndPlaceholder(); End



        /********************************* Update Methods *********************************/
        
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
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . $this->adminImagesDirectory . DS . $this->profile_pic;

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
                    // File was not moved.
                    $this->customErrors[] = "The file directory doesn't have Read/Write permissions";
                    return false;
                }
            }
        }//save(); End

        public function updateAdmin($username, $pwd, $first_name, $last_name, $email)
        {
            if (isset($_POST['update'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];

                if (strlen($username) > 50 || strlen($username) < 5) {
                    $message = "Username must be between 5 and 50 characters";
                } else {
                    //Sets Password Encryption
                    //$password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
                    $password = md5($password);

                    if (strlen($first_name) > 50 || strlen($first_name) < 5) {
                        $message = "First Name must be between 5 and 50 characters";
                    } else {
                        if (strlen($last_name) > 50 || strlen($last_name) < 5) {
                            $message = "Last Name must be between 5 and 50 characters";
                        } else {
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $message = "Invalid format, please re-enter valid email";
                            } else {
                                $this->username = $username;
                                $this->password = $password;
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


        /********************************* Update Image In Photo Modal Method *********************************/
        
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



        /********************************* Delete Method *********************************/

        public function deleteAdmin()
        {
            // First remove the database entry
            if ($this->delete()) {
                // then remove the file
                // Note that even though the database entry is gone, this object
                // is still around (which lets us use $this->profile_pic()).
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'admin_pics' . DS . $this->profile_pic;
                return unlink($targetPath) ? true : false;
            } else {
                // database delete failed
                return false;
            }
        }//deleteAdmin(); End


        /********************************* Login Methods *********************************/

        public function validateAdminLogin()
        {
            global $database;
            
            $errors = [];
            $min = 3;
            $max = 20;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $email      =  $database->escape($_POST['email']);
                $password   = $this->clean($_POST['password']);
                $remember   = $this->clean(isset($_POST['remember']));

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
                    if ($this->loginAdmin($email, $password, $remember)) {
                        $this->redirect("index.php");
                    } else {
                        echo $this->validationErrors("Your credentials are incorrect");
                    }
                }
            }
        }//validateAdminLogin(); End

        public function loginAdmin($email, $password, $remember)
        {
            global $database;

            $sql = "SELECT username, password, id FROM admin WHERE email = '".$database->escape($email)."' AND active = 1";
            $result = $database->query($sql);
            if ($database->numRows($result) == 1) {
                $row = $database->fetchArray($result);
                $dbPassword = $row['password'];

                //if (password_verify($password, $dbPassword)) {
                if (md5($password) === $dbPassword) {
                    if ($remember == "on") {
                        setcookie('email', $email, time() + 86400);
                    }

                    $_SESSION['admin_email'] = $email;
                    $_SESSION['adminUsername'] = $row['username'];
                    return true;
                } else {
                    return false;
                }

                return true;
            } else {
                return false;
            }
        }//loginAdmin(); End


        /********************************* Password Reset Methods *********************************/

        public function recoverAdminPassword()
        {
            global $database;
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    $email = $this->clean($_POST['email']);

                    if ($this->emailExists($email)) {
                        $validation_code = md5($email . microtime());

                        setcookie('temp_access_code', $validation_code, time()+900);

                        $sql = "UPDATE admin SET validation_code = '".$database->escape($validation_code)."' WHERE email = '".$database->escape($email)."'";
                        $result = $database->query($sql);

                        $subject = "Please Reset Your Password";
                        $message = "Hello, <br><br>Here is your Password Reset code:  {$validation_code} <br><br>Please <a href=\"".Config::ADMIN_URL."/code.php?email=$email&code=$validation_code\">Click Here </a>to reset your password.<br><br>Thanks,<br>Team Medywise";
                        $header = "From: noreply@medywise.com";

                        $this->sendMail($email, $subject, $message, $header);
                        $this->setMessage("<p class='bg-success text-center'>Please Check Your Email for Password Reset Code</p>");
                        $this->redirect("login.php");
                    } else {
                        echo $this->validationErrors("This email does not exists");
                    }
                } else {
                    $this->redirect("login.php");
                }

                if (isset($_POST['cancel_submit'])) {
                    $this->redirect("login.php");
                }
            }
        }//recoverAdminPassword(); End

        /*Code Validation Method*/
        public function codeValidation()
        {
            global $database;

            /* if (isset($_COOKIE['temp_access_code'])) { */
            if (!isset($_GET['email']) && !isset($_GET['code'])) {
                $this->redirect("login.php");
            } elseif (empty($_GET['email']) || empty($_GET['code'])) {
                $this->redirect("login.php");
            } else {
                if (isset($_POST['code'])) {
                    $email = $this->clean($_GET['email']);
                    $validation_code = $this->clean($_POST['code']);

                    $sql = "SELECT id FROM admin WHERE validation_code = '".$database->escape($validation_code)."' AND email = '".$database->escape($email)."'";
                    $result = $database->query($sql);

                    if ($database->numRows($result) == 1) {
                        setcookie('temp_access_code', $validation_code, time()+900);

                        $this->redirect("reset.php?email=$email&code=$validation_code");
                    } else {
                        echo $this->validationErrors("Sorry, wrong validation code!!");
                    }
                }
            }/*
            } else {
                $this->setMessage("<p class='bg-danger text-center'>Sorry, Validation Session Expired!!</p>");
                $this->redirect("recover.php");
            } */
        }//codeValidation(); End

        public function passwordReset()
        {
            global $database;
            if (isset($_COOKIE['temp_access_code'])) {
                if (isset($_GET['email']) && isset($_GET['code'])) {
                    if (isset($_SESSION['token']) && isset($_POST['token'])) {
                        if ($_POST['token'] === $_SESSION['token']) {
                            if ($_POST['password'] === $_POST['confirm_password']) {
                                $updatedPassword = md5($_POST['password']);
                                //$updatedPassword =password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost'=>12));

                                $sql = "UPDATE admin SET password = '".$database->escape($updatedPassword)."', validation_code = 0, active = 1 WHERE email = '".$database->escape($_GET['email'])."'";
                                $database->query($sql);

                                $this->setMessage("<p class='bg-success text-center'>Password Updated! Please Login</p>");
                                $this->redirect("login.php");
                            } else {
                                $this->setMessage("<p class='bg-danger text-center'>Passwords Don't Match</p>");
                            }
                        }
                    }
                }
            } else {
                $this->setMessage("<p class='bg-danger text-center'>Sorry, Session Expired</p>");
                $this->redirect("recover.php");
            }
        }//passwordReset(); End


        /********************************* Method To Register New Admin *********************************/

        public function validateNewAdminRequest()
        {
            $errors = [];
            $min = 3;
            $max = 20;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $email = $this->clean($_POST['email']);

                if ($this->emailExists($email)) {
                    $errors[] = "Email already registered.</br>";
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo $this->validationErrors($error);
                    }
                } else {
                    if ($this->sendJoinRequestToNewAdmin($email)) {
                        $this->setMessage("<p class='bg-success text-center'>Please ask new Admin to check email for registration link.</p>");
                        $this->redirect("view.php");
                    } else {
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

            if ($this->emailExists($email)) {
                return false;
            } else {
                $validation_code = md5($email . microtime());

                $sql = "INSERT INTO admin(email, validation_code, active)";
                $sql .= " VALUES('$email', '$validation_code', 0)";
                $result = $database->query($sql);

                $subject = "Welcome To Mediwise - Open To Join As Admin";
                $msg = "Hello, <br><br>Welcome To Medywise.<br><br>Your validation is: $validation_code<br>Please click the link to register your Account and join Medywise as Admin.<a href=\"".Config::ADMIN_URL."/reg_code.php?email=$email&code=$validation_code\"> Link Here </a>.<br><br>Thanks,<br>Team Medywise";
                $header = "From: noreply@medywise.com";

                $this->sendMail($email, $subject, $msg, $header);

                return true;
            }
        }//sendJoinRequestToNewAdmin(); End

        public function newAdminCodeValidation()
        {
            global $database;

            /*if(isset($_COOKIE['temp_access_code']))
            {*/
            if (!isset($_GET['email']) && !isset($_GET['code'])) {
                $this->redirect("login.php");
            } elseif (empty($_GET['email']) || empty($_GET['code'])) {
                $this->redirect("login.php");
            } else {
                if (isset($_POST['code'])) {
                    $email = $this->clean($_GET['email']);
                    $validation_code = $this->clean($_POST['code']);

                    $sql = "SELECT id FROM admin WHERE validation_code = '".$database->escape($validation_code)."' AND email = '".$database->escape($email)."'";
                    $result = $database->query($sql);

                    if ($database->numRows($result) == 1) {
                        setcookie('temp_access_code', $validation_code, time()+900);

                        $this->redirect("register.php?email=$email&code=$validation_code");
                    } else {
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
        }//newAdminCodeValidation();

        public function validateRegisterAdminByMail()
        {
            $errors = [];
            $min = 3;
            $max = 20;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $username           = $this->clean($_POST['username']);
                $password           = $this->clean($_POST['password']);
                $first_name         = $this->clean($_POST['first_name']);
                $last_name          = $this->clean($_POST['last_name']);
                //$email              = $this->clean($_POST['email']);
                $confirm_password   = $this->clean($_POST['confirm_password']);

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

                /* if ($this->emailExists($email)) {
                    $errors[] = "Email already registered.</br>";
                } */

                if ($password !== $confirm_password) {
                    $errors[] = "Your Passwords don't match.</br>";
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo $this->validationErrors($error);
                    }
                } else {
                    if ($this->registerAdminByMail($username, $password, $first_name, $last_name/*, $email*/)) {
                        $this->setMessage("<p class='bg-success text-center'>New Admin registered successfully. Please Login</p>");
                        $this->redirect("login.php");
                    } else {
                        $this->setMessage("<p class='bg-danger text-center'>Sorry, we could not register you as the New Admin.</p>");
                        $this->redirect("login.php");
                    }
                }
            }
        }//validateAdminRegistration(); End

        public function registerAdminByMail($username, $password, $first_name, $last_name/*, $email*/)
        {
            global $database;

            $username = $database->escape($username);
            $password = $database->escape($password);
            $first_name = $database->escape($first_name);
            $last_name = $database->escape($last_name);/*
            $email      = $database->escape($email);*/

            if ($this->emailExists($email)) {
                return false;
            } elseif ($this->usernameExists($username)) {
                return false;
            } else {
                //$password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
                $password = md5($password);
                $validation_code = md5($username . microtime());

                $sql = "UPDATE admin SET username = '" . $username . "', password = '" . $password . "', first_name = '" . $first_name . "', last_name = '" . $last_name . "', validation_code = 0, active = 1 WHERE email = '" . $database->escape($_GET['email']) . "'";
                $database->query($sql);

                return true;
            }
        }//registerAdmin(); End
    }
