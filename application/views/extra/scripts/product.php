<script type="text/javascript">
    $(document).ready(function() 
    {

        $("#image_input").uploadify({
            'uploader'       : '<?php echo base_url(); ?>assets/js/admin/uploadify.swf',
            'script'         : '<?php echo base_url(); ?>assets/PHPforAJAX/uploadify.php',
            'cancelImg'      : '<?php echo base_url(); ?>assets/images/admin/cross.gif',
            'folder'         : '<?php echo base_url(); ?>assets/uploads/product_images',
            'queueID'        : 'fileQueue',
            'auto'	     : false,
            'multi'	     : true,
            'buttonImg'      : '<?php echo base_url(); ?>assets/images/admin/browse_button.png',
            'width'          : 100,
            'sizeLimit'      : 2000000, //2MB
            'fileDesc'	     : 'Image Files',
            'fileExt'	     : '*.jpg;*.jpeg;*.gif',
            'onCancel'       : function(event, queueID, fileObj, data)
            {
                $.jGrowl('<p></p>'+'Selected File', {
                    theme : 'warning',
                    header: 'Cancelled Upload',
                    life  : 4000,
                    sticky: false
                });
            },
            'onClearQueue'   : function(event, queueID, fileObj)
            {
                var msg = "Cleared "+queueID.fileCount+" files from queue";
                $.jGrowl('<p></p>'+msg, {
                    theme : 'warning',
                    header: 'Cleared Queue',
                    life  : 4000,
                    sticky: false
                });
            },
            'onComplete': function(event, queueID, fileObj, response, data) 
            {
                document.getElementById('num_of_files_uploaded').value = parseInt($("#num_of_files_uploaded").val())+1;
								  
                var num_of_files          = parseInt($("#num_of_files").val());
                var num_of_files_uploaded = parseInt($("#num_of_files_uploaded").val());
												  
                if (num_of_files_uploaded == num_of_files) 
                {
                    $('#image_input').uploadifyClearQueue();
														
                    var Div = document.getElementById("upload_panel");
                    Div.style.display="none";
                    $.jGrowl('<p></p>'+'Maximum 10 files are allowed to upload', {
                        theme : 'warning',
                        header: 'Crossing Uploading Limit',
                        life  : 15000,
                        sticky: false
                    });
                };
												
                $('#images_uploaded').append('<div id="uploaded_'+response+'"><a target="_blank" href="<?php echo base_url(); ?>assets/uploads/product_images/'+response+'"><img alt="" border="0" src="<?php echo base_url(); ?>assets/uploads/product_images/'+response+'" width="128" /></a>&nbsp;position&nbsp;<input type="text" name="image_position[]" size="5" maxlength="2" /><img class="img_del" id="'+response+'" src="<?php echo base_url(); ?>assets/images/admin/cross.gif" alt="" border="0" style="padding-right:5px; cursor: pointer;" /><input type="hidden" name="image_names[]" value="'+response+'" /></div><br />');
                $.post("<?php echo base_url(); ?>product/process_uploaded_image", { user_file: response }, 
                function(data) 
                { 
                    $('#images').val(data);
                });
                var size = Math.round(fileObj.size/1024);
                $.jGrowl('<p></p>'+fileObj.name+' - '+size+'KB', {
                    theme : 'warning',
                    header: 'Upload Complete',
                    life  : 4000,
                    sticky: false
                });		
            }
        });
					
        $(".img_del").live('click', function() 
        {
            $("#uploading_status p").html("<img border='0' src='<?php echo base_url(); ?>assets/images/admin/loading.gif' />");
            var image_name = this.id;
            $.post("<?php echo base_url(); ?>product/delete_image", { img: image_name }, 
            function(data) 
            { 
				if( data != 'failure' )
                {
                    $.jGrowl('<p></p>'+'Image Deleted', {
                        theme : 'warning',
                        header: 'Image Info',
                        life  : 4000,
                        sticky: false
                    });
                    var num_of_files          = parseInt($("#num_of_files").val());
                    var num_of_files_uploaded = parseInt($("#num_of_files_uploaded").val());
                    if((num_of_files > 0) && (num_of_files < 5) && (num_of_files_uploaded > 0))
                    {
                        document.getElementById('num_of_files_uploaded').value = parseInt($("#num_of_files_uploaded").val())-1;	
                    }
                    if((num_of_files > 0) && (num_of_files < 5) && (num_of_files_uploaded == 0))
                    {
                        document.getElementById('num_of_files').value = parseInt($("#num_of_files").val())+1;
                    }
                    if(num_of_files == 5)
                    {
                        document.getElementById('num_of_files_uploaded').value = parseInt($("#num_of_files_uploaded").val())-1;		
                    }	
                    if(num_of_files == 0)
                    {
                        document.getElementById('num_of_files').value = parseInt($("#num_of_files").val())+1;		
                    }
																								
                    $("#upload_panel").show();
                    $('#uploading_status').css({'display' : 'none'});
                    document.getElementById('uploaded_'+image_name).style.display = 'none';
                    document.getElementById('images').value = data;
                }
                else
                {
                    $('#uploading_status').css({'display' : 'none'});
                    alert('Could not delete!!');
					return false;
                }
            });		
        });
		
		
   });

</script>