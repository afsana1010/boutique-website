/**
 * Delete single product
 */
function delete_checked_product(message,oper_element,form_element,item_id)
{
    var answer = confirm(message);
    if (answer)
    {
            document.getElementById(oper_element).value       = 'single';
            document.getElementById('single_product_id').value = item_id;
            document.getElementById(form_element).submit();
            
            return false;
    }
    
    return false;  
}
		

/**
 * Delete Multiple products
 */
function delete_checked_products()
{
    var element_id   = 'product_id[]';
    var item_name    = 'product';
    var form_id	     = 'list_product';
    var oper_element = 'product_deletion_type';

    var copt = 0;
    if (document.getElementById(form_id).elements[element_id].checked)
        copt += 1;
            
     for (var i = 0; i < document.getElementById(form_id).elements[element_id].length; i++)
     { 
          if (document.getElementById(form_id).elements[element_id][i].checked)
            copt += 1; 
     } 
     if (copt == 0)
     { 
          alert('Please select '+item_name+' item(s) to delete!!'); 

          return;
     }
    if (copt > 0)
    { 
          if( confirm("Sure to delete?") == false)
                return;
    }	  

    document.getElementById(oper_element).value = 'multiple';
    document.getElementById(form_id).submit();	  

 }


/**
 * Activates selected product
 */
$(".product_nactive_link").live('click', function ()
  {
        if(confirm('Sure to Active?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "product/product_status", {oper: 'active', product_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "product";
                    });
        }
  });


/**
 * Inactivates selected product
 */
$(".product_active_link").live('click', function ()
  {
        if(confirm('Sure to Disable?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "product/product_status", {oper: 'inactive', product_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "product";
                    });
        }
  });