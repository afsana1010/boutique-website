<?php
if (isset($all_category['staff_afterPg'])) :
    $num_of_categories = count($all_category['category_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_category['category_afterPg']) && $num_of_categories > 0) : ?>
            <?php echo form_open('category/delete', array('id' => 'list_category')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="category_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="check-all" id='check_all_categories' name='check_all_categories' />
                            </th>
                            <th><a href="javascript:void(0);">Category Name</a></th>
                            <th><a href="javascript:void(0);">Category Section</a></th>
                            <th><a href="javascript:void(0);">Creation Date</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="bulk-actions align-left">
                                    <a class="button" id="delete_categories" href="javascript:void(0)" onclick="delete_checked_categories();">Delete selected</a>&nbsp;
                                    <a href="category/manage" class="button">Add New Category</a>
                                </div>
                                <div class="pagination">
    								<?php echo $category_paging ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_category['category_afterPg'] as $rows_category) : ?>
                            <tr>
                                <td><input type="checkbox" name="category_id[]" value="<?php echo $rows_category->id ?>" /></td>
                                <td><?php echo $rows_category->name ?></td>
                                <td>
                                    <?php $category_section = $this->common_model->query_single_data('boutique_product_sections', 'id', $rows_category->product_section_id, 'name') ?>
                                    <?php echo ucfirst($category_section) ?>
                                </td>
                                <td><?php echo date('F j, Y', strtotime($rows_category->created_at)) ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="category/manage/<?php echo $rows_category->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="javascript:void(0)" title="Delete" onclick="return delete_checked_category('Are you sure you want to delete <?php echo $rows_category->name ?>','category_deletion_type','list_category','<?php echo $rows_category->id ?>') ">
                                        <img src="assets/images/admin/icons/cross.png" alt="Delete" />
                                    </a>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="category" />
                <input type="hidden" id="category_deletion_type" name="category_deletion_type" value="" />
                <input type="hidden" id="single_category_id" name="single_category_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                <div>No categories found yet</div>
            </div>
            <div class="clear"></div>
            <a href="category/manage" class="button">Add New Category</a>
<?php endif ?>
    </div>        
</div>