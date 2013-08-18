<?php
if (isset($all_code['code_afterPg'])) :
    $num_of_codes = count($all_code['code_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_code['code_afterPg']) && $num_of_codes > 0) : ?>
            <?php echo form_open('country_code/delete', array('id' => 'list_code')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="country_code_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="check-all" id='check_all_codes' name='check_all_codes' />
                            </th>
                            <th><a href="javascript:void(0);">Country Name</a></th>
                            <th><a href="javascript:void(0);">Country Code</a></th>
                            <th><a href="javascript:void(0);">Creation Date</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="bulk-actions align-left">
                                    <a class="button" id="delete_codes" href="javascript:void(0)" onclick="delete_checked_codes();">Delete selected</a>&nbsp;
                                    <a href="country_code/manage" class="button">Add New Code</a>
                                </div>
                                <div class="pagination">
    								<?php echo $code_paging ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_code['code_afterPg'] as $rows_code) : ?>
                            <tr>
                                <td><input type="checkbox" name="code_id[]" value="<?php echo $rows_code->id ?>" /></td>
                                <td><?php echo $rows_code->country ?></td>
								<td><?php echo $rows_code->code ?></td>
                                <td><?php echo date('F j, Y', strtotime($rows_code->created_at)) ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="country_code/manage/<?php echo $rows_code->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="javascript:void(0)" title="Delete" onclick="return delete_checked_code('Are you sure you want to delete <?php echo $rows_code->country ?>','code_deletion_type','list_code','<?php echo $rows_code->id ?>') ">
                                        <img src="assets/images/admin/icons/cross.png" alt="Delete" />
                                    </a>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="code" />
                <input type="hidden" id="code_deletion_type" name="code_deletion_type" value="" />
                <input type="hidden" id="single_code_id" name="single_code_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                <div>No codes found yet</div>
            </div>
            <div class="clear"></div>
            <a href="country_code/manage" class="button">Add New Code</a>
<?php endif ?>
    </div>        
</div>