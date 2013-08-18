<?php
    if (isset($all_product['product_afterPg'])) :
        $num_of_products = count($all_product['product_afterPg']);
    endif;
?>

<?php if (isset($all_product['product_afterPg']) && $num_of_products > 0) : ?>
<h3><?php echo $table_title ?></h3>
    <?php
    $ul_count = 1;
    $i        = 0;
    $length   = count($all_product['product_afterPg']);
    ?>
    <?php foreach ($all_product['product_afterPg'] as $row): ?>
        <?php if ($row->available_quantity > 0) : ?>
            <?php if ($ul_count == 1): ?>
                <ul class="thumbnails">
                    <?php endif; ?>
                <li class="span3">
                    <?php echo form_open('product/shopping_cart', array('id' => 'shoppingc_cart_input_form_' . $i, 'class' => 'form-horizontal')) ?>
                    <?php echo form_hidden('product_id', $row->id) ?>
                    <?php echo form_hidden('category_id', $row->category_id) ?>
                    <?php
                    $img_flag   = 0;
                    $image_data = $this->common_model->query_multiple_rows_by_single_source('boutique_product_images', 'product_id', $row->id, 'image_order');
                    if (count($image_data) > 0) :
                        $img_flag      = 1;
                        $image_files   = array();
                        $image_widths  = array();
                        $image_heights = array();
                        foreach ($image_data as $img) :
                            $dimension = explode('X', $img->dimension);
                            $width     = ($dimension[0] <= 150) ? $dimension[0] : 150;
                            $height    = $dimension[1];
                            array_push($image_files, $img->file_name);
                            array_push($image_widths, $width);
                            array_push($image_heights, $height);
                        endforeach;
                        
                        $photo_text = (count($image_data) > 1) ? 'original & other photos' : 'original photo'
                        ?>
                        <img src="assets/uploads/product_images/<?php echo $image_files[0] ?>" alt="" class="img-rounded" width="<?php echo $image_widths[0] ?>" height="<?php echo $image_heights[0] ?>" />
                        <br />
                        <a href="#photo_<?php echo $row->id ?>" data-toggle="modal" class="display_modal" id="image_<?php echo $row->id ?>">
                            <small><?php echo $photo_text ?>&nbsp;</small>
                        </a>|&nbsp;
            <?php endif ?>
                    <a href="#product_<?php echo $row->id ?>" data-toggle="modal">
                        <small>more details</small>
                    </a>
                    <h5> <?php echo $row->product_name ?></h5>
                    <h5> <?php echo "Price " . $row->unit_price ?></h5>
                    Quantity
                        <select class="select_quantity" name="quantity">
                            <?php for ($q = 1; $q <= $row->available_quantity; $q++): ?>
                                <option value="<?php echo $q ?>"><?php echo $q ?></option>
                            <?php endfor ?>
                        </select>&nbsp;
                        
            <?php if ($img_flag == 1) : ?>
                        <!-- starts modal window for original photo -->
                        <div class="modal hide fade" id="photo_<?php echo $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <h3 id="myModalLabel"><?php echo $row->product_name ?></h3>
                            </div>
                            <div class="modal-body">
                                <img id="product_image_<?php echo $row->id ?>" src="assets/uploads/product_images/<?php echo $image_files[0] ?>"  />
                                <?php if (count($image_files) > 1): ?>
                                    <div id="other_images_<?php echo $row->id ?>">
                                        <?php foreach ($image_files as $img => $val): ?>
                                            <img class="product_other_image" id="product_other_image_<?php echo $row->id ?>" style="border: 1px solid #808088; padding: 1px 1px 1px 1px; height:75px; cursor:pointer;" src="assets/uploads/product_images/<?php echo $val ?>"/>
                                        <?php endforeach ?>
                                    </div>
                                    <center id="image_files_<?php echo $row->id ?>"></center>
                                <?php endif ?>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            </div>
                        </div>
                        <!-- ends modal window for original photo -->
            <?php endif ?>

                    <!-- starts modal window for item-details -->
                    <div class="modal hide fade" id="product_<?php echo $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h3 id="myModalLabel"><?php echo $row->product_name ?></h3>
                        </div>
                        <div class="modal-body">
                            <p>
                                <ul>
                                    <li>
                                        <strong>Product No:&nbsp;</strong><?php echo $row->product_no ?>
                                    </li>
                                    <li>
                                        <strong>Item Price:&nbsp;</strong><?php echo $row->unit_price ?> SGD
                                    </li>
                                    <li>
                                        <strong>Available Quantity:&nbsp;</strong><?php echo $row->available_quantity ?>
                                    </li>
                                    <li>
                                        <strong>Guarantee:&nbsp;</strong><?php echo $row->guarantee . ' ' . $row->guarantee_unit ?>
                                    </li>
                                    <li>
                                        <p class="text-info"><?php echo $row->description ?></p>
                                    </li>
                                </ul>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                    <!-- ends modal window for item-details -->
                    </p>
                    <?php //if($this->session->userdata('logged_in') && $this->session->userdata('user_id')) :  ?>
                    <p><button  class="btn btn-primary btn-success" type="submit">Add to cart</button></p>
                <?php echo form_close() ?>
                </li>
                <?php
                $ul_count++;
                $i++;
                if (($ul_count == 4) || $i == $length):
                    ?>
                </ul><hr />
                <?php $ul_count = 1 ?>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
    
    <div class="pagination" style="text-align: center;">
        <?php echo $product_paging ?>
    </div>            
<?php endif ?>