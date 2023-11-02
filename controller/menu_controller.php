<?php
session_start();
include '../model/menu_model.php';
$menuObj = new menu();

if (isset($_GET['status']) && $_GET['status'] === 'add-category') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $categoryName = $_POST['Category'];
        

            $menuObj->addcategory($categoryName);
         $msg="category added Succesfully";
        $msg= base64_encode($msg);    
        header("location:../view/module/admin/menu-management/categories.php?msg=$msg");     
    } 
    
        else {
            echo "failed to add category";
        }
                    
}
if (isset($_GET['status']) && $_GET['status'] === 'delete-category') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $categoryid = $_POST['categoryId'];
        

            $menuObj->deletecategory($categoryid);
         $msg="category deleted Succesfully";
        $msg= base64_encode($msg);    
        header("location:../view/module/admin/menu-management/categories.php?msg=$msg");     
    } 
    
        else {
            echo "failed to add category";
        }
                    
}

  
?>
