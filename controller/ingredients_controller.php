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
            
            // Define the uploaded file based on the input field name (user_image)
            $imgname= time()."_". $_FILES["ing_image"]["name"];
            $path = "../images/ing_img/$imgname";
           

            if (move_uploaded_file($_FILES["ing_image"]["tmp_name"], $path)) {
                // Image upload was successful, now update the database with the image path
                $ingredientObj->addIngredient($ingName, $ingDescription, $path);
            
                $addmsg = "Ingredient added successfully!";
                $addmsg = base64_encode($addmsg);
                header("location:../view/module/admin/ingredients-management/ingredients.php?addmsg=$addmsg");
            } else {
                $error = error_get_last();
                $addmsg = "Error moving the uploaded image." . $error['message'];
                $addmsg = base64_encode($msg);
                header("location:../view/module/admin/ingredients-management/ingredients.php?addmsg=$addmsg");
            }     
        } catch (Exception $ex) {
            $addmsg = $ex->getMessage();  
            $addmsg = base64_encode($addmsg);
            header("location:../view/module/admin/ingredients-management/ingredients.php?addmsg=$addmsg"); 
        }
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'edit-ingredient') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $ingName = $_POST['ing_Name'];
        $ingDescription = $_POST['ing_descript']; 
        $ingg_id = $_POST['ing_id'];

        try {
            if ($ingName == '') {
                throw new Exception("Ingredient Name cannot be empty!");
            }
            
            // Define the uploaded file based on the input field name (user_image)
            $imgname= time()."_". $_FILES["ing_image"]["name"];
            $path = "../images/ing_img/$imgname";
           

            if (move_uploaded_file($_FILES["ing_image"]["tmp_name"], $path)) {
                // Image upload was successful, now update the database with the image path
                $ingredientObj->updateingredients($ingName, $ingDescription, $path ,$ingg_id);
            
                $msg = "Ingredient updated successfully!";
                $msg = base64_encode($msg);
                header("location:../view/module/admin/ingredients-management/edit-ingredients.php?msg=$msg&ingid=$ingg_id");
            } else {
                $error = error_get_last();
                $msg = "Error moving the uploaded image." . $error['message'];
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
