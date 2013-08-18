
/**
 * Delete single advertisement
 */
function delete_checked_advertisement(message,oper_element,form_element,item_id)
{
    var answer = confirm(message);
    if (answer)
    {
            document.getElementById(oper_element).value       = 'single';
            document.getElementById('single_advertisement_id').value = item_id;
            document.getElementById(form_element).submit();
            
            return false;
    }
    
    return false;  
}
		

/**
 * Delete Multiple advertisements
 */
function delete_checked_advertisements()
{
    var element_id   = 'advertisement_id[]';
    var item_name    = 'advertisement';
    var form_id	     = 'list_advertisement';
    var oper_element = 'advertisement_deletion_type';

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
 * Activates selected advertisement
 */
$(".advertisement_nactive_link").live('click', function ()
  {
        if(confirm('Sure to Active?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "advertisement/advertisement_status", {oper: 'active', advertisement_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "advertisement";
                    });
        }
  });


/**
 * Inactivates selected advertisement
 */
$(".advertisement_active_link").live('click', function ()
  {
        if(confirm('Sure to Disable?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "advertisement/advertisement_status", {oper: 'inactive', advertisement_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "advertisement";
                    });
        }
  });



/**
 * Displays advertisement's mode-of-payment-change options
 */
//$document.ready(function()
//{
  $('#mode_of_payment').live('change', function ()
  {
    if (this.value == 'cheque')
    {
      $('#cheques_panel').removeAttr('style');
      $('#cheques_panel').attr('style', 'background-color:#cccccc;')
    }
    else
    {
      $('#cheques_panel').attr('style', 'display:none;');
    }
    if (this.value == 'paypal')
    {
      $('#paypals_panel').removeAttr('style');
      $('#paypals_panel').attr('style', 'background-color:#cccccc;')
    }
    else
    {
      $('#paypals_panel').attr('style', 'display:none;');
    } 
  });
//});