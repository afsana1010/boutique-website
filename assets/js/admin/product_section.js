/**
 * Activates selected section
 */
$(".section_nactive_link").live('click', function ()
  {
        if(confirm('Sure to Active?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "product_section/section_status", {oper: 'active', section_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "product_section";
                    });
        }
  });


/**
 * Inactivates selected section
 */
$(".section_active_link").live('click', function ()
  {
        if(confirm('Sure to Disable?'))
        {
            var base_url      = $("input[name=base_url]").val();
            var selector_id   = this.id;
            var selector_data = selector_id.split('_');
            var id            = selector_data[1];

            $.post(base_url + "product_section/section_status", {oper: 'inactive', section_id: id}, 
                    function(data) 
                    { 
                        document.location = base_url + "product_section";
                    });
        }
  });