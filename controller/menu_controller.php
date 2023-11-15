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
if (
    isset($_GET['status']) && $_GET['status'] === 'add-recipie'
) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $food_id = $_GET['foodId'];
        $food_id = base64_decode($_GET['foodId']);
        $ing_id = $_POST['ing_id'];
        $quantity = $_POST['required_quantity'];
        $factor = $_POST['factor'];


        $menuObj->setrecipe($food_id, $ing_id, $quantity, $factor);

        $msg = "recipie added";
        $food_id = base64_encode($food_id);
        $msg = base64_encode($msg);
        header("location:../view/module/admin/menu-management/add-recipie.php?msg=$msg&foodId=$food_id");
    } else {
        echo "error in addin recipe";
    }

}

if (isset($_GET['status']) && $_GET['status'] === 'get-recipe') {
    $food_id = $_GET['foodId'];
    $result = $menuObj->getrecipe($food_id);

    if ($result && $result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'id' => $row['ing_id'],  
                'ingname' => $row['ing_name'],  
                'requiredqtyG' => $row['qty_required(g)'],  
                'requiredqtyMl' => $row['qty_required(ml)'],   
                
            );
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
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

 



?>