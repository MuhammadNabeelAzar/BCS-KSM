<?php
session_start();
include '../model/menu_model.php';
$menuObj = new menu();

if (isset($_GET['status']) && $_GET['status'] === 'add-category') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // This adds a new category
        $categoryName = $_POST['Category'];

        $menuObj->addcategory($categoryName);
        $msg = "Category added succesfully";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/categories.php?msg=$msg");
    } else {
        echo "Failed to add category!";
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'add-fooditem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the ingredient details from the add-food item form
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
            header("location:../view/module/modules/menu-management/items.php?msg=$msg");

        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($addmsg);
            header("location:../view/module/modules/menu-management/items.php?addmsg=$msg");
        }
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'edit-fooditem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // This function is to edit the details of the food items
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
            header("location:../view/module/modules/menu-management/edit-foodItems.php?msg=$msg&foodId=$foodid");

        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            $foodid = $foodId;
            $foodid = base64_encode($foodid);
            header("location:../view/module/modules/menu-management/edit-foodItems.php?msg=$msg&foodId=$foodid");
        }
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'edit-otherItem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the other item details to edit
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
            header("location:../view/module/modules/menu-management/edit-otherItems.php?msg=$msg&itemId=$itemId");

        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            $itemId = base64_encode($itemId);
            header("location:../view/module/modules/menu-management/edit-otherItems.php?msg=$msg&itemId=$itemId");
        }
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'delete-category') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the category id to remove the category id
        $categoryid = $_POST['categoryId'];
        $menuObj->deletecategory($categoryid);
        $msg = "category deleted Succesfully";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/categories.php?msg=$msg");
    } else {
        echo "failed to add category";
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'delete-fooditem') {
    //deletes a food item
    $item_id = $_GET['foodId'];
 
    try {
        $Result = $menuObj->removefooditem($item_id);

        if ($Result) {
            // Deletion successful
            $msg = "Food item deleted successfully!";
            $msg = base64_encode($msg);

            // Redirect to items.php with success message
            header("location:../view/module/modules/menu-management/items.php?msg=$msg");
            exit();  // Always exit after sending header to ensure no further output is sent
        } 
    } catch (Exception $e) {
        // Exception occurred, likely due to foreign key constraint in the order table, therefore display the message
        $msg = "Unable to delete the food item because this item has been sold and deleting it will cause data inconsistencies, therefore please try deactivating this item.";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/items.php?msg=$msg");
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'delete-item') {
     //deletes an other item
    $itemId = ($_GET['itemId']);
    
    try {
        $Result = $menuObj->deleteitem($itemId);

        if ($Result) {
            // Deletion successful
            $msg = " Item deleted Successfully !";
            $msg = base64_encode($msg);

            // Redirect to items.php with success message
            header("location:../view/module/modules/menu-management/items.php?msg=$msg");
            exit();  // Always exit after sending header to ensure no further output is sent
        } 
    } catch (Exception $e) {
        // Exception occurred, likely due to foreign key constraint in the order table, therefore display the message
        $msg = "Unable to delete the food item because this item has been sold and deleting it will cause data inconsistencies, therefore please try deactivating this item.";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/items.php?msg=$msg");
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'remove-foodItem') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // removes a food item
        $foodid = $_POST['foodId'];
        $foodname = $_POST['foodname'];
        $menuObj->deletefooditem($foodid);
        $msg = "$foodname Removed Succesfully";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/categories.php?msg=$msg");
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
        //gets item details  for editing purpose
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
//this sets the price for food items
        $food_id = $_POST['food_id'];
        $price = $_POST['price'];
        $menuObj->setprice($food_id, $price);
        $msg = "price updated successfully";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/pricing.php?msg=$msg");
    } else {
        echo "error in setting the price";
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'set-Item-price') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this sets the price for other items
        $itemId = $_POST['food_id'];
        $price = $_POST['price'];
        $menuObj->setItemprice($itemId, $price);
        $msg = "price updated";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/pricing.php?msg=$msg");
    } else {
        echo "error in price";
    }
}

if ( isset($_GET['status']) && $_GET['status'] === 'add-recipie') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this adds the food items recipe
        $food_id = $_GET['foodId'];
        if (isset($_GET['foodId']) && isset($_POST['ing_id'])) {
        $food_id = base64_decode($_GET['foodId']);
        $ing_id = $_POST['ing_id'];
        $quantity = $_POST['qtyrequired'];
        $factors = $_POST['factor'];

        $result = $menuObj->setrecipe($food_id, $ing_id, $quantity, $factors);

            $msg = "Recipe updated successfully";
        $food_id = base64_encode($food_id);
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/add-recipe.php?msg=$msg&foodId=$food_id");
        } else {
            $msg = "Please select the ingredients!";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/menu-management/add-recipe.php?msg=$msg&foodId=$food_id");
        }
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
        $response="Recipe not set";
        echo json_encode($response);
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'get-fooditems') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //gets all the fooditems related to a category
        $category_id = $_POST['category'];
        $result = $menuObj->getfoodItemswithcategory($category_id);
        while ($fooditems = $result->fetch_all(MYSQLI_ASSOC)) {
            $response = $fooditems;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}

if (isset($_GET['status']) && $_GET['status'] === 'get-all-fooditems') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //gets all food items
        $result = $menuObj->getfoodItems();
        while ($fooditems = $result->fetch_all(MYSQLI_ASSOC)) {
            $response = $fooditems;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}

if (isset($_GET['status']) && $_GET['status'] === 'get-all-items') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //gets all other items
        $result = $menuObj->getOtherItems();
        while ($items = $result->fetch_all(MYSQLI_ASSOC)) {
            $response = $items;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

}

if (isset($_GET['status']) && $_GET['status'] === 'get-fooditem-details') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this gets a specific food item's details
        $foodItem_id = $_POST['food_id'];

        $result = $menuObj->getaspecificfoodItem($foodItem_id);
        $foodresult = $result->fetch_assoc();
        $response = $foodresult;

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'get-Recipe-To-Calculate-Available-Qty') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this gets a food items recipe to calculate the maximum amount of food items that could prepared
        $foodItem_id = $_POST['food_id'];

        $result = $menuObj->getRecipeToCalculateAvailableQty($foodItem_id);
        $foodresult = $result->fetch_all(MYSQLI_ASSOC);
        $response = $foodresult;

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'update-otherItems-stock') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this updates the stock of other items
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
        //this adds  or subtracts from a food item's stock depending on the calculation selector. 
        $item_Id = $_POST['item_id'];
        $quantity = $_POST['updatestockvalue'];
        $operator = $_POST['calculation-selector'];

        if ($operator === 'add') {
            $menuObj->addstock($item_Id, $quantity);
            $msg = "Stock added successfully.";
        } else {
            $menuObj->reduceStock($item_Id, $quantity);
            $msg = "Stock reduced successfully.";
        }
        $msg = base64_encode($msg);
        header("Location: http://localhost/BcsKSM/view/module/modules/menu-management/stock.php?msg=$msg");
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'reset-stock') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this resets the stock value
        $item_Id = $_POST['itemId'];

        $menuObj->resetStock($item_Id);
        $response = "Resetted stock";

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}

if (isset($_GET['status']) && $_GET['status'] === 'add-Item') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting  item details from  form
        $itemName = $_POST['food_Name'];
        $itemDescription = $_POST['food_descript'] ?? '';
        $categoryId = $_POST['categories'] ?? 1;
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
        header("Location: http://localhost/BcsKSM/view/module/modules/menu-management/items.php?msg=$msg");

    }
}
?>