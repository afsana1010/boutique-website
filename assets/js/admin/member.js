
/**
 * Delete single member
 */
function delete_checked_member(message,oper_element,form_element,item_id)
{
    var answer = confirm(message);
    if (answer)
    {
            document.getElementById(oper_element).value       = 'single';
            document.getElementById('single_member_id').value = item_id;
            document.getElementById(form_element).submit();
            
            return false;
    }
    
    return false;  
}
		

/**
 * Delete Multiple members
 */
function delete_checked_members()
{
    var element_id   = 'member_id[]';
    var item_name    = 'member';
    var form_id	     = 'list_member';
    var oper_element = 'member_deletion_type';

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
 * Displays member's password-change options
 */
$('#change_password').live('click', function ()
{
    if (this.checked == true)
    {
        $('#password_panel').removeAttr('style');
        $('#password_panel').attr('style', 'background-color:#cccccc;')
    }
    else
    {
        $('#password_panel').attr('style', 'display:none;');
    }
});


/**
 * Activates selected member
 */
$(".member_nactive_link").live('click', function ()
  {
        if(confirm('Sure to Active?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "member/member_status", {oper: 'active', member_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "member";
                    });
        }
  });


/**
 * Inactivates selected member
 */
$(".member_active_link").live('click', function ()
  {
        if(confirm('Sure to Disable?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "member/member_status", {oper: 'inactive', member_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "member";
                    });
        }
  });