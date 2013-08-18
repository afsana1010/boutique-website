/**
 * Delete single item from the shopping-cart
 */
function delete_checked_item(message,base_url,item_id)
{
    var answer = confirm(message);
    if (answer)
    {
            //document.getElementById(oper_element).value     = 'single';
            //document.getElementById('single_item_id').value = item_id;
            document.location = base_url + "product/remove/" + item_id;
            
            return false;
    }
    
    return false;  
}

//$(document).ready(function() 
//{
///**
// * Delete single item from the shopping-cart
// */
//$(".btn btn-danger").live('click', function ()
//  {
//        if(confirm('Are you sure you want to remove the item from the cart?'))
//        {
//            var base_url = $("input[name=base_url]").val();
//            var link_id  = this.id;
//            var id_data  = link_id.split('_');
//            var cart_id  = id_data[1];
//            
//            $.post(base_url + "product/remove", {cart_item: cart_id}, 
//                    function(data) 
//                    { 
//                        document.location = base_url + "product/display_shopping_cart";
//                    });
//        }
//  });
//  
// });