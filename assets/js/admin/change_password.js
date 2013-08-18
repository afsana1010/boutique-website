$(document).ready(function() {
	
    $("#change_btn").click(function() 
    {
        var base_url = $("input[name=base_url]").val();
        
        $("#change_status").html("<img border='0' src='assets/images/admin/loading.gif' />");
        var user_email = $("#user_email").val();
		var old_pass   = $("#old_pass").val();
        var new_pass   = $("#new_pass").val();
        var conf_pass  = $("#conf_pass").val();
        $.post(base_url + "siteadmin/change_password", {
            email     : user_email,
			old_pass  : old_pass, 
            new_pass  : new_pass, 
            conf_pass : conf_pass
        }, 
        function(data) 
        { 
            var data_obj = jQuery.parseJSON(data);
            if( data_obj.status == 'failure' )
            {
                $("#change_status").html("<font color='red'>"+data_obj.message+"</font>");
            }
            if( data_obj.status == 'success' )
            {
                $('#change_btn_row').css({
                    'display' : 'none'
                });
                $("#change_status").html("<font color='green'>"+data_obj.message+"</font>");
            }
        });
				
    });
			
    $('a[rel*=modal]').facebox({
        loading_image : base_url + 'assets/images/admin/loading.gif',
        close_image   : base_url + 'assets/images/admin/closelabel.gif'
    })
	
});