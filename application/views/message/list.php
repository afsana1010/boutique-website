<?php
    if (isset($all_message['message_afterPg'])) :
        $num_of_messages = count($all_message['message_afterPg']);
    endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_message['message_afterPg']) && $num_of_messages > 0) : ?>
            <?php echo form_open('message/delete', array('id' => 'list_message')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit message; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="message_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <!--
                            <th>
                                <input type="checkbox" class="check-all" id='check_all_messages' name='check_all_messages' />
                            </th>
                            -->
                            <th><a href="javascript:void(0);">Action Name</a></th>
                            <th><a href="javascript:void(0);">Message Content</a></th>
                            <th><a href="javascript:void(0);">Media</a></th>
                            <th><a href="javascript:void(0);">Creation Date</a></th>
                            <th>Edit Message</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="bulk-actions align-left">
                                    <!--<a href="message/manage" class="button">Add New Message</a>-->
                                </div>
                                <div class="pagination">
    <?php echo $message_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_message['message_afterPg'] as $rows_message) : ?>
                            <tr>
                                <!--<td><input type="checkbox" name="message_id[]" value="<?php echo $rows_message->id ?>" /></td>-->
                                <td><?php echo $rows_message->action_name ?></td>
                                <td><?php echo $rows_message->message ?></td>
                                <td><?php echo ucfirst($rows_message->message_media) ?></td>
                                <td><?php echo date('F j, Y', strtotime($rows_message->created_at)) ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="message/manage/<?php echo $rows_message->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="message" />
                <input type="hidden" id="message_deletion_type" name="message_deletion_type" value="" />
                <input type="hidden" id="single_message_id" name="single_message_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit message; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No messages found yet</div>
            </div>
            <div class="clear"></div>
            <!--<a href="message/manage" class="button">Add New message</a>-->
<?php endif ?>
    </div>        
</div>