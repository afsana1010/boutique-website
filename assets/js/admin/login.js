/**
 * Login 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com> 
 */

$(document).ready(function() {

    $(":text:visible:enabled:eq(0)").focus();

    $("#submit_btn").click(function(event){
        event.stopImmediatePropagation();
        admin_login();
    });
	
    $("#user_name, #user_pass").keypress(function(event) 
    {
        if ( event.which == 13 )
            admin_login();
    });

});


/**
  * Admin Login
  */
function admin_login()
{
    var base_url = $("input[name=base_url]").val();
			
    $("#status").html("<img border='0' src='assets/images/admin/loading.gif' />");
    var email = $("#user_email").val();
    var pass  = $("#user_pass").val();
    var security_token = $("input[name=csrf_boutique_token]").val();
    $.post(base_url + "siteadmin/login", {
        user_email: email, 
        user_pass: pass, 
        csrf_boutique_token: security_token
    }, 
    function(data) 
    { 
        var data_obj = jQuery.parseJSON(data);
        
        if( data_obj.status != 'failure' )
        {
            document.location = base_url + "siteadmin";
        }
        else
        {
            $("#status").html("<font color='red'>Invalid Username/Password!! Please try again.</font>");
            $(":text:visible:enabled:eq(0)").focus();	
        }
    });
}//end function