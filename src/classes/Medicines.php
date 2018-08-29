<?php
    class Medicines extends Main
    {
        protected static $tableName = "medicines";
        protected static $dbTableFields = array('name', 'short_name', 'description', 'ratings', 'clicks', 'company_id', 'category_id', 'price', 'tags', 'type', 'used_for', 'also_called', 'available_as', 'how_to_store', 'how_to_take', 'side_effects', 'when_to_take', 'medicine_image');

        public $id;
        public $name;
        public $short_name;
        public $description;
        public $ratings;
        public $clicks;
        public $company_id;
        public $category_id;
        public $price;
        public $tags;
        public $type;
        public $used_for;
        public $also_called;
        public $available_as;
        public $how_to_store;
        public $how_to_take;
        public $side_effects;
        public $when_to_take;
        public $medicine_image;

        public $medicinesImagesDirectory = "medicine_images";
        public $defaultMedicinesImagePlaceholder = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . 'defaults' . 'image_not_available.jpg';

        public $tmp_path;
        public $customErrors = array();
        public $medicineImageUploadErrorsArray = array(
            UPLOAD_ERR_OK 			=>	"There is no error.",
            UPLOAD_ERR_INI_SIZE 	=>	"The uploaded file exceeds the upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE 	=>	"The uploaded file exceeds thr MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL 		=>	"The uploaded file was partially uploaded.",
            UPLOAD_ERR_NO_FILE 		=>	"No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR 	=>	"Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE 	=>	"Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION 	=>	"A PHP extension stopped the file upload."
        );

        public $cat_select;


        /********************************* Core Methods *********************************/

        public static function findAllMedicines()
        {
            return self::findMedicineByQuery("SELECT * FROM " . self::$tableName . " ");
        }

        public static function findMedicineById($id)
        {
            global $database;

            $resultArray = self::findMedicineByQuery("SELECT * FROM " . self::$tableName . " WHERE id=$id LIMIT 1");
            return !empty($resultArray) ? array_shift($resultArray) : false;
        }

        public static function findMedicineByQuery($sql)
        {
            global $database;

            $resultSet = $database->query($sql);
            $medicineObjectArray = array();
            while ($row = $database->fetchArray($resultSet)) {
                $medicineObjectArray[] = self::autoInstantiation($row);
            }
            return $medicineObjectArray;
        }
        
        //Could Check that $record Exists and is an Array.
        //Dynamic, Short-form Approach.
        public static function autoInstantiation($medicineRecord)
        {
            $medicineObject = new self();

            foreach ($medicineRecord as $attribute => $value) {
                if ($medicineObject->hasAttribute($attribute)) {
                    $medicineObject->$attribute = $value;
                }
            }
            return $medicineObject;
        }

        private function hasAttribute($attribute)
        {
            //get_object_vars Returns an Associative Array with All Attributes
            //(Including Private ones) as the Key and their Current Values as the Value.
            $medicineObjectProperties = get_object_vars($this);

            //We don't Care About the Value, We Just Want to Know if the Key Exists
            //Will Return True or False
            return array_key_exists($attribute, $medicineObjectProperties);
        }


        /********************************* Set File For Image Upload Method *********************************/
        
        // Pass in $_FILE(['uploaded_file']) as an argument
        public function setFile($file)
        {
            // Perform error checking on the form parameters
            if (empty($file) || !$file || !is_array($file)) {
                $this->customErrors[] = "There is no image uploaded.";
                return false;
            } elseif ($file['error'] !=0) {
                // error: report what PHP says went wrong
                $this->customErrors[] = $this->medicineImageUploadErrorsArray[$file['error']];
                return false;
            } else {
                // Set object attributes to the form parameters.
                $this->medicine_image = basename($file['name']);
                $this->tmp_path = $file['tmp_name'];
                // Don't worry about saving anything to the database yet.
            }
        }


        /********************************* Methods Related To Image Paths *********************************/

        public function medicinePicturePath()
        {
            $targetPath = "../../../assets/images/medicine_images";
            return $targetPath . DS . $this->medicine_image;
            //return $this->companyImagesDirectory . DS . $this->medicine_image;
        }

        public function medicineImagePathAndPlaceholder()
        {
            return empty($this->medicine_image) ? $this->defaultMedicinesImagePlaceholder : $this->medicinesImagesDirectory . DS . $this->medicine_image;
        }


        /********************************* Add Method *********************************/

        public function addNewMedicine($name, $short_name, $description, $ratings, $company_id, $category_id, $price, $tags, $type, $used_for, $also_called, $available_as, $how_to_store, $how_to_take, $side_effects, $when_to_take)
        {
            // if (isset($_POST['submit'])) {
            //     $name = $_POST['name'];
            //     $short_name = $_POST['short_name'];
            //     $description = $_POST['description'];
            //     $ratings = $_POST['ratings'];
            //     $company_id = $_POST['company_id'];
            //     $category_id = $_POST['category_id'];
            //     $price = $_POST['price'];
            //     $tags = $_POST['tags'];
            //     $type = $_POST['type'];
            //     $used_for = $_POST['used_for'];
            //     $also_called = $_POST['also_called'];
            //     $available_as = $_POST['available_as'];
            //     $how_to_store = $_POST['how_to_store'];
            //     $how_to_take = $_POST['how_to_take'];
            //     $side_effects = $_POST['side_effects'];
            //     $when_to_take = $_POST['when_to_take'];
            $message = '';
            if (strlen($name) > 60) {
                $message = "'Name' must be under 60 characters";
            }

            if (strlen($short_name) > 40) {
                $message = "'Short Name' must be under 40 characters";
            }

            if (strlen($description) > 6000) {
                $message = "'Description' must be under 6000 characters";
            }

            if (strlen($tags) > 255) {
                $message = "'Tag' must be under 255 characters";
            }

            if (strlen($type) > 255) {
                $message = "'Type' must be under 255 characters";
            }

            if (strlen($used_for) > 255) {
                $message = "'User For' must be under 255 characters";
            }

            if (strlen($also_called) > 255) {
                $message = "'Also Called' must be under 255 characters";
            }

            if (strlen($also_called) > 255) {
                $message = "'Also Called' must be under 255 characters";
            }

            if (strlen($available_as) > 255) {
                $message = "'Available As' must be under 255 characters";
            }

            if (strlen($how_to_store) > 255) {
                $message = "'How to Store' must be under 255 characters";
            }

            if (strlen($how_to_take) > 255) {
                $message = "'How to Take' must be under 255 characters";
            }

            if (strlen($side_effects) > 255) {
                $message = "'Side Effects' must be under 255 characters";
            }

            if (strlen($when_to_take) > 255) {
                $message = "'When to Take' must be under 255 characters";
            }
           
            // if (filter_var($ratings, FILTER_VALIDATE_INT)) {
            //     $message = "'Rating' must be in Integer & between 1 to 5";
            // }
           
            // if (filter_var($price, FILTER_VALIDATE_INT)) {
            //     $message = "'Price' must be in Integer";
            // }
            
            if (!$message) {
                $this->name = $name;
                $this->short_name = $short_name;
                $this->description = $description;
                $this->ratings = $ratings;
                $this->company_id = $company_id;
                $this->category_id = $category_id;
                $this->price = $price;
                $this->tags = $tags;
                $this->type = $type;
                $this->used_for = $used_for;
                $this->also_called = $also_called;
                $this->available_as = $available_as;
                $this->how_to_store = $how_to_store;
                $this->how_to_take = $how_to_take;
                $this->side_effects = $side_effects;
                $this->when_to_take = $when_to_take;
                $this->setFile($_FILES['file_upload']);
                if ($this->save()) {
                    $message = "New Medicine added successfully.";
                } else {
                    $message = join("<br>", $this->customErrors);
                }
            }
            return $message;
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
                // Checks if $medicine_image is empty or $tmp_path is empty or not.
                if (empty($this->medicine_image) || empty($this->tmp_path)) {
                    $this->customErrors[] = "Image file not available";
                    return false;
                }

                //Sets image file to $targetPath
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'images' . DS . $this->medicinesImagesDirectory . DS . $this->medicine_image;

                // Make sure a file doesn't already exist in the target location
                if (file_exists($targetPath)) {
                    $this->customErrors[] = "The file {$this->medicine_image} already exists";
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

        public function updateMedicine($name, $short_name, $description, $ratings, $company_id, $category_id, $price, $tags, $type, $used_for, $also_called, $available_as, $how_to_store, $how_to_take, $side_effects, $when_to_take)
        {
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $short_name = $_POST['short_name'];
                $description = $_POST['description'];
                $ratings = $_POST['ratings'];
                $company_id = $_POST['company_id'];
                $category_id = $_POST['category_id'];
                $price = $_POST['price'];
                $tags = $_POST['tags'];
                $type = $_POST['type'];
                $used_for = $_POST['used_for'];
                $also_called = $_POST['also_called'];
                $available_as = $_POST['available_as'];
                $how_to_store = $_POST['how_to_store'];
                $how_to_take = $_POST['how_to_take'];
                $side_effects = $_POST['side_effects'];
                $when_to_take = $_POST['when_to_take'];

                if (strlen($name) > 60) {
                    $message = "'Name' must be under 60 characters";
                } else {
                    if (strlen($short_name) > 40) {
                        $message = "'Short Name' must be under 40 characters";
                    } else {
                        if (strlen($description) > 6000) {
                            $message = "'Description' must be under 6000 characters";
                        } else {
                            if (filter_var($ratings, FILTER_VALIDATE_INT)) {
                                if (filter_var($price, FILTER_VALIDATE_INT)) {
                                    if (strlen($tags) > 255) {
                                        $message = "'Tag' must be under 255 characters";
                                    } else {
                                        if (strlen($type) > 255) {
                                            $message = "'Type' must be under 255 characters";
                                        } else {
                                            if (strlen($used_for) > 255) {
                                                $message = "'User For' must be under 255 characters";
                                            } else {
                                                if (strlen($also_called) > 255) {
                                                    $message = "'Also Called' must be under 255 characters";
                                                } else {
                                                    if (strlen($also_called) > 255) {
                                                        $message = "'Also Called' must be under 255 characters";
                                                    } else {
                                                        if (strlen($available_as) > 255) {
                                                            $message = "'Available As' must be under 255 characters";
                                                        } else {
                                                            if (strlen($how_to_store) > 255) {
                                                                $message = "'How to Store' must be under 255 characters";
                                                            } else {
                                                                if (strlen($how_to_take) > 255) {
                                                                    $message = "'How to Take' must be under 255 characters";
                                                                } else {
                                                                    if (strlen($side_effects) > 255) {
                                                                        $message = "'Side Effects' must be under 255 characters";
                                                                    } else {
                                                                        if (strlen($when_to_take) > 255) {
                                                                            $message = "'When to Take' must be under 255 characters";
                                                                        } else {
                                                                            $this->name = $_POST['name'];
                                                                            $this->short_name = $_POST['short_name'];
                                                                            $this->description = $_POST['description'];
                                                                            $this->ratings = $_POST['ratings'];
                                                                            $this->company_id = $_POST['company_id'];
                                                                            $this->category_id = $_POST['category_id'];
                                                                            $this->price = $_POST['price'];
                                                                            $this->tags = $_POST['tags'];
                                                                            $this->type = $_POST['type'];
                                                                            $this->used_for = $_POST['used_for'];
                                                                            $this->also_called = $_POST['also_called'];
                                                                            $this->available_as = $_POST['available_as'];
                                                                            $this->how_to_store = $_POST['how_to_store'];
                                                                            $this->how_to_take = $_POST['how_to_take'];
                                                                            $this->side_effects = $_POST['side_effects'];
                                                                            $this->when_to_take = $_POST['when_to_take'];

                                                                            $this->save();
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $message = "'Price' must be in Integer & between 1 to 5";
                                }
                            } else {
                                $message = "'Rating' must be in Integer";
                            }
                        }
                    }
                }
            }
        }


        /********************************* Update Image In Photo Modal Method *********************************/

        public function ajaxUpdateMedicineImage($medicine_image, $medicine_id)
        {
            global $database;

            $medicine_image = $database->escapeString($medicine_image);
            $medicine_id = $database->escapeString($medicine_id);

            $this->medicine_image = $medicine_image;
            $this->id = $medicine_id;

            $sql = "UPDATE " . self::$tableName . " SET medicine_image = '{$this->medicine_image}' ";
            $sql .= "WHERE id = {$this->id} ";
            $updateImage = $database->query($sql);

            echo $this->companyImagePathAndPlaceholder();

            /*$this->save();*/
        }


        /********************************* Delete Method *********************************/

        public function deleteMedicine()
        {
            // First remove the database entry
            if ($this->delete()) {
                // then remove the file
                // Note that even though the database entry is gone, this object
                // is still around (which lets us use $this->medicine_image()).
                $targetPath = MAIN_ROOT . DS . 'assets' . DS . 'medicine_images' . DS . $this->medicine_image;
                return unlink($targetPath) ? true : false;
            } else {
                // database delete failed
                return false;
            }
        }


        /********************************* Import/Export Categories through Excel/Csv files Method *********************************/

        public function importMedicinesViaFile($file)
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

                    $sql = "INSERT INTO medicines(name, short_name, description, ratings, price, tags, type, used_for, also_called, available_as, how_to_store, how_to_take, side_effects, when_to_take) VALUES(" . $value . ")";
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
        }//importMedicinesViaFile(); End

        public function exportMedicinesViaFile()
        {
            global $database;

            $this->state_csv = false;

            $sql = "SELECT m.name, m.short_name, m.description, m.ratings, m.price, m.tags, m.type, m.used_for, m.also_called, m.available_as, m.how_to_store, m.how_to_take, m.side_effects, m.when_to_take FROM medicines as m";
            $result = $database->query($sql);

            if ($database->numRows($result) > 0) {
                // Sets the file name
                $fn = "medicines_" . uniqid() . ".csv";

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
        }//exportMedicinesViaFile(); End

        public function exportMedicinesToFile()
        {
            global $database;

            //get records from database
            $sql = "SELECT * FROM medicines ORDER BY id ASC";
            $result = $database->query($sql);

            if ($database->numRows($result) > 0) {
                $delimiter = ",";
                $filename = "medicines_" . date('Y-m-d') . ".csv";
            
                //create a file pointer
                $f = fopen('php://memory', 'w');
            
                //set column headers
                $fields = array('ID', 'Name', 'Description');
                fputcsv($f, $fields, $delimiter);
            
                //('name', 'short_name', 'description', 'ratings', 'price', 'tags', 'type', 'used_for', 'also_called', 'available_as', 'how_to_store', 'how_to_take', 'side_effects', 'when_to_take')
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
        }//exportMedicinesToFile(); End
    }//End of Class
