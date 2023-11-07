<?php
session_start();
include '../model/ingredients_model.php';
$ingredientObj = new ingredient();
   
if (isset($_GET['status']) && $_GET['status'] === 'add-ingredient') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $ingName = $_POST['ing_Name'];
        $ingDescription = $_POST['ing_descript']; 
        $factorId = $_POST['factors'];

        try {
            if ($ingName == '') {
                throw new Exception("Ingredient Name cannot be empty!");
            }
            $path = ''; // Initialize path as an empty string

            if ($_FILES["ing_image"]["name"]) {
                // A new image file has been uploaded
                // Define the uploaded file based on the input field name (ing_image)
                $imgname = time() . "_" . $_FILES["ing_image"]["name"];
                $path = "../images/ing_img/$imgname";

                if (move_uploaded_file($_FILES["ing_image"]["tmp_name"], $path)) {
                    // Image upload was successful
                } else {
                    $error = error_get_last();
                    throw new Exception("Cannot upload due to image upload error: " . $error['message']);
                }
                                         
            }
            $ingredientObj->addIngredient($ingName, $ingDescription,$path,$factorId);
                $addmsg = "Ingredient added successfully!";
                $addmsg = base64_encode($addmsg);
                header("location:../view/module/admin/ingredients-management/ingredients.php?addmsg=$addmsg");
            

                                        
        } catch (Exception $ex) {
            $addmsg = $ex->getMessage();  
            $addmsg = base64_encode($addmsg);
            header("location:../view/module/admin/ingredients-management/ingredients.php?addmsg=$addmsg"); 
        }
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'edit-ingredient') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the edit-ingredient form
        $ingName = $_POST['ing_Name'];
        $ingDescription = $_POST['ing_descript']; 
        $ingg_id = $_POST['ing_id'];
        $factor_id = $_POST['factors'];

        try {
            if ($ingName == '') {
                throw new Exception("Ingredient Name cannot be empty!");
            }
            
            $path = ''; // Initialize path as an empty string

            if ($_FILES["ing_image"]["name"]) {
                // A new image file has been uploaded
                // Define the uploaded file based on the input field name (ing_image)
                $imgname = time() . "_" . $_FILES["ing_image"]["name"];
                $path = "../images/ing_img/$imgname";

                if (move_uploaded_file($_FILES["ing_image"]["tmp_name"], $path)) {
                    // Image upload was successful
                } else {
                    $error = error_get_last();
                    throw new Exception("Cannot update due to image upload error: " . $error['message']);
                }
            }

            // Update the ingredient information, including the image path if a new image was uploaded
            $ingredientObj->updateingredients($ingName, $ingDescription, $ingg_id,$factor_id);

            $msg = "Ingredient updated successfully!";
            $msg = base64_encode($msg);
            $ingg_id = base64_encode($ingg_id);
            header("location:../view/module/admin/ingredients-management/edit-ingredients.php?msg=$msg&ingid=$ingg_id");

            if ($path) {
                // A new image has been uploaded, update the image path in the database
                $ingg_id = base64_decode($ingg_id);
                $ingredientObj->updateingredientImage($path, $ingg_id);
                $ingg_id = base64_encode($ingg_id);
                $msg = "Ingredient image updated successfully!";
            $msg = base64_encode($msg);
            header("location:../view/module/admin/ingredients-management/edit-ingredients.php?msg=$msg&ingid=$ingg_id");

            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();  
            $msg = base64_encode($msg);
            header("location:../view/module/admin/ingredients-management/edit-ingredients.php?msg=$msg"); 
        }
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'remove-ingredient') {
    $ing_id = base64_decode($_GET['ingid']);
    $ingredientObj->removeIngredient($ing_id);
    $msg="Ingredient Removed Successfully !";
    // $msg= base64_encode($msg);
    header("location:../view/module/admin/ingredients-management/ingredients.php?msg=$msg");
}
if (isset($_GET['status']) && $_GET['status'] === 'update-ingredient-qty') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ingg_id = $_POST['data'];
        $ingg_id = base64_decode($ingg_id);

        // Retrieve the data you want to send
        $ingredientqtyResult = $ingredientObj->getIngredienttoUpdate($ingg_id);
        $ingqtyrow = $ingredientqtyResult->fetch_assoc();

        // Create a response with the remaining quantity
        $response = array(
            'ing_id' => $ingqtyrow['ing_id'],
            'ing_name' => $ingqtyrow['ing_name'],
            'factor_id' => $ingqtyrow['factor_id'],
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        echo "failed to retrieve";
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'update-stock') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $ing_id = $_POST['ingredient_id'];
       $updateqty =  $_POST['updatestockvalue'];
       $calculate = $_POST['calculation-selector'];
       $factor_Id = $_POST['factor_id'];

       if($calculate  === 'add'){
        if($factor_Id ==='1'){
        $ingredientObj->addstock_G($ing_id,$updateqty);
        
        }
        elseif($factor_Id ==='2'){
        $ingredientObj->addstock_Kg($ing_id,$updateqty);
        
        }
        
        elseif($factor_Id ==='4'){
        $ingredientObj->addstock_L($ing_id,$updateqty);
        
        }
        elseif($factor_Id ==='5'){
        $ingredientObj->addstock_Ml($ing_id,$updateqty);
        
        }
        
        elseif($factor_Id ==='8'){
        $ingredientObj->addstock_oz($ing_id,$updateqty);
        
        }
        elseif($factor_Id ==='9'){
        $ingredientObj->addstock_lb($ing_id,$updateqty);
        
        }
        elseif($factor_Id ==='10'){
        $ingredientObj->addstock_nos($ing_id,$updateqty);
        
        }
        $msg="Ingredient qty succesfully added!";
        $msg= base64_encode($msg);    
        header("location:../view/module/admin/ingredients-management/stock.php?msg=$msg");
        
       } elseif($calculate  === 'subtract'){
        if($factor_Id ==='1'){
            $ingredientObj->subtractstock_G($ing_id,$updateqty);
            
            }
            elseif($factor_Id ==='2'){
            $ingredientObj->subtractstock_Kg($ing_id,$updateqty);
            
            }
            
            elseif($factor_Id ==='4'){
            $ingredientObj->subtractstock_L($ing_id,$updateqty);
            
            }
            elseif($factor_Id ==='5'){
            $ingredientObj->subtractstock_Ml($ing_id,$updateqty);
            
            }
           
            elseif($factor_Id ==='8'){
            $ingredientObj->subtractstock_oz($ing_id,$updateqty);
            
            }
            elseif($factor_Id ==='9'){
            $ingredientObj->subtractstock_lb($ing_id,$updateqty);
            
            }
            elseif($factor_Id ==='10'){
            $ingredientObj->subtractstock_nos($ing_id,$updateqty);
            
            }
        
        $msg="Ingredient qty succesfully subtracted!";
        $msg= base64_encode($msg);    
        header("location:../view/module/admin/ingredients-management/stock.php?msg=$msg");
       }
       else {
        echo "error in calculation selector";
       }

    } else {
        echo "failed to retrieve";
    }
}

?>
