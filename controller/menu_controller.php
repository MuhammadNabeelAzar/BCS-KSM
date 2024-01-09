<?php
session_start();
include '../model/menu_model.php';
$menuObj = new menu();

if (isset($_GET['status']) && $_GET['status'] === 'add-category') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $categoryName = $_POST['Category'];


        $menuObj->addcategory($categoryName);
        $msg = "category added Succesfully";
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/categories.php?msg=$msg");
    } else {
        echo "failed to add category";
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'add-fooditem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $itemName = $_POST['food_Name'];
        $itemDescription = $_POST['food_descript'];
        $categoryId = $_POST['categories'];

        try {
            if ($itemName == '') {
                throw new Exception("Item Name cannot be empty!");
            }
            $path = ''; // Initialize path as an empty string

            if ($_FILES["food_image"]["name"]) {
                // A new image file has been uploaded
                // Define the uploaded file based on the input field name (food_image)
                $imgname = time() . "_" . $_FILES["food_image"]["name"];
                $path = "../images/food_img/$imgname";

                if (move_uploaded_file($_FILES["food_image"]["tmp_name"], $path)) {
                    // Image upload was successful
                } else {
                    $error = error_get_last();
                    throw new Exception("Cannot upload due to image upload error: " . $error['message']);
                }

            }
            $menuObj->addfoodItem($itemName, $itemDescription, $path, $categoryId);
            $msg = "Item added successfully!";
            $msg = base64_encode($msg);
            header("location:../view/module/admin/menu-management/items.php?msg=$msg");



        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($addmsg);
            header("location:../view/module/admin/menu-management/items.php?addmsg=$msg");
        }
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'edit-fooditem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $foodId = $_POST['food_id'];
        $itemName = $_POST['food_Name'];
        $itemDescription = $_POST['food_descript'];
        $categoryId = $_POST['category'];

        try {
            if ($itemName == '') {
                throw new Exception("Item Name cannot be empty!");
            }
            $path = $_POST['img_path_name']; // Initialize path 

            if ($_FILES["food_image"]["name"]) {
                // A new image file has been uploaded
                // Define the uploaded file based on the input field name (food_image)
                $imgname = time() . "_" . $_FILES["food_image"]["name"];
                $path = "../images/food_img/$imgname";

                if (move_uploaded_file($_FILES["food_image"]["tmp_name"], $path)) {
                    // Image upload was successful
                } else {
                    $error = error_get_last();
                    throw new Exception("Cannot upload due to image upload error: " . $error['message']);
                }

            }
            $menuObj->editfoodItem($foodId, $itemName, $itemDescription, $path, $categoryId);
            $msg = "Item updated successfully!";
            $msg = base64_encode($msg);
            $foodid = $foodId;
            $foodid = base64_encode($foodid);
            header("location:../view/module/admin/menu-management/edit-foodItems.php?msg=$msg&foodId=$foodid");



        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            $foodid = $foodId;
            $foodid = base64_encode($foodid);
            header("location:../view/module/admin/menu-management/edit-foodItems.php?msg=$msg&foodId=$foodid");
        }
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'edit-otherItem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $itemId = $_POST['itemId'];
        $itemName = $_POST['item_Name'];
        $itemDescription = $_POST['item_descript'];
        $categoryId = $_POST['category'];

        try {
            if ($itemName == '') {
                throw new Exception("Item Name cannot be empty!");
            }
            $path = $_POST['img_path_name']; // Initialize path

            if ($_FILES["item_image"]["name"]) {
                // A new image file has been uploaded
                // Define the uploaded file based on the input field name (food_image)
                $imgname = time() . "_" . $_FILES["item_image"]["name"];
                $path = "../images/other_items_img/$imgname";

                if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $path)) {
                    // Image upload was successful
                } else {
                    $error = error_get_last();
                    throw new Exception("Cannot upload due to image upload error: " . $error['message']);
                }

            }
            $menuObj->editItem($itemId, $itemName, $itemDescription, $path, $categoryId);
            $msg = "Item updated successfully!";
            $msg = base64_encode($msg);
            $itemId = base64_encode($itemId);
            header("location:../view/module/admin/menu-management/edit-otherItems.php?msg=$msg&itemId=$itemId");



        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            $itemId = base64_encode($itemId);
            header("location:../view/module/admin/menu-management/edit-otherItems.php?msg=$msg&itemId=$itemId");
        }
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'delete-category') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $categoryid = $_POST['categoryId'];


        $menuObj->deletecategory($categoryid);
        $msg = "category deleted Succesfully";
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/categories.php?msg=$msg");
    } else {
        echo "failed to add category";
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'delete-fooditem') {
    $item_id = base64_decode($_GET['foodId']);
    $menuObj->removefooditem($item_id);
    $msg = "food Item deleted Successfully !";
    $msg = base64_encode($msg);
    header("location:../view/module/admin/menu-management/items.php?msg=$msg");
}

if (isset($_GET['status']) && $_GET['status'] === 'delete-item') {
    $itemId = ($_GET['itemId']);
    $menuObj->deleteitem($itemId);
    $msg = " Item deleted Successfully !";
    $msg = base64_encode($msg);
    header("location:../view/module/admin/menu-management/items.php?msg=$msg");
}

if (isset($_GET['status']) && $_GET['status'] === 'remove-foodItem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $foodid = $_POST['HiddenFoodID'];
        $foodname = $_POST['foodname'];


        $menuObj->deletefooditem($foodid);
        $msg = "$foodname Removed Succesfully";
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/categories.php?msg=$msg");
    } else {
        echo "failed to remove $foodname";
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'get-foodItem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $food_id = $_POST['data'];
        $food_id = base64_decode($food_id);


        $foodItemResult = $menuObj->getfooditemtosetprice($food_id);
        $foodrow = $foodItemResult->fetch_assoc();


        $response = array(
            'food_Id' => $foodrow['food_itemId'],
            'item_name' => $foodrow['item_name'],
            'price' => $foodrow['price'],
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        echo "failed to retrieve";
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'get-Item-details') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Item_id = $_POST['itemId'];


        $itemNameItemResult = $menuObj->getAnItemDetails($Item_id);
        $itemrow = $itemNameItemResult->fetch_assoc();


        $response = $itemrow;

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        echo "failed to retrieve";
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'set-price') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $food_id = $_POST['food_id'];
        $price = $_POST['price'];

        $menuObj->setprice($food_id, $price);
        $msg = "price updated";
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/pricing.php?msg=$msg");
    } else {
        echo "error in price";
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'set-Item-price') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemId = $_POST['food_id'];
        $price = $_POST['price'];

        $menuObj->setItemprice($itemId, $price);
        $msg = "price updated";
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/pricing.php?msg=$msg");
    } else {
        echo "error in price";
    }

}
if (
    isset($_GET['status']) && $_GET['status'] === 'add-recipie'
) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $food_id = $_GET['foodId'];
        $food_id = base64_decode($_GET['foodId']);
        $ing_id = $_POST['ing_id'];
        $quantity = $_POST['qtyrequired'];
        $factors = $_POST['factor'];

        $menuObj->setrecipe($food_id, $ing_id, $quantity, $factors);

        $msg = "recipie added";
        $food_id = base64_encode($food_id);
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/add-recipe.php?msg=$msg&foodId=$food_id");
    } else {
        echo "error in addin recipe";
    }

}




if (isset($_GET['status']) && $_GET['status'] === 'remove-ingredient') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $ing_id = $_GET['ing_id'];


        $menuObj->deleterecipeIng($ing_id);
        $response = "Ingredient removed Succesfully";
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'get-Items') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $category_id = $_POST['category'];


        $result = $menuObj->getItemswithcategory($category_id);
        $response = $result->fetch_all(MYSQLI_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'deactivate-food-availability') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $food_id = $_POST['food_id'];


        $menuObj->deactivatefoodAvailability($food_id);
        $response = "Food item deactivated Succesfully";
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'activate-food-availability') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $food_id = $_POST['food_id'];


        $menuObj->activatefoodAvailability($food_id);
        $response = "Food item deactivated Succesfully";
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'get-recipe') {
    $food_id = $_GET['foodId'];
    $result = $menuObj->getrecipe($food_id);

    if ($result && $result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $ingredient = array(
                'id' => $row['ing_id'],  
                'ingname' => $row['ing_name'],  
                'requiredqtyG' => $row['qty_required(g)'],  
                'requiredqtyMl' => $row['qty_required(ml)'],   
                
            );
            $data[] = $ingredient;
        }

        $response = array(
            'status' => 'success',
            'data' => $data,
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error in getting recipe'));
    }
} 

if (isset($_GET['status']) && $_GET['status'] === 'get-fooditems') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $category_id = $_POST['category'];

        $result = $menuObj->getfoodItemswithcategory($category_id);
        while($fooditems = $result->fetch_all(MYSQLI_ASSOC)){
            $response = $fooditems;
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'get-all-fooditems') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
       

        $result = $menuObj->getfoodItems();
        while($fooditems = $result->fetch_all(MYSQLI_ASSOC)){
            $response = $fooditems;
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'get-fooditem-details') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $foodItem_id = $_POST['food_id'];

        $result = $menuObj->getaspecificfoodItem($foodItem_id);
        $foodresult = $result->fetch_assoc();
        $response = $foodresult;
    
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'get-food-availability-qty') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $foodItem_id = $_POST['food_id'];

        $result = $menuObj->getfooditemavaiableqty($foodItem_id);
        $foodresult = $result->fetch_all(MYSQLI_ASSOC);
        $response = $foodresult;
    
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } }
    if (isset($_GET['status']) && $_GET['status'] === 'update-otherItems-stock') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //
            $Item_id = $_POST['itemId'];
    
            $result = $menuObj->getAnItemDetails($Item_id);
            $itemResult = $result->fetch_assoc();
            $response = $itemResult;
        
            
            header('Content-Type: application/json');
            echo json_encode($response);
        } 
    
    }
    if (isset($_GET['status']) && $_GET['status'] === 'update-item-stock') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //
            $item_Id = $_POST['item_id'];
            $quantity = $_POST['updatestockvalue'];
            $operator = $_POST['calculation-selector'];

            if($operator === 'add'){
                $menuObj->addstock($item_Id,$quantity);
                $msg = "Increased stock";
            } else {
                $menuObj->reduceStock($item_Id, $quantity);
                $msg = "Reduced stock";
            }
    
            
            $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/stock.php?msg=$msg");
        } 
    
    }
    if (isset($_GET['status']) && $_GET['status'] === 'reset-stock') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //
            $item_Id = $_POST['itemId'];
        
                $menuObj->resetStock($item_Id);
                $response = "Resetted stock";
          
    
            
                header('Content-Type: application/json');
                echo json_encode($response);
        } 
    
    }
if (isset($_GET['status']) && $_GET['status'] === 'add-Item') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-ingredient form
        $itemName = $_POST['food_Name'];
        $itemDescription = $_POST['food_descript']?? '';
        $categoryId = $_POST['categories']?? 1;
            $path = ''; // Initialize path as an empty string

            if ($_FILES["food_image"]["name"]) {
                // A new image file has been uploaded
                // Define the uploaded file based on the input field name (food_image)
                $imgname = time() . "_" . $_FILES["food_image"]["name"];
                $path = "../images/other_items_img/$imgname";

                if (move_uploaded_file($_FILES["food_image"]["tmp_name"], $path)) {
                    // Image upload was successful
                } else {
                    $error = error_get_last();
                    throw new Exception("Cannot upload due to image upload error: " . $error['message']);
                }

            }
            $menuObj->addItem($itemName, $itemDescription, $path, $categoryId);
            $msg = "Item added successfully!";
            $msg = base64_encode($msg);
            header("location:../view/module/admin/menu-management/items.php?msg=$msg");
        
    }
}
?>