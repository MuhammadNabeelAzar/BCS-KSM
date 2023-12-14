var requiredqty = document.createElement('input');
        requiredqty.setAttribute('type', 'number');
        requiredqty.setAttribute('placeholder', 'required quantity');
        requiredqty.setAttribute('name', 'required_quantity[]');
        requiredqty.setAttribute('id', 'required_quantity');
        requiredqty.required = true;


        var factor = document.createElement('select');
        factor.setAttribute('name', 'factor[]');

        var g = document.createElement('option');
                g.value = '1';
                g.text = 'g';
                factor.appendChild(g);
                var kg = document.createElement('option');
                kg.value = '2';
                kg.text = 'kg';
                factor.appendChild(kg);
                var c = document.createElement('option');
                c.value = '3';
                c.text = 'c';
                factor.appendChild(c);
                var tbsp = document.createElement('option');
                tbsp.value = '4';
                tbsp.text = 'tbsp';
                factor.appendChild(tbsp);
                var tsp = document.createElement('option');
                tsp.value = '5';
                tsp.text = 'tsp';
                factor.appendChild(tsp);
                var oz = document.createElement('option');
                oz.value = '6';
                oz.text = 'oz';
                factor.appendChild(oz);
                var lb = document.createElement('option');
                lb.value = '7';
                lb.text = 'lb';
                factor.appendChild(lb);
                var ml = document.createElement('option');
                ml.value = '8';
                ml.text = 'ml';
                factor.appendChild(ml);
                var l = document.createElement('option');
                l.value = '9';
                l.text = 'l';
                factor.appendChild(l);
    



                BEGIN
    
    IF NEW.factor = '8' THEN
        SET NEW.`qty_required(ml)` = NEW.`qty_required(g)`;
    END IF;
    IF NEW.factor = '9' THEN
        SET NEW.`qty_required(ml)` = NEW.`qty_required(g)` / 1000;
    END IF;
END

BEGIN
IF NEW.factor = '1' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)`;
        END IF;

    IF NEW.factor = '2' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 1000;
        END IF;
        IF NEW.factor = '3' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 250;
    END IF;
    IF NEW.factor = '4' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 14.175;
    END IF;
    IF NEW.factor = '5' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 5.69;
    END IF;
    IF NEW.factor = '6' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 28.3495;
    END IF;
    IF NEW.factor = '7' THEN
        SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 453.592;
    END IF;
    IF NEW.factor = '8' THEN
        SET NEW.`qty_required(ml)` = NEW.`qty_required(g)`;
    END IF;
    IF NEW.factor = '9' THEN
        SET NEW.`qty_required(ml)` = NEW.`qty_required(g)` * 1000 ;
    END IF;
   
END


function increaseDecreasefooditemqty(button) {
    var card = button.parentElement.parentElement.parentElement; // Go up three levels to the main container
    var qtyInput = card.querySelector('.qty-box');
    var qty = parseInt(qtyInput.value) || 0;
  
    if (button.classList.contains('add-btn')) {
       qty += 1;
    } else if (button.classList.contains('subtract-btn')) {
       qty = Math.max(0, qty - 1);
    }
 
    qtyInput.value = qty;
 }
  function increaseDecreasefooditemqtymanually(value) {
    var inputvalue = value;
    console.log(inputvalue);
    var card = document.activeElement.closest('.card'); // Go up three levels to the main container
    console.log(card);
   var clonedcard = card.cloneNode(true);
   var itemsContainer = document.getElementById('fooditems');

    
 }
 
function addFooditemtoCart(){

}