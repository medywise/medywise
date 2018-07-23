<?php require_once('../../initialize.php'); ?>
<?php
    $message = "";
    if (isset($_POST['submit']))
    {
        $admin = new Admin();
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
            if(strlen($pwdStr) > 25 || strlen($pwdStr) < 5)
            {
                $message = "Password must be between 5 and 25 characters"; 
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
                            $admin->username = $username;
                            $admin->password = $pwd;
                            $admin->first_name = $first_name;
                            $admin->last_name = $last_name;
                            $admin->email = $email;
                            $admin->setFile($_FILES['file_upload']);

                            if ($admin->save())
                            {
                                $message = "New Admin added successfully";
                            }
                            else
                            {
                                $message = join("<br>", $admin->customErrors);
                            }
                        }
                    }
                }
            }
        }
    }
?>