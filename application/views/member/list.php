<?php
if (isset($all_member['staff_afterPg'])) :
    $num_of_members = count($all_member['member_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_member['member_afterPg']) && $num_of_members > 0) : ?>
            <?php echo form_open('member/delete', array('id' => 'list_member')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <img src="assets/images/admin/icons/active.gif" /> = active member; <img src="assets/images/admin/icons/not_active.gif" /> = inactive member; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="member_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="check-all" id='check_all_members' name='check_all_members' />
                            </th>
                            <th><a href="javascript:void(0);">Full Name</a></th>
                            <th><a href="javascript:void(0);">Email Address</a></th>
                            <th><a href="javascript:void(0);">Cell phone / Mobile No.</a></th>
                            <th><a href="javascript:void(0);">Chosen Delivery Location</a></th>
                            <th><a href="javascript:void(0);">Country</a></th>
                            <th><a href="javascript:void(0);">Creation Date</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="bulk-actions align-left">
                                    <a class="button" id="delete_members" href="javascript:void(0)" onclick="delete_checked_members();">Delete selected</a>&nbsp;
                                    <a href="member/manage" class="button">Add New Member</a>
                                </div>
                                <div class="pagination">
    <?php echo $member_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_member['member_afterPg'] as $rows_member) : ?>
                            <tr>
                                <td><input type="checkbox" name="member_id[]" value="<?php echo $rows_member->id ?>" /></td>
                                <td><?php echo $rows_member->full_name ?></td>
                                <td><?php echo $rows_member->email_address ?></td>
                                <td><?php echo $rows_member->mobile_no ?></td>
                                <td>
                                        <?php if ($rows_member->is_residence_preferred_delivery_place == 1) : ?>
                                            <?php  echo 'Home' ?>
                                        <?php else : ?>
                                            <?php  echo 'Office' ?>
                                        <?php endif ?>    
                                </td>
                                <td><?php echo $this->common_model->query_single_data('boutique_country_codes','id',$rows_member->country_code_id,'country') ?></td>
                                <td><?php echo date('F j, Y', strtotime($rows_member->created_at)) ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="member/manage/<?php echo $rows_member->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="javascript:void(0)" title="Delete" onclick="return delete_checked_member('Are you sure you want to delete <?php echo $rows_member->full_name ?>','member_deletion_type','list_member','<?php echo $rows_member->id ?>') ">
                                        <img src="assets/images/admin/icons/cross.png" alt="Delete" />
                                    </a>
                                    <?php if($rows_member->is_active == 0) : ?>
                                     <a href="javascript:void(0);" class="member_nactive_link" id="nacmember_<?php echo $rows_member->id ?>" title="Not active. Want to active?">
                                            <img src="assets/images/admin/icons/not_active.gif" alt="Not active. Want to active?" />
                                     </a>
                                     <?php else : ?>
                                     <a href="javascript:void(0)" class="member_active_link" id="acmember_<?php echo $rows_member->id ?>" title="Active. Want to inactive?">
                                            <img src="assets/images/admin/icons/active.gif" alt="Active. Want to inactive?" />
                                     </a>
                                     <?php endif ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="member" />
                <input type="hidden" id="member_deletion_type" name="member_deletion_type" value="" />
                <input type="hidden" id="single_member_id" name="single_member_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <img src="assets/images/admin/icons/cross.png" /> = remove; <img src="assets/images/admin/icons/active.gif" /> = active member; <img src="assets/images/admin/icons/not_active.gif" /> = inactive member; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No members found yet</div>
            </div>
            <div class="clear"></div>
            <a href="member/manage" class="button">Add New Member</a>
<?php endif ?>
    </div>        
</div>