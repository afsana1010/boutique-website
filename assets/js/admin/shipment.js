/**
 * Delete single shipment
 */
function delete_checked_shipment(message,oper_element,form_element,item_id)
{
    var answer = confirm(message);
    if (answer)
    {
            document.getElementById(oper_element).value       = 'single';
            document.getElementById('single_shipment_id').value = item_id;
            document.getElementById(form_element).submit();
            
            return false;
    }
    
    return false;  
}
		

/**
 * Delete Multiple shipments
 */
function delete_checked_shipments()
{
    var element_id   = 'shipment_id[]';
    var item_name    = 'shipment';
    var form_id	     = 'list_shipment';
    var oper_element = 'shipment_deletion_type';

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