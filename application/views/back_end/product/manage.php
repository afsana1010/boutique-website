<div class="content-box-header">
    <h3><?php echo $form_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
        <?php if ($action == 'edit'): ?>    
            <?php echo form_open('product/manage/' . $id, array('id' => 'product_input_form')) ?>
        <?php else : ?>
            <?php echo form_open('product/manage', array('id' => 'product_input_form')) ?>
        <?php endif ?>
        <?php echo form_hidden('base_url', base_url()) ?>

        <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label>Select Product Category</label>
                <?php foreach ($categories as $ctg): ?>
                    <?php $category_options[$ctg->id] = $ctg->name ?>
                <?php endforeach ?>
                <?php if (isset($category_id)) : ?>
                    <?php echo form_dropdown('category_id', $category_options, $category_id, 'class="small-input"') ?>
                <?php else : ?>
                    <?php echo form_dropdown('category_id', $category_options, '0', 'class="small-input"') ?>
                <?php endif ?>
            </p>
            
            <p>
                <label>Select Product Stock</label>
                <?php foreach ($stocks as $s): ?>
                    <?php $stock_options[$s->id] = $s->product_name ?>
                <?php endforeach ?>
                <?php if (isset($product_stock_id)) : ?>
                    <?php echo form_dropdown('product_stock_id', $stock_options, $product_stock_id, 'class="small-input"') ?>
                <?php else : ?>
                    <?php echo form_dropdown('product_stock_id', $stock_options, '0', 'class="small-input"') ?>
                <?php endif ?>
            </p>
            
            <p>
                <label for="product_name">Product Name </label> 
                <?php echo form_input(array('name' => 'product_name', 'id' => 'product_name', 'class' => 'text-input medium-input', 'maxlength' => '60', 'value' => isset($product_name) ? $product_name : set_value('product_name'))) ?>
                <?php echo form_error('product_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="product_no">Product No. </label> 
                <?php echo form_input(array('name' => 'product_no', 'id' => 'product_no', 'class' => 'text-input small-input', 'maxlength' => '30', 'value' => isset($product_no) ? $product_no : set_value('product_no'))) ?>
                <?php echo form_error('product_no', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="quantity">Available Quantity </label> 
                <?php echo form_input(array('name' => 'available_quantity', 'id' => 'available_quantity', 'class' => 'text-input small-input', 'value' => isset($available_quantity) ? $available_quantity : set_value('available_quantity'))) ?>
                <?php echo "<br /><small>should be a non-decimal value like 10, 750, etc.</strong></small>" ?>
                <?php echo form_error('available_quantity', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="description">Product Description </label>
                <?php echo form_input(array('name' => 'description', 'id' => 'description', 'class' => 'text-input large-input', 'value' => isset($description) ? $description : set_value('description'))) ?>
                <?php echo "<br /><small>Provide some details of the product to the user.</strong></small>" ?>
                <?php echo form_error('description', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="guarantee">Guarantee </label> 
                <?php echo form_input(array('name' => 'guarantee', 'id' => 'guarantee', 'class' => 'text-input small-input', 'value' => isset($guarantee) ? $guarantee : set_value('guarantee'))) ?>
                <?php echo "&nbsp;" ?>
                <?php
                    /* generates the drop-down for the gurantee-units */
                    $options = array();
                    foreach($guarantee_units as $g) :
                        $value 	= ltrim(rtrim($g,"'"),"'");
                        $options[$value] = ucfirst($value);
                    endforeach;

                    $class = "class='small-input'"; 
                    if(isset($guarantee_unit)) :
                        echo form_dropdown('guarantee_unit', $options, $guarantee_unit, $class);
                    else :
                        echo form_dropdown('guarantee_unit', $options, '', $class);
                    endif;
                ?>
                <?php echo form_error('guarantee', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>


            <div>
                <div id="fileQueue">
                    <table border="0" cellpadding="2" cellspacing="2">
                        <tr>
                            <td id="images_uploaded">
                                <?php
                                        if (!empty($images)) 
                                        {
                                            $files = explode('|', $images);
											echo "<pre>";print_r($files);die();
                                            $n     = count($files);
                                            for ($i = 0; $i < $n; $i++) 
                                            {
                                                $image_path    = base_url() . 'assets/uploads/product_images/' . $files[$i];
                                                $link_prefix   = '|http://(www\.)?' . str_replace('.', '\.', $_SERVER['HTTP_HOST']) . '|i';
                                                $file_path     = $_SERVER['DOCUMENT_ROOT'] . preg_replace($link_prefix, '', $image_path);
                                                $image_details = @getimagesize($file_path);
                                                $w             = ($image_details[0] > 128) ? 128 : $image_details[0];
                                                $order         = $this->common_model->query_single_data('boutique_product_images','file_name',$files[$i],'image_order');
                                                ?>
                                        <div id="uploaded_<?php echo $files[$i] ?>">
                                            <a target="_blank" href="<?php echo base_url() ?>assets/uploads/product_images/<?php echo $files[$i] ?>">
                                                <img alt="" border="0" src="<?php echo base_url(); ?>assets/uploads/product_images/<?php echo $files[$i] ?>" width="<?php echo $w ?>" />
                                            </a>
                                            &nbsp;position&nbsp;<input type="text" name="image_position[]" size="5" maxlength="2" value="<?php echo $order ?>" />
                                            <input type="hidden" name="image_names[]" value="<?php echo $files[$i] ?>" />
                                            <img class="img_del" id="<?php echo $files[$i] ?>" src="<?php echo base_url(); ?>assets/images/admin/cross.gif" alt="" border="0" style="padding-right:5px; cursor: pointer;" />
                                        </div>
                                        <br />
                                        <?php
                                            }
                                            $num_of_uploaded_files = $n;
                                        } 
                                        else 
                                        {
                                            $num_of_uploaded_files = 0;
                                        }
                                        $balance_files = 5 - $num_of_uploaded_files;
                                ?>
                            </td>
                        </tr>
                    </table>	
                </div>
                <div id="uploading_status"><p></p></div>
                <div id="upload_panel" <?php if ($balance_files == 0) : ?>style="display:none;"<?php endif ?>>
                    <p><strong>Image&nbsp;</strong>[ Maximum 5 files are allowed. Maximum filesize: 2MB. Allowed image files: .jpg, .gif ]</p>
                    <input id="image_input" name="image_input" type="file" /> 
                    <a href="javascript:$('#image_input').uploadifyUpload();">Upload Files</a> | <a href="javascript:$('#image_input').uploadifyClearQueue();">Clear Queue</a>
                </div>
            </div>
            
            <p>
                <label for="is_active">Product Status </label>
                <?php if ((isset($is_active)) && ($is_active == 0)) : ?>
                    <?php $check_active   = 'FALSE' ?>
                    <?php $check_inactive = 'TRUE' ?>
                <?php elseif ((isset($is_active)) && ($is_active == 1)) : ?>
                    <?php $check_active   = 'TRUE' ?>
                    <?php $check_inactive = 'FALSE' ?>
                <?php else : ?>
                    <?php $check_active   = 'FALSE' ?>
                    <?php $check_inactive = 'TRUE' ?>
                <?php endif ?>

                <?php echo form_radio(array('name' => 'is_active', 'id' => 'is_active', 'value' => '1', 'checked' => $check_active)) . '&nbsp;Active&nbsp;&nbsp;' ?>
                <?php echo form_radio(array('name' => 'is_active', 'id' => 'is_active', 'value' => '0', 'checked' => $check_inactive)) . 'Inactive' ?>
            </p>

            <p>        
                <?php echo form_input(array('name' => 'num_of_files', 'id' => 'num_of_files', 'style' => 'display:none;', 'value' => $balance_files)) ?>
                <?php echo form_input(array('name' => 'num_of_files_uploaded', 'id' => 'num_of_files_uploaded', 'style' => 'display:none;', 'value' => 0)) ?>
                <?php echo form_input(array('name' => 'images', 'id' => 'images', 'style' => 'display:none;', 'value' => $images)) ?>
            
                <?php echo form_submit(array('name' => 'submit_product_input', 'id' => 'submit_product_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     

        <div class="clear"></div><!-- End .clear -->

<?php echo form_close() ?>
    </div>        
</div>