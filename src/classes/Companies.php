<?php
    class Companies extends Main
    {
        protected static $tableName = "company";
        protected static $dbTableFields = array('name', 'description', 'company_image');

        public $id;
        public $name;
        public $description;
        public $company_image;

        public $companyImagesDirectory = "company_images";
        public $defaultCompanyImagePlaceholder = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . 'defaults' . 'image_not_available.jpg';

        public $tmp_path;
        public $customErrors = array();
        public $companyImageUploadErrorsArray = array(
            UPLOAD_ERR_OK 			=>	"There is no error.",
            UPLOAD_ERR_INI_SIZE 	=>	"The uploaded file exceeds the upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE 	=>	"The uploaded file exceeds thr MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL 		=>	"The uploaded file was partially uploaded.",
            UPLOAD_ERR_NO_FILE 		=>	"No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR 	=>	"Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE 	=>	"Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION 	=>	"A PHP extension stopped the file upload."
        );


        /********************************* Core Methods *********************************/

        public static function findAllCompanies()
        {
            return self::findCompanyByQuery("SELECT * FROM " . self::$tableName . " ");
        }

        public static function findCompanyById($id)
        {
            global $database;

            $resultArray = self::findCompanyByQuery("SELECT * FROM " . self::$tableName . " WHERE id=$id LIMIT 1");
            return !empty($resultArray) ? array_shift($resultArray) : false;
        }

        public static function findCompanyByQuery($sql)
        {
            global $database;

            $resultSet = $database->query($sql);
            $companyObjectArray = array();
            while ($row = $database->fetchArray($resultSet)) {
                $companyObjectArray[] = self::autoInstantiation($row);
            }
            return $companyObjectArray;
        }

        //Could Check that $record Exists and is an Array.
        //Dynamic, Short-form Approach.
        public static function autoInstantiation($companyRecord)
        {
            $companyObject = new self();

            foreach ($companyRecord as $attribute => $value) {
                if ($companyObject->hasAttribute($attribute)) {
                    $companyObject->$attribute = $value;
                }
            }
            return $companyObject;
        }

        private function hasAttribute($attribute)
        {
            //get_object_vars Returns an Associative Array with All Attributes
            //(Including Private ones) as the Key and their Current Values as the Value.
            $companyObjectProperties = get_object_vars($this);

            //We don't Care About the Value, We Just Want to Know if the Key Exists
            //Will Return True or False
            return array_key_exists($attribute, $companyObjectProperties);
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
            } elseif ($file['error'] !=0) {
                // error: report what PHP says went wrong
                $this->customErrors[] = $this->companyImageUploadErrorsArray[$file['error']];
                return false;
            } else {
                // Set object attributes to the form parameters.
                $this->company_image = basename($file['name']);
                $this->tmp_path = $file['tmp_name'];
                // Don't worry about saving anything to the database yet.
            }
        }


        /********************************* Methods Related To Image Paths *********************************/

        public function companyPicturePath()
        {
            $targetPath = "../../../assets/images/company_images";
            return $targetPath . DS . $this->company_image;
            //return $this->companyImagesDirectory . DS . $this->company_image;
        }

        public function companyImagePathAndPlaceholder()
        {
            return empty($this->company_image) ? $this->defaultCompanyImagePlaceholder : $this->companyImagesDirectory . DS . $this->company_image;
        }


        /********************************* Add Method *********************************/

        public function addNewCompany($name, $description)
        {
            global $session;

            if (strlen($name) > 50) {
                $message = "'Name' must be under 40 characters";
            }
            
            if (strlen($description) > 5000) {
                $message = "'Description' must be under 6000 characters";
            }

            if (!$session->message()) {
                $this->name = $name;
                $this->description = $description;
                $this->setFile($_FILES['file_upload']);

                if ($this->save()) {
                    //$message = "New Company added successfully.";
                    $session->message("New Company added successfully");
                    $this->redirect("view.php");
                } else {
                    $session->message(join("<br>", $this->customErrors));
                }
            }

            // if (strlen($name) > 50) {
            //     $message = "'Name' must be under 40 characters";
            // }

            // if (strlen($description) > 5000) {
            //     $message = "'Description' must be under 6000 characters";
            // }

            // if (!$message) {
            //     $this->name = $name;
            //     $this->description = $description;

            //     if (empty($_FILES['file_upload'])) {
            //         $this->save();
            //     } else {
            //         $this->setFile($_FILES['file_upload']);

            //         if ($this->save()) {
            //             $message = "New Company added successfully.";
            //         } else {
            //             $message = join("<br>", $this->customErrors);
            //         }
            //     }
            // }
        }


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
                if (empty($this->company_image) || empty($this->tmp_path)) {
                    $this->customErrors[] = "Image file not available";
                    return false;
                }

                //Sets image file to $targetPath
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . $this->companyImagesDirectory . DS . $this->company_image;

                // Make sure a file doesn't already exist in the target location
                if (file_exists($targetPath)) {
                    $this->customErrors[] = "The file {$this->company_image} already exists";
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
        }

        public function updateCompany($name, $description)
        {
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                if (strlen($name) > 50) {
                    $message = "'Name' must be under 40 characters";
                } else {
                    if (strlen($description) > 5000) {
                        $message = "'Description' must be under 6000 characters";
                    } else {
                        $this->name = $_POST['name'];
                        $this->description = $_POST['description'];
                        $this->redirect("view.php");

                        $this->save();
                    }
                }
            }
                
            // if (strlen($name) > 50) {
                //     $message = "'Name' must be under 40 characters";
                // }

                // if (strlen($description) > 5000) {
                //     $message = "'Description' must be under 6000 characters";
                // }

                // if (empty($_FILES['file_update'])) {
                //     $this->save();
                // } else {
                //     $this->name = $_POST['name'];
                //     $this->description = $_POST['description'];

                //     $this->save();
                // }
        }//updateCompany(); End


        /********************************* Update Image In Photo Modal Method *********************************/

        public function ajaxUpdateCompanyImage($company_image, $company_id)
        {
            global $database;

            $company_image = $database->escapeString($company_image);
            $company_id = $database->escapeString($company_id);

            $this->company_image = $company_image;
            $this->id = $company_id;

            $sql = "UPDATE " . self::$tableName . " SET company_image = '{$this->company_image}' ";
            $sql .= "WHERE id = {$this->id} ";
            $updateImage = $database->query($sql);

            echo $this->companyImagePathAndPlaceholder();

            /*$this->save();*/
        }


        /********************************* Delete Method *********************************/

        public function deleteCompany()
        {
            // First remove the database entry
            if ($this->delete()) {
                // then remove the file
                // Note that even though the database entry is gone, this object
                // is still around (which lets us use $this->company_image()).
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'company_images' . DS . $this->company_image;
                return unlink($targetPath) ? true : false;
            } else {
                // database delete failed
                return false;
            }
        }


        /********************************* Import/Export Categories through Excel/Csv files Method *********************************/

        public function importCompaniesViaFile($file)
        {
            global $database;

            $first = false;
            $this->state_csv = false;
            $file = fopen($file, 'r');

            while ($row = fgetcsv($file)) {
                if (!$first) {
                    $first = true;
                } else {
                    $value = "'" . implode("','", $row) . "'";

                    $sql = "INSERT INTO company(name, description) VALUES(" . $value . ")";
                    if ($database->query($sql)) {
                        $this->state_csv = true;
                    } else {
                        $this->state_csv = false;
                    }
                }
            }

            if ($this->state_csv) {
                $message = "File added successfully.";
            } else {
                $message = "Something went wrong.";
            }
        }//importCompaniesViaFile(); End

        // This method adds full page HTML code in the file too
        public function exportCompaniesViaFile()
        {
            global $database;

            $this->state_csv = false;

            $sql = "SELECT c.name, c.description FROM company as c";
            $result = $database->query($sql);

            if ($database->numRows($result) > 0) {
                // Sets the file name
                $fn = "companies_" . uniqid() . ".csv";

                // Either A of B is used at one time
                // We can also use both of them at a single time, but that was not good practice

                // A
                //This will save file to the server
                //$file = fopen($fn, "w");

                //Fetches the result from the row
                while ($row = $database->fetchArray($result)) {
                    if (fputcsv($file, $row)) {
                        $this->state_csv = true;
                    } else {
                        $this->state_csv = false;
                    }
                }

                // B
                //This will force file to download
                header("Content-disposition: attachment; filename=$fn");
                header('Content-type: text/csv');
                readfile($fn);

                if ($this->state_csv) {
                    $message = "File successfully exported";
                } else {
                    $message = "Something went wrong.";
                }
                fclose($file);
            } else {
                $message = "No data found in categories table!";
            }
        }//exportCompaniesViaFile(); End

        // This method picks values from databse, but it also adds HTML page header code
        // But it is minimal as compare with exportCompaniesViaFile() Method
        public function exportCompaniesToFile()
        {
            global $database;

            //get records from database
            $sql = "SELECT * FROM company ORDER BY id ASC";
            $result = $database->query($sql);

            if ($database->numRows($result) > 0) {
                $delimiter = ",";
                $filename = "companies_" . date('Y-m-d') . ".csv";
            
                //create a file pointer
                $f = fopen('php://memory', 'w');
            
                //set column headers
                $fields = array('ID', 'Name', 'Description');
                fputcsv($f, $fields, $delimiter);
            
                //output each row of the data, format line as csv and write to file pointer
                while ($row = mysqli_fetch_assoc($result)) {
                    //$status = ($row['status'] == '1') ? 'Active' : 'Inactive';
                    $lineData = array($row['id'], $row['name'], $row['description']);
                    fputcsv($f, $lineData, $delimiter);
                }
            
                //move back to beginning of file
                fseek($f, 0);
            
                //set headers to download file rather than displayed
                header("Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0, public, max-age=31536000");
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '";');
            
                //output all remaining data on a file pointer
                fpassthru($f);
            }
            exit;
        }//exportCompaniesToFile(); End
    }//End of Class
