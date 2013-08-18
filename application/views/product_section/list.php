<?php
if (isset($all_section['section_afterPg'])) :
    $num_of_sections = count($all_section['section_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_section['section_afterPg']) && $num_of_sections > 0) : ?>
            <?php echo form_open('product_section/delete', array('id' => 'list_section')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/active.gif" /> = active section; <img src="assets/images/admin/icons/not_active.gif" /> = inactive section; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="section_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th><a href="javascript:void(0);">Creation Date</a></th>
                            <th><a href="javascript:void(0);">Section Name</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div class="bulk-actions align-left">
                                    <a class="button" id="delete_sections" href="javascript:void(0)" onclick="delete_checked_sections();">Delete selected</a>&nbsp;
                                    <a href="product_section/manage" class="button">Add New Section</a>
                                </div>
                                <div class="pagination">
    <?php echo $section_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_section['section_afterPg'] as $rows_section) : ?>
                            <tr>
                                <td><?php echo date('F j, Y', strtotime($rows_section->created_at)) ?></td>
                                <td><?php echo $rows_section->name ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="product_section/manage/<?php echo $rows_section->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <?php if($rows_section->is_active == 0) : ?>
                                     <a href="javascript:void(0);" class="section_nactive_link" id="nacsection_<?php echo $rows_section->id ?>" title="Not active. Want to active?">
                                            <img src="assets/images/admin/icons/not_active.gif" alt="Not active. Want to active?" />
                                     </a>
                                     <?php else : ?>
                                     <a href="javascript:void(0)" class="section_active_link" id="acsection_<?php echo $rows_section->id ?>" title="Active. Want to inactive?">
                                            <img src="assets/images/admin/icons/active.gif" alt="Active. Want to inactive?" />
                                     </a>
                                     <?php endif ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/active.gif" /> = active section; <img src="assets/images/admin/icons/not_active.gif" /> = inactive section; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                <div>No products found yet</div>
            </div>
            <div class="clear"></div>
            <a href="product_section/manage" class="button">Add New Section</a>
<?php endif ?>
    </div>        
</div>