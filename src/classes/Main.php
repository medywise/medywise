<?php
    # To understand recursion, see the bottom of this file

    class Main
    {
    /********************************* Helper Methods *********************************/

        public function clean($string)
        {
            return htmlentities($string);
        }// clean(); End

        public function redirect($location)
        {
            return header("Location: {$location}");
        }// redirect(); End

        public function tokenGenerator()
        {
            $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
            return $token;
        }// tokenGenerator(); End


        /********************************* Methods Related To Display/Set/Show Errors or Messages *********************************/

        public function setMessage($message)
        {
            if (!empty($message)) {
                $_SESSION['message'] = $message;
            } else {
                $message = "";
            }
        }// setMessage(); End

        public function displayMessage()
        {
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
        }// displayMessage();

        public function validationErrors($errorMessage)
        {
            $errorMessage = <<<DELIMITER
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Warning! </strong>$errorMessage
            </div>
DELIMITER;
            return $errorMessage;
        }// validationErrors(); End


        /********************************* Methods To Check If Username or Email Exists *********************************/

        public function emailExists($email)
        {
            global $database;

            $sql = "SELECT id FROM ". static::$tableName ." WHERE email = '$email'";
            $result = $database->query($sql);

            if ($database->numRows($result) == 1) {
                return true;
            } else {
                return false;
            }
        }//emailExists(); End

        public function usernameExists($username)
        {
            global $database;

            $sql = "SELECT id FROM ". static::$tableName ." WHERE username = '$username'";
            $result = $database->query($sql);

            if ($database->numRows($result) == 1) {
                return true;
            } else {
                return false;
            }
        }//usernameExists(); End


        /********************************* Methods To Send Email *********************************/

        //Sends Email To Gmail Account
        //Sends Email To The User or The Admin
        //Can Be Used In Sending Registeration Or Password Link To The User or Admin
        public function sendMail($email = null, $subject = null, $msg = null, $header = null)
        {
            $em = Config::SMTP_GOOGLE_EMAIL;
            $pwd = Config::SMTP_GOOGLE_PASSWORD;

            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->isSMTP();
            $mail->Host = Config::SMTP_GOOGLE_HOST;
            $mail->Port = Config::SMTP_GOOGLE_PORT;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->isHTML(true);
            $mail->CharSet = "utf-8";

            $mail->Username = $em;
            $mail->Password = $pwd;

            $mail->SetFrom("noreply@medywise.com", "Medywise");
            $mail->addAddress($email);

            $mail->Subject = $subject;
            $mail->Body = $msg;
            $mail->AltBody = $msg;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            if (!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            } else {
                echo 'Message has been sent, Please check your Inbox or Spam folder.';
            }
        }//sendMail(); End.

        public function sendContactEmail($to, $from, $fromName, $body)
        {
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->setFrom($from, $fromName);
            $mail->addAddress($to);

            $mail->Subject = 'Mail from Medywise Contact Us Page';
            $mail->Body = $body;
            $mail->isHTML(true);

            if ($mail->send()) {
                echo "<p class='bg-success text-center'>Message successfully sent</p>";
            
            } else {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        }

        //Sends Email To Mailtrap Account
        public function sendEmail($email=null, $subject=null, $msg=null, $header=null)
        {
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->isSMTP();
            $mail->Host = Config::SMTP_MAILTRAP_HOST;
            $mail->Username = Config::SMTP_MAILTRAP_USER;
            $mail->Password = Config::SMTP_MAILTRAP_PASSWORD;
            $mail->Port = Config::SMTP_MAILTRAP_PORT;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('noreply@mediwise.com', 'Gurjot');
            $mail->addAddress($email);
                                     
            $mail->Subject = $subject;
            $mail->Body    = $msg;
            $mail->AltBody = $msg;

            if (!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        }//sendEmail(); End


        /********************************* Method To Count Number Of Enteries In A Table *********************************/

        // This function doesn't do what you think it does. Turn back now.
        // - NDW 2/8/2018
        // Just joking
        public static function countAll()
        {
            global $database;

            $sql = "SELECT COUNT(*) FROM " . static::$tableName;
            $resultSet = $database->query($sql);
            $row = $database->fetchArray($resultSet);
            
            return $database->arrayShift($row);
        }// countAll(); End


        /********************************* Core Databse Methods *********************************/

        /* Please work */
        protected function tableProperties()
        {
            // return an array of attribute names and their values
            $properties = array();

            foreach (static::$dbTableFields as $dbTableField) {
                if (property_exists($this, $dbTableField)) {
                    $properties[$dbTableField] = $this->$dbTableField;
                }
            }

            return $properties;
        }// tableProperties(); End
        
        // code below helps code above - any problems?
        protected function cleanProperties()
        {
            global $database;

            $cleanProperties = array();

            // sanitize the values before submitting
            // Note: does not alter the actual value of each attribute
            foreach ($this->tableProperties() as $key => $value) {
                $cleanProperties[$key] = $database->escapeString($value);
            }

            return $cleanProperties;
        }// cleanProperties(); End


        /********************************* CRUD Methods *********************************/

        public function save()
        {
            // A new record won't have an id yet.
            return isset($this->id) ? $this->update() : $this->create();
        }// save(); End

        public function create()
        {
            global $database;
            
            // - INSERT INTO table (key, key) VALUES ('value', 'value')
            // - single-quotes around all values
            // - escape all values to prevent SQL injection
            $properties = $this->cleanProperties();

            $sql = "INSERT INTO " . static::$tableName . "(" . implode(",", array_keys($properties)) . ")";
            $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";
            
            if ($database->query($sql)) {
                $this->id = $database->insertId();
                return true;
            } else {
                return false;
            }
        }// create(); End

        public function update()
        {
            global $database;

            // - UPDATE table SET key='value', key='value' WHERE condition
            // - single-quotes around all values
            // - escape all values to prevent SQL injection
            $properties = $this->cleanProperties();
            $propertyPairs = array();

            foreach ($properties as $key => $value) {
                $propertyPairs[] = "{$key}='{$value}'";
            }

            $sql = "UPDATE " . static::$tableName . " SET ";
            $sql .= implode(", ", $propertyPairs);
            $sql .= " WHERE id= " . $database->escapeString($this->id);

            $database->query($sql);

            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        }// update(); End

        public function delete()
        {
            global $database;

            // - DELETE FROM table WHERE condition LIMIT 1
            // - escape all values to prevent SQL injection
            // - use LIMIT 1
            $sql = "DELETE FROM " . static::$tableName . " ";
            $sql .= "WHERE id=" . $database->escapeString($this->id);
            $sql .= " LIMIT 1";

            $database->query($sql);
            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
            // NB: After deleting, the instance of User still
            // exists, even though the database entry does not.
            // This can be useful, as in:
            // Example:  echo $user->first_name . " was deleted";
            // but, we can't call $user->update()
            // after calling $user->delete().
        }//delete(); End

    }//End of Class

    # To understand recursion, see the top of this file