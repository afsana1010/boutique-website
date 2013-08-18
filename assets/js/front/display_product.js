$(document).ready(function()
    {
        $(".product_other_image").click(function(){
            var element_id = this.id;
            var element_id_array = element_id.split('_');
            var product_id = element_id_array[3];
            $("#product_image_" + product_id).attr('src', $(this).attr('src'));
        });
        
     }); //end ready event