BEGIN
    SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(kg)` / 1000;
    SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;

    SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` * 1000;
    SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;

    SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` * 236.588;
    SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` * 1000;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;

    SET NEW.`remaining_qty(l)` = NEW.`remaining_qty(ml)` / 1000;
    SET NEW.`remaining_qty(ml)` = NEW.`remaining_qty(l)` * 1000;

    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(kg)` / 67.6280454;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(c)` * 16;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(tsp)` * 3.0;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(oz)` * 2.0;
    SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(lb)` * 30.675565391454;

    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(kg)` / 202.8841362;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(c)` * 48;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(tbsp)` * 0.333333;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(oz)` * 6.0;
    SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(lb)` * 92.026696174362;

    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(kg)` / 35.274;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(c)` * 8;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(tbsp)` * 0.5;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(tsp)` * 0.166667;
    SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(lb)` * 16;

    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(kg)` * 2.205;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(c)` * 1.92 ;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(tbsp)` * 0.032599236142 ;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(tsp)` * 0.010866412047;
    SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(oz)` * 16;
END



if (isset($_GET['status']) && $_GET['status'] === 'update-ingredient-qty') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ingg_id = $_POST['data'];
        $ingg_id = base64_decode($ingg_id);

        // Retrieve the data you want to send
        $ingredientqtyResult = $ingredientObj->getIngredienttoUpdate($ingg_id);
        $ingqtyrow = $ingredientqtyResult->fetch_assoc();

        // Create a response with the remaining quantity
        $response = array(
            'ing_id' => $ingqtyrow['ing_Id'],
            'ing_name' => $ingqtyrow['ing_name'],
            'remaining_qty' => $ingqtyrow['remaining_qty'],
            'factor_id' => $ingqtyrow['factor_id'],
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        echo "failed to retrieve";
    }
}


BEGIN
    IF NEW.`remaining_qty(g)` != OLD.`remaining_qty(g)` THEN
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` * 0.001;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;

    IF NEW.`remaining_qty(kg)` != OLD.`remaining_qty(kg)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(kg)` * 1000;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;

    IF NEW.`remaining_qty(c)` != OLD.`remaining_qty(c)` THEN
        -- Add conversion logic for 'remaining_qty(c)'
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(c)` / 236.588;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(c)` / 0.125155177101;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(c)` / 16;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(c)` / 48;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(c)` / 8;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(c)` / 1.92;
    END IF;

    IF NEW.`remaining_qty(tbsp)` != OLD.`remaining_qty(tbsp)` THEN
        -- Add conversion logic for 'remaining_qty(tbsp)'
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(tbsp)` / 15;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(tbsp)` / 67.6280454;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(tbsp)` / 16;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(tbsp)` / 0.333333;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(tbsp)` / 2;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(tbsp)` / 30.675565391454;
    END IF;

    IF NEW.`remaining_qty(tsp)` != OLD.`remaining_qty(tsp)` THEN
        -- Add conversion logic for 'remaining_qty(tsp)'
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(tsp)` / 4.2;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(tsp)` / 202.8841362;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(tsp)` / 48;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(tsp)` / 3;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(tsp)` / 6;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(tsp)` / 92.026696174362;
    END IF;

    IF NEW.`remaining_qty(oz)` != OLD.`remaining_qty(oz)` THEN
        -- Add conversion logic for 'remaining_qty(oz)'
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(oz)` / 28.35;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(oz)` / 35.274;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(oz)` / 8;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(oz)` / 0.5;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(oz)` / 0.166667;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(oz)` / 16;
    END IF;

    IF NEW.`remaining_qty(lb)` != OLD.`remaining_qty(lb)` THEN
        -- Add conversion logic for 'remaining_qty(lb)'
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(lb)` / 453.6;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(lb)` / 2.205;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(lb)` / 1.92;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(lb)` / 0.032599236142;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(lb)` / 0.010866412047;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(lb)` / 16;
    END IF;
    IF NEW.`remaining_qty(ml)` != OLD.`remaining_qty(ml)` THEN
        SET NEW.`remaining_qty(l)` = NEW.`remaining_qty(ml)` / 0.001;
    END IF;

    IF NEW.`remaining_qty(l)` != OLD.`remaining_qty(l)` THEN
        SET NEW.`remaining_qty(ml)` = NEW.`remaining_qty(l)` / 1000;
    END IF;
END 



.///////////////////////////////////////////

-- Check if 'remaining_qty(oz)' column has changed
    IF NEW.`remaining_qty(oz)` != OLD.`remaining_qty(oz)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(oz)` * 28.3495;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
         SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
         SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
END IF;
-- Check if 'remaining_qty(lb)' column has changed
    IF NEW.`remaining_qty(lb)` != OLD.`remaining_qty(lb)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(lb)` * 453.6;
         SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
         SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
         SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
         SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        
END IF;
    

    
-- Check if 'remaining_qty(c)' column has changed
    IF NEW.`remaining_qty(c)` != OLD.`remaining_qty(c)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(c)` * 236.588;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
         SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;

    -- Check if 'remaining_qty(tbsp)' column has changed
    IF NEW.`remaining_qty(tbsp)` != OLD.`remaining_qty(tbsp)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(tbsp)` * 17.07;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
         SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
END IF;
    -- Check if 'remaining_qty(tsp)' column has changed
    IF NEW.`remaining_qty(tsp)` != OLD.`remaining_qty(tsp)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(tsp)` * 5.69;
         SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
         SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
         SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
END IF;

    ////////////////////////////////////--
    BEGIN
    -- Check if 'remaining_qty(g)' column has changed
    IF NEW.`remaining_qty(g)` != OLD.`remaining_qty(g)` THEN
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;
    -- Check if 'remaining_qty(kg)' column has changed
    IF NEW.`remaining_qty(kg)` != OLD.`remaining_qty(kg)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(kg)` * 1000;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;
-- Check if 'remaining_qty(oz)' column has changed
    IF NEW.`remaining_qty(oz)` != OLD.`remaining_qty(oz)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(oz)` * 28.3495;
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
         SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
         SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
END IF;
-- Check if 'remaining_qty(lb)' column has changed
    IF NEW.`remaining_qty(lb)` != OLD.`remaining_qty(lb)` THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(lb)` * 453.6;
         SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
         SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
         SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
         SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
        
END IF;    
   
    


-- Check if 'remaining_qty(ml)' column has changed
    IF NEW.`remaining_qty(ml)` != OLD.`remaining_qty(ml)` THEN
        SET NEW.`remaining_qty(l)` = NEW.`remaining_qty(ml)` / 1000;
    END IF;

    -- Check if 'remaining_qty(l)' column has changed
    IF NEW.`remaining_qty(l)` != OLD.`remaining_qty(l)` THEN
        SET NEW.`remaining_qty(ml)` = NEW.`remaining_qty(l)` * 1000;
    END IF;
        

END



////////////////////////////////
BEGIN
    -- Define flags for each conversion
    DECLARE convert_g_to_kg INT DEFAULT 0;
    DECLARE convert_g_to_c INT DEFAULT 0;
    DECLARE convert_g_to_tbsp INT DEFAULT 0;
    DECLARE convert_g_to_tsp INT DEFAULT 0;
    DECLARE convert_g_to_oz INT DEFAULT 0;
    DECLARE convert_g_to_lb INT DEFAULT 0;
    DECLARE convert_kg_to_g INT DEFAULT 0;
    DECLARE convert_kg_to_c INT DEFAULT 0;
    DECLARE convert_kg_to_tbsp INT DEFAULT 0;
    DECLARE convert_kg_to_tsp INT DEFAULT 0;
    DECLARE convert_kg_to_oz INT DEFAULT 0;
    DECLARE convert_kg_to_lb INT DEFAULT 0;
    DECLARE convert_oz_to_g INT DEFAULT 0;
    DECLARE convert_oz_to_kg INT DEFAULT 0;
    DECLARE convert_oz_to_c INT DEFAULT 0;
    DECLARE convert_oz_to_tbsp INT DEFAULT 0;
    DECLARE convert_oz_to_tsp INT DEFAULT 0;
    DECLARE convert_lb_to_g INT DEFAULT 0;
    DECLARE convert_lb_to_kg INT DEFAULT 0;
    DECLARE convert_lb_to_c INT DEFAULT 0;
    DECLARE convert_lb_to_tbsp INT DEFAULT 0;
    DECLARE convert_lb_to_tsp INT DEFAULT 0;
    DECLARE convert_lb_to_oz INT DEFAULT 0;

    -- Convert depending on the columns that have changed and set the corresponding flags
    IF NEW.`remaining_qty(g)` != OLD.`remaining_qty(g)` THEN
        SET convert_g_to_kg = 1;
        SET convert_g_to_c = 1;
        SET convert_g_to_tbsp = 1;
        SET convert_g_to_tsp = 1;
        SET convert_g_to_oz = 1;
        SET convert_g_to_lb = 1;
    END IF;

    IF NEW.`remaining_qty(kg)` != OLD.`remaining_qty(kg)` THEN
        SET convert_kg_to_g = 1;
        SET convert_kg_to_c = 1;
        SET convert_kg_to_tbsp = 1;
        SET convert_kg_to_tsp = 1;
        SET convert_kg_to_oz = 1;
        SET convert_kg_to_lb = 1;
    END IF;

    IF NEW.`remaining_qty(oz)` != OLD.`remaining_qty(oz)` THEN
        SET convert_oz_to_g = 1;
        SET convert_oz_to_kg = 1;
        SET convert_oz_to_c = 1;
        SET convert_oz_to_tbsp = 1;
        SET convert_oz_to_tsp = 1;
    END IF;

    IF NEW.`remaining_qty(lb)` != OLD.`remaining_qty(lb)` THEN
        SET convert_lb_to_g = 1;
        SET convert_lb_to_kg = 1;
        SET convert_lb_to_c = 1;
        SET convert_lb_to_tbsp = 1;
        SET convert_lb_to_tsp = 1;
        SET convert_lb_to_oz = 1;
    END IF;

    -- CONVERSITING DEPENDING ON THE FLAGS SET
    IF convert_g_to_kg = 1 THEN
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
    END IF;

    IF convert_g_to_c = 1 THEN
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
    END IF;

    IF convert_g_to_tbsp = 1 THEN
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    END IF;

    IF convert_g_to_tsp = 1 THEN
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    END IF;

    IF convert_g_to_oz = 1 THEN
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    END IF;

    IF convert_g_to_lb = 1 THEN
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;

    IF convert_kg_to_g = 1 THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(kg)` * 1000;
    END IF;

    IF convert_kg_to_c = 1 THEN
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
    END IF;

    IF convert_kg_to_tbsp = 1 THEN
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    END IF;

    IF convert_kg_to_tsp = 1 THEN
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    END IF;

    IF convert_kg_to_oz = 1 THEN
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    END IF;

    IF convert_kg_to_lb = 1 THEN
        SET NEW.`remaining_qty(lb)` = NEW.`remaining_qty(g)` / 453.6;
    END IF;

    IF convert_oz_to_g = 1 THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(oz)` * 28.3495;
    END IF;

    IF convert_oz_to_kg = 1 THEN
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
    END IF;

    IF convert_oz_to_c = 1 THEN
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
    END IF;

    IF convert_oz_to_tbsp = 1 THEN
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    END IF;

    IF convert_oz_to_tsp = 1 THEN
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    END IF;

    IF convert_lb_to_g = 1 THEN
        SET NEW.`remaining_qty(g)` = NEW.`remaining_qty(lb)` * 453.6;
    END IF;

    IF convert_lb_to_kg = 1 THEN
        SET NEW.`remaining_qty(kg)` = NEW.`remaining_qty(g)` / 1000;
    END IF;

    IF convert_lb_to_c = 1 THEN
        SET NEW.`remaining_qty(c)` = NEW.`remaining_qty(g)` / 236.588;
    END IF;

    IF convert_lb_to_tbsp = 1 THEN
        SET NEW.`remaining_qty(tbsp)` = NEW.`remaining_qty(g)` / 15;
    END IF;

    IF convert_lb_to_tsp = 1 THEN
        SET NEW.`remaining_qty(tsp)` = NEW.`remaining_qty(g)` / 4.2;
    END IF;

    IF convert_lb_to_oz = 1 THEN
        SET NEW.`remaining_qty(oz)` = NEW.`remaining_qty(g)` / 28.35;
    END IF;
END