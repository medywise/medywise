<?php
    if (empty($_GET['id']))
    {
        redirectTo("view.php");
    }
    else
    {
        $medicine = Medicines::findMedicineById($_GET['id']);

        $message = "";
        if (isset($_POST['update']))
        {
            if ($medicine)
            {  
                $name = $_POST['name'];
                $short_name = $_POST['short_name'];
                $description = $_POST['description'];
                $ratings = $_POST['ratings'];
                /*$clicks = $_POST['clicks'];*/
                $company_id = $_POST['company_id'];
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

                if(strlen($name) > 60)
                {
                    $message = "'Name' must be under 60 characters"; 
                }
                else
                {
                    if(strlen($short_name) > 40)
                    {
                        $message = "'Short Name' must be under 40 characters"; 
                    }
                    else
                    {
                        if(strlen($description) > 6000)
                        {
                            $message = "'Description' must be under 6000 characters"; 
                        }
                        else
                        {
                            if (filter_var($ratings, FILTER_VALIDATE_INT))
                            {
                                if (filter_var($price, FILTER_VALIDATE_INT))
                                {
                                    if(strlen($tags) > 255)
                                    {
                                        $message = "'Tag' must be under 255 characters"; 
                                    }
                                    else
                                    {
                                        if(strlen($type) > 255)
                                        {
                                            $message = "'Type' must be under 255 characters"; 
                                        }
                                        else
                                        {
                                            if(strlen($used_for) > 255)
                                            {
                                                $message = "'User For' must be under 255 characters"; 
                                            }
                                            else
                                            {
                                                if(strlen($also_called) > 255)
                                                {
                                                    $message = "'Also Called' must be under 255 characters"; 
                                                }
                                                else
                                                {
                                                    if(strlen($also_called) > 255)
                                                    {
                                                        $message = "'Also Called' must be under 255 characters"; 
                                                    }
                                                    else
                                                    {
                                                        if(strlen($available_as) > 255)
                                                        {
                                                            $message = "'Available As' must be under 255 characters"; 
                                                        }
                                                        else
                                                        {
                                                            if(strlen($how_to_store) > 255)
                                                            {
                                                                $message = "'How to Store' must be under 255 characters"; 
                                                            }
                                                            else
                                                            {
                                                                if(strlen($how_to_take) > 255)
                                                                {
                                                                    $message = "'How to Take' must be under 255 characters"; 
                                                                }
                                                                else
                                                                {
                                                                    if(strlen($side_effects) > 255)
                                                                    {
                                                                        $message = "'Side Effects' must be under 255 characters"; 
                                                                    }
                                                                    else
                                                                    {
                                                                        if(strlen($when_to_take) > 255)
                                                                        {
                                                                            $message = "'When to Take' must be under 255 characters"; 
                                                                        }
                                                                        else
                                                                        {
                                                                            $medicine->name = $_POST['name'];
                                                                            $medicine->short_name = $_POST['short_name'];
                                                                            $medicine->description = $_POST['description'];
                                                                            $medicine->ratings = $_POST['ratings'];
                                                                            /*$medicine->clicks = $_POST['clicks'];*/
                                                                            $medicine->company_id = $_POST['company_id'];
                                                                            $medicine->price = $_POST['price'];
                                                                            $medicine->tags = $_POST['tags'];
                                                                            $medicine->type = $_POST['type'];
                                                                            $medicine->used_for = $_POST['used_for'];
                                                                            $medicine->also_called = $_POST['also_called'];
                                                                            $medicine->available_as = $_POST['available_as'];
                                                                            $medicine->how_to_store = $_POST['how_to_store'];
                                                                            $medicine->how_to_take = $_POST['how_to_take'];
                                                                            $medicine->side_effects = $_POST['side_effects'];
                                                                            $medicine->when_to_take = $_POST['when_to_take'];

                                                                            $medicine->save();
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
                                }
                                else
                                {
                                    $message = "'Price' must be in Integer & between 1 to 5"; 
                                }
                            }
                            else
                            {
                                $message = "'Rating' must be in Integer"; 
                            }
                        }
                    }
                }
            }
        }
    }
?>