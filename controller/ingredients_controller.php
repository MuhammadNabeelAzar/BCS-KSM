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
            $ingredientObj->addIngredient($ingName, $ingDescription, $path, $factorId);
            $addmsg = "Ingredient added successfully!";
            $addmsg = base64_encode($addmsg);
            header("location:../view/module/modules/ingredients-management/ingredients.php?addmsg=$addmsg");



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
            $ingredientObj->updateingredients($ingName, $ingDescription, $ingg_id, $factor_id);

            $msg = "Ingredient updated successfully!";
            $msg = base64_encode($msg);
            $ingg_id = base64_encode($ingg_id);
            header("location:../view/module/modules/ingredients-management/edit-ingredients.php?msg=$msg&ingid=$ingg_id");

            if ($path) {
                // A new image has been uploaded, update the image path in the database
                $ingg_id = base64_decode($ingg_id);
                $ingredientObj->updateingredientImage($path, $ingg_id);
                $ingg_id = base64_encode($ingg_id);
                $msg = "Ingredient image updated successfully!";
                $msg = base64_encode($msg);
                header("location:../view/module/modules/ingredients-management/edit-ingredients.php?msg=$msg&ingid=$ingg_id");

            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            header("location:../view/module/modules/ingredients-management/edit-ingredients.php?msg=$msg");
        }
    }
}

if (isset($_GET['status']) && $_GET['status'] === 'remove-ingredient') {
    //get the ing id and then remove the ingredient 
    $ing_id = base64_decode($_GET['ingid']);
    $ingredientObj->removeIngredient($ing_id);
    $msg = "Ingredient Removed Successfully !";
    $msg = base64_encode($msg);
    header("location:../view/module/modules/ingredients-management/ingredients.php?msg=$msg");
}

if (isset($_GET['status']) && $_GET['status'] === 'get-ingredient-details') {
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

if (isset($_GET['status']) && $_GET['status'] === 'reset-ingredient-qty') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //this resets the ingredients stock levels
        $ing_id = $_POST['ing_id'];
        $ingredientObj->resetingredientstock($ing_id);
        $msg = "Ingredient qty succesfully resetted!";
        $msg = base64_encode($msg);
        header("location:../view/module/modules/ingredients-management/stock.php?msg=$msg");
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'request-stock') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //this is a request that is sent to the stock manager for a refill of stocks
        $ing_id = $_POST['ing_id'];
        $quantity = $_POST['quantity'];
        $reason = $_POST['reason'];
        $factor_id = $_POST['factor_id'];

        $result = $ingredientObj->sendIngredientRefillRequest($ing_id,$quantity,$reason,$factor_id);

        if($result){
            $response  = "Request successful";
        }else {
            $response  = "Request unsuccessful.Please try again later !";
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        
       
    }

}

if (isset($_GET['status']) && $_GET['status'] === 'accept-refill-requests') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this  accepts the stock refill request
        $req_id = $_POST['req_id'];
        $result = $ingredientObj->acceptRefillRequest($req_id);
        
        if($result){
            $response  = "Completed successfully";
        } else {
            $response  = "Unable to complete request.";
        } 

        header('Content-Type: application/json');
        echo json_encode($response);
    }  
}
if (isset($_GET['status']) && $_GET['status'] === 'cancel-refill-requests') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this  cancels the stock refill request
        $req_id = $_POST['req_id'];
        $result = $ingredientObj->cancelRefillRequest($req_id);
        
        if($result){
            $response  = "Request cancelled successfully";
        } else {
            $response  = "Unable to cancel request.";
        } 

        header('Content-Type: application/json');
        echo json_encode($response);
    }  
}
if (isset($_GET['status']) && $_GET['status'] === 'close-refill-requests') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this  closes and marks the request finished
        $req_id = $_POST['req_id'];
        $result = $ingredientObj->closeRefillRequest($req_id);
        
        if($result){
            $response  = "Request closed  successfully.";
        } else {
            $response  = "Unable to close request.";
        } 

        header('Content-Type: application/json');
        echo json_encode($response);
    }  
}

if (isset($_GET['status']) && $_GET['status'] === 'mark-as-ready-refill-requests') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this marks the stock refill request as completed
        $req_id = $_POST['req_id'];
        $result = $ingredientObj->completeRefillRequest($req_id);
        
        if($result){
            $response  = "Completed successfully";
        } else {
            $response  = "Unable to complete request.";
        } 

        header('Content-Type: application/json');
        echo json_encode($response);
    }  
}

if (isset($_GET['status']) && $_GET['status'] === 'get-stock-refill-requests') {
        
        //this gets all the pending refill requests
        $result = $ingredientObj->getAllStockRefillRequests();
        $Reqresult = $result->fetch_all(MYSQLI_ASSOC);
        
        if($Reqresult){
            $response  =  $Reqresult;
        }else {
            $response  = false;
        } 

        header('Content-Type: application/json');
        echo json_encode($response);
        
       

}
if (isset($_GET['status']) && $_GET['status'] === 'get-stock-refill-pending-requests') {
        
        //this gets all the pending refill requests
        $result = $ingredientObj->getPendingStockRefillRequests();
        $Reqresult = $result->fetch_all(MYSQLI_ASSOC);
        
        if($Reqresult){
            $response  =  $Reqresult;
        }else {
            $response  = false;
        } 

        header('Content-Type: application/json');
        echo json_encode($response);
        
       

}

if (isset($_GET['status']) && $_GET['status'] === 'update-stock') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //this function updates the stock depending on the selected factor as the measurement factor and it updates different columns where the factor matches
        $ing_id = $_POST['ingredient_id'];
        $updateqty = $_POST['updatestockvalue'];
        $calculate = $_POST['calculation-selector'];
        $factor_Id = $_POST['factor_id'];

        if ($calculate === 'add') {
            if ($factor_Id === '1') {
                $ingredientObj->addstock_G($ing_id, $updateqty);

            } elseif ($factor_Id === '2') {
                $ingredientObj->addstock_Kg($ing_id, $updateqty);

            } elseif ($factor_Id === '4') {
                $ingredientObj->addstock_L($ing_id, $updateqty);

            } elseif ($factor_Id === '5') {
                $ingredientObj->addstock_Ml($ing_id, $updateqty);

            } elseif ($factor_Id === '8') {
                $ingredientObj->addstock_oz($ing_id, $updateqty);

            } elseif ($factor_Id === '9') {
                $ingredientObj->addstock_lb($ing_id, $updateqty);

            } elseif ($factor_Id === '10') {
                $ingredientObj->addstock_nos($ing_id, $updateqty);

            }
            $msg = "Ingredient qty succesfully added!";
            $msg = base64_encode($msg);
            header("location:../view/module/modules/ingredients-management/stock.php?msg=$msg");

        } elseif ($calculate === 'subtract') {
            if ($factor_Id === '1') {
                $ingredientObj->subtractstock_G($ing_id, $updateqty);

            } elseif ($factor_Id === '2') {
                $ingredientObj->subtractstock_Kg($ing_id, $updateqty);

            } elseif ($factor_Id === '4') {
                $ingredientObj->subtractstock_L($ing_id, $updateqty);

            } elseif ($factor_Id === '5') {
                $ingredientObj->subtractstock_Ml($ing_id, $updateqty);

            } elseif ($factor_Id === '8') {
                $ingredientObj->subtractstock_oz($ing_id, $updateqty);

            } elseif ($factor_Id === '9') {
                $ingredientObj->subtractstock_lb($ing_id, $updateqty);

            } elseif ($factor_Id === '10') {
                $ingredientObj->subtractstock_nos($ing_id, $updateqty);

            }

            $msg = "Ingredient qty succesfully subtracted!";
            $msg = base64_encode($msg);
            header("location:../view/module/modules/ingredients-management/stock.php?msg=$msg");
        } else {
            echo "error in calculation selector";
        }

    } else {
        echo "failed to retrieve";
    }
}

?>