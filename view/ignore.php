<?php
                                    while ($reciperow = $recipeResult->fetch_assoc()) {
                                        $ing_id = $reciperow['ing_id'];
                                        ?>

                                        <div class=" form-check form-check-inline ml-1" id="checkitem">

                                            <input type="hidden" value="<?php echo $ing_id ?>" id="ing_id" name="ing_id[]">
                                            <input class="form-check-input" type="checkbox" value="<?php echo $ing_id ?>"
                                                id="flexCheckDefault">
                                            <p>
                                                <?php echo $reciperow['ing_name']; ?>
                                            </p>

                                            <div class="col">
                                                <input type="number" placeholder="required quantity" name="required_quantity[]"
                                                    id="required_quantity" required>
                                                <select name="factor[]">
                                                    <option value="1">g</option>
                                                    <option value="2">kg</option>
                                                    <option value="3">c</option>
                                                    <option value="4">tbsp</option>
                                                    <option value="5">tsp</option>
                                                    <option value="6">oz</option>
                                                    <option value="7">lb</option>
                                                    <option value="8">ml</option>
                                                    <option value="9">l</option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>
                                <?php } ?>