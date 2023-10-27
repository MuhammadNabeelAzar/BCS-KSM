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
            
                $msg = "Ingredient added successfully!";
                $msg = base64_encode($msg);
                header("location:../view/module/admin/ingredients-management/ingredients.php?msg=$msg");
            } else {
                $error = error_get_last();
                $msg = "Error moving the uploaded image." . $error['message'];
                $msg = base64_encode($msg);
                header("location:../view/module/admin/ingredients-management/ingredients.php?msg=$msg");
            }     
        } catch (Exception $ex) {
            $msg = $ex->getMessage();  
            $msg = base64_encode($msg);
            header("location:../view/module/admin/ingredients-management/ingredients.php?msg=$msg"); 
        }
    }
}
?>
