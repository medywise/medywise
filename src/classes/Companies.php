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
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                if (strlen($name) > 50) {
                    $message = "'Name' must be under 40 characters";
                } else {
                    if (strlen($description) > 5000) {
                        $message = "'Description' must be under 6000 characters";
                    } else {
                        $this->name = $name;
                        $this->description = $description;
                        $this->setFile($_FILES['file_upload']);

                        if ($this->save()) {
                            $message = "New Company added successfully.";
                        } else {
                            $message = join("<br>", $this->customErrors);
                        }
                    }
                }
            }
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

                        $this->save();
                    }
                }
            }
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
    }
