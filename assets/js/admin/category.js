
/**
 * Delete single category
 */
function delete_checked_category(message,oper_element,form_element,item_id)
{
    var answer = confirm(message);
    if (answer)
    {
            document.getElementById(oper_element).value         = 'single';
            document.getElementById('single_category_id').value = item_id;
            document.getElementById(form_element).submit();
            
            return false;
    }
    
    return false;  
}
		

/**
 * Delete Multiple categories
 */
function delete_checked_categories()
{
    var element_id   = 'category_id[]';
    var item_name    = 'category';
    var form_id	     = 'list_category';
    var oper_element = 'category_deletion_type';

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