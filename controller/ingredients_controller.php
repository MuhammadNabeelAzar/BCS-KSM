<?php
session_start();
include '../model/ingredients_model.php';
$ingredientObj = new ingredient();
   
if (isset($_GET['status']) && $_GET['status'] === 'add-ingredient') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $ingName = $_POST['ing_Name'];
        $ingDescription = $_POST['ing_descript']; 

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
            $ingredientObj->addIngredient($ingName, $ingDescription,$path);
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
            $ingredientObj->updateingredients($ingName, $ingDescription, $ingg_id);

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
            header("location:../view/module/admin/ingredients-management/edit-ingredients.php?msg=$msg&ingid=$ingg_id"); 
        }
    }
}
?>
