<?php
if (isset($all_product['staff_afterPg'])) :
    $num_of_products = count($all_product['product_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_product['product_afterPg']) && $num_of_products > 0) : ?>
            <?php echo form_open('product/delete', array('id' => 'list_product')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <img src="assets/images/admin/icons/active.gif" /> = active product; <img src="assets/images/admin/icons/not_active.gif" /> = inactive product; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="product_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="check-all" id='check_all_products' name='check_all_products' />
                            </th>
                            <th><a href="javascript:void(0);">Creation Date</a></th>
                            <th><a href="javascript:void(0);">Category</a></th>
                            <th><a href="javascript:void(0);">Product Name</a></th>
                            <th><a href="javascript:void(0);">Product No</a></th>
                            <th><a href="javascript:void(0);">Guarantee</a></th>
                            <th><a href="javascript:void(0);">Price (SGD)</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="bulk-actions align-left">
                                    <a class="button" id="delete_products" href="javascript:void(0)" onclick="delete_checked_products();">Delete selected</a>&nbsp;
                                    <a href="product/manage" class="button">Add New Product</a>
                                </div>
                                <div class="pagination">
    <?php echo $product_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_product['product_afterPg'] as $rows_product) : ?>
                            <tr>
                                <td><input type="checkbox" name="product_id[]" value="<?php echo $rows_product->id ?>" /></td>
                                <td><?php echo date('F j, Y', strtotime($rows_product->created_at)) ?></td>
                                <td><?php echo $this->common_model->query_single_data('boutique_categories','id',$rows_product->category_id,'name') ?></td>
                                <td><?php echo $rows_product->product_name ?></td>
                                <td><?php echo $rows_product->product_no ?></td>
                                <td><?php echo $rows_product->guarantee . '&nbsp;' . ucfirst($rows_product->guarantee_unit) ?></td>
                                <td><?php echo $this->common_model->query_single_data('boutique_product_stocks','id',$rows_product->product_stock_id,'amount') ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="product/manage/<?php echo $rows_product->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="javascript:void(0)" title="Delete" onclick="return delete_checked_product('Are you sure you want to delete <?php echo $rows_product->product_name ?>','product_deletion_type','list_product','<?php echo $rows_product->id ?>') ">
                                        <img src="assets/images/admin/icons/cross.png" alt="Delete" />
                                    </a>
                                    <?php if($rows_product->is_active == 0) : ?>
                                     <a href="javascript:void(0);" class="product_nactive_link" id="nacproduct_<?php echo $rows_product->id ?>" title="Not active. Want to active?">
                                            <img src="assets/images/admin/icons/not_active.gif" alt="Not active. Want to active?" />
                                     </a>
                                     <?php else : ?>
                                     <a href="javascript:void(0)" class="product_active_link" id="acproduct_<?php echo $rows_product->id ?>" title="Active. Want to inactive?">
                                            <img src="assets/images/admin/icons/active.gif" alt="Active. Want to inactive?" />
                                     </a>
                                     <?php endif ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="product" />
                <input type="hidden" id="product_deletion_type" name="product_deletion_type" value="" />
                <input type="hidden" id="single_product_id" name="single_product_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <img src="assets/images/admin/icons/active.gif" /> = active product; <img src="assets/images/admin/icons/not_active.gif" /> = inactive product; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                <div>No products found yet</div>
            </div>
            <div class="clear"></div>
            <a href="product/manage" class="button">Add New Product</a>
<?php endif ?>
    </div>        
</div>