$(document).ready(function() 
    {
    //alert('hellloo')
    /**
     * Finds and apply sorting option to the member-list table
     */
        if ($('#member_table').length > 0)
        {
            $('#member_table').tablesorter({
                headers: {
                    0: {
                        sorter: false
                    },
                    6: {
                        sorter: false
                    }
                }
            });
        }
    
    /**
     * Finds and apply sorting option to the stock-list table
     */
        if ($('#stock_table').length > 0)
        {
            $('#stock_table').tablesorter({
                headers: {
                    0: {
                        sorter: false
                    },
                    4: {
                        sorter: false
                    }
                }
            });
        }
    
    /**
     * Finds and apply sorting option to the category-list table
     */
        if ($('#category_table').length > 0)
        {
            $('#category_table').tablesorter({
                headers: {
                    0: {
                        sorter: false
                    },
                    3: {
                        sorter: false
                    }
                }
            });
        }
    
    /**
     * Finds and apply sorting option to the product-list table
     */
        if ($('#product_table').length > 0)
        {
            $('#product_table').tablesorter({
                headers: {
                    0: {
                        sorter: false
                    },
                    7: {
                        sorter: false
                    }
                }
            });
        }
    
    /**
     * Finds and apply sorting option to the sms/email-list table
     */
        if ($('#message_table').length > 0)
        {
            $('#message_table').tablesorter({
                headers: {
                    0: {
                        sorter: false
                    },
                    5: {
                        sorter: false
                    }
                }
            });
        }
        
    /**
     * Finds and apply sorting option to the inventory table
     */
        if ($('#inventory_table').length > 0)
        {
            $('#inventory_table').tablesorter();
        }
        
   /**
    * Finds and apply sorting option to the country-code table
    */
    if ($('#country_code_table').length > 0)
    {
        $('#country_code_table').tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                2: {
                    sorter: false
                }
            }
        });
    }     
    
   /**
     * Finds and apply datepicker to the joining-date field
    */
    if ($('#run_from').length > 0)
    {
        $("#run_from").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#run_from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    } 


    /**
     * Finds and apply datepicker to the joining-date field
    */
    if ($('#from_date').length > 0)
    {
        $("#from_date").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#from_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    } 

    /**
     * Finds and apply datepicker to the joining-date field
    */
    if ($('#to_date').length > 0)
    {
        $("#to_date").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#to_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    }        


    /**
     * Finds and apply datepicker to the joining-date field
    */
    if ($('#cheque_issue_date').length > 0)
    {
        $("#cheque_issue_date").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#cheque_issue_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    } 

    /**
     * Finds and apply datepicker to the joining-date field
    */
    if ($('#paytime').length > 0)
    {
        $("#paytime").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#paytime" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    } 


    /**
     * Finds and apply datepicker to the joining-date field
    */
    if ($('#payment_date').length > 0)
    {
        $("#payment_date").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#payment_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    }
	
	
   /**
    * Finds and apply datepicker to the joining-date field
    */
    if ($('#delivered_on').length > 0)
    {
        $("#delivered_on").datepicker({
            changeMonth: true,
            changeYear : true,
            yearRange  : '0:+10'
        });
        
        $( "#delivered_on" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
    }
    
    /**
     * Processes to change admin's password through a modal window
     */
        $("#change_btn").click(function() 
        {
            var base_url = $("input[name=base_url]").val();
        
            $("#change_status").html("<img border='0' src='" + base_url + "assets/images/admin/loading.gif' />");
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
		/*	
        $('a[rel*=modal]').facebox({
            loading_image : base_url + 'assets/images/admin/loading.gif',
            close_image   : base_url + 'assets/images/admin/closelabel.gif'
        })  
        */
    });
