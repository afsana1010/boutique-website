<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php echo form_hidden('base_url', base_url()) ?>
    <?php if ($action == 'edit')
			{ 
				echo form_open_multipart('advertisement/manage/' . $id, array('id' => 'advertisement_input_form'));
				echo form_hidden('action', 'edit'); 
				echo form_hidden('payment_mode', $mode_of_payment); 
				/*if($mode_of_payment == 'paypal') 
				{
					$paypals_panel="style='background-color:#cccccc;'";
					$cheques_panel="style='display:none;'";
				}
				elseif($mode_of_payment == 'cheque') 
				{
					$cheques_panel="style='background-color:#cccccc;'";
					$paypals_panel="style='display:none;'";
				}
                elseif {
                    $paypals_panel="style='display:none;'";
                    $cheques_panel="style='display:none;'";
                }
				else {*/
					$paypals_panel="style='display:none;'";
					$cheques_panel="style='display:none;'";
				//}
			}
		 else 
			{ 
				echo form_open_multipart('advertisement/manage', array('id' => 'advertisement_input_form')); 
				$paypals_panel="style='display:none;'";$cheques_panel="style='display:none;'";
			} 
	?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label for="customer_name">Customer Name </label> 
                <?php echo form_input(array('name' => 'customer_name', 'id' => 'customer_name', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($customer_name) ? $customer_name : set_value('customer_name'))) ?>
                <?php echo form_error('customer_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="address_line_one">Address - 1 </label> 
                <?php echo form_input(array('name' => 'address_line_one', 'id' => 'address_line_one', 'class' => 'text-input small-input', 'value' => isset($address_line_one) ? $address_line_one : set_value('address_line_one'))) ?>
                <?php //echo "<br /><small>should be a non-decimal value like 1500, 700, etc.</strong></small>" ?>
                <?php echo form_error('address_line_one', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="address_line_two">Address - 2 </label> 
                <?php echo form_input(array('name' => 'address_line_two', 'id' => 'address_line_two', 'class' => 'text-input small-input', 'value' => isset($address_line_two) ? $address_line_two : set_value('address_line_two'))) ?>
                <?php //echo "<br /><small>should be a decimal value like 45.95, 789.00, etc.</strong></small>" ?>
                <?php echo form_error('address_line_two', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="address_line_three">Address - 3 </label>
                <?php echo form_input(array('name' => 'address_line_three', 'id' => 'address_line_three', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($address_line_three) ? $address_line_three : set_value('address_line_three'))) ?>
                <?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('address_line_three', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>            
			
			<p>
                <label for="mobile_no">Mobile No.</label>
                <?php echo form_input(array('name' => 'mobile_no', 'id' => 'mobile_no', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($mobile_no) ? $mobile_no : set_value('mobile_no'))) ?>
                <?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('mobile_no', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="email_address">Email ID</label>
                <?php echo form_input(array('name' => 'email_address', 'id' => 'image_file_path', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($email_address) ? $email_address : set_value('email_address'))) ?>
                <?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('email_address', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="selected_position">Select Position</label>
                <?php 
					$options_selected_position['top']='Top';
					$options_selected_position['right']='Right';
					$options_selected_position['left']='Left';
					echo form_dropdown('selected_position',$options_selected_position,'class="small-input"',set_value('selected_position', (isset($selected_position) ? $selected_position: "")));
				?>	                
				<?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('selected_position', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
		
		
			<p>
                <label for="selected_period">Select Period</label>
                <?php echo form_input(array('name' => 'selected_period', 'id' => 'selected_period', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($selected_period) ? $selected_period : set_value('selected_period'))) ?>
                <?php 
					$options_selected_period_unit['day']='Day';
					$options_selected_period_unit['week']='Week';
					$options_selected_period_unit['month']='Month';
					$options_selected_period_unit['year']='Year';
					echo form_dropdown('selected_period_unit',$options_selected_period_unit,'class="small-input"',set_value('selected_period_unit', (isset($selected_period_unit) ? $selected_period_unit: "")));
				?>                
				<?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('selected_period', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
   		
			<p>
                <label for="run_from">Advertisement Should Run From</label>
                <?php echo form_input(array('name' => 'run_from', 'id' => 'run_from', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($run_from) ? $run_from :"")) ?>
                <?php echo "<br /><small>Select a date from calender</strong></small>" ?>
                <?php echo form_error('run_from', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
   				
			<p>
                <label for="url">URL</label>
                <?php echo form_input(array('name' => 'url', 'id' => 'url', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($url) ? $url : set_value('url'))) ?>
                <?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('url', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="description">Description</label>
                <?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => 'textarea', 'cols'=>'25', 'rows' => '10', 'value' => isset($description) ? $description : set_value('description'))) ?>
                <?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('description', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="amount">Amount</label>
                <?php echo form_input(array('name' => 'amount', 'id' => 'amount', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($amount) ? $amount : set_value('amount'))) ?>
                <?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('amount', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="mode_of_payment">Mode of Payment</label>
				<?php 
					if(isset($mode_of_payment)=='cash') $selected='selected="selected"';
					elseif(isset($mode_of_payment)=='cheque')  $selected='selected="selected"';
					elseif(isset($mode_of_payment)=='paypal')  $selected='selected="selected"';
					elseif(isset($mode_of_payment)=='other')  $selected='selected="selected"';
					else $selected='';
				?>
				<select name="mode_of_payment" class="small-input" id="mode_of_payment">					
					<option value="cash"  <?php echo $selected;?>>Cash</option>
					<option value="cheque"<?php echo $selected;?>>Cheque</option>
					<option value="paypal"<?php echo $selected;?>>Paypal</option>
					<option value="other" <?php echo $selected;?>>Other</option>
				</select>				
				<?php //echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('mode_of_payment', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <!-- starts cheques inputs -->

            <div id="cheques_panel" <?php echo $cheques_panel ?>>
                <p>
                    <label for="account_no">Account No </label> 
                    <?php echo form_input(array('name' => 'account_no', 'id' => 'account_no', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($account_no) ? $account_no : set_value('account_no'))) ?>
                    <?php echo form_error('account_no', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>
                
				<p>
                    <label for="account_name">Account Name</label> 
                    <?php echo form_input(array('name' => 'account_name', 'id' => 'account_name', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($account_name) ? $account_name : set_value('account_name'))) ?>
                    <?php echo form_error('account_name', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>                
				
				<p>
                    <label for="bank_name">Bank Name</label> 
                    <?php echo form_input(array('name' => 'bank_name', 'id' => 'bank_name', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($bank_name) ? $bank_name : set_value('bank_name'))) ?>
                    <?php echo form_error('bank_name', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>				
				
				<p>
                    <label for="bank_branch">Branch Name</label> 
                    <?php echo form_input(array('name' => 'bank_branch', 'id' => 'bank_branch', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($bank_branch) ? $bank_branch : set_value('bank_branch'))) ?>
                    <?php echo form_error('bank_branch', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>	
				
				<p>
                    <label for="cheque_issue_date">Cheque Issue Date</label> 
                    <?php echo form_input(array('name' => 'cheque_issue_date', 'id' => 'cheque_issue_date', 'class' => 'text-input small-input', 'readonly' => 'true','maxlength' => '100','value' => isset($cheque_issue_date) ? $cheque_issue_date : set_value('cheque_issue_date'))) ?>
                    <?php echo form_error('cheque_issue_date', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>	
            </div>
            <!-- ends cheques inputs -->
			
            <!-- starts paypals inputs -->

            <div id="paypals_panel" <?php echo $paypals_panel ?>>
                <p>
                    <label for="user_id">User Id </label> 
                    <?php echo form_input(array('name' => 'user_id', 'id' => 'user_id', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($user_id) ? $user_id : set_value('user_id'))) ?>
                    <?php echo form_error('user_id', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>
                
				<p>
                    <label for="transaction_id">Transaction Id </label> 
                    <?php echo form_input(array('name' => 'transaction_id', 'id' => 'transaction_id', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($transaction_id) ? $transaction_id : set_value('transaction_id'))) ?>
                    <?php echo form_error('transaction_id', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>                
				
				<p>
                    <label for="payment_status">Payment Status </label> 
                    <?php echo form_input(array('name' => 'payment_status', 'id' => 'payment_status', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($payment_status) ? $payment_status : set_value('payment_status'))) ?>
                    <?php echo form_error('payment_status', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>				
				
				<p>
                    <label for="paid_amount">Paid Amount </label> 
                    <?php echo form_input(array('name' => 'paid_amount', 'id' => 'paid_amount', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($paid_amount) ? $paid_amount : set_value('paid_amount'))) ?>
                    <?php echo form_error('paid_amount', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>	
				
				<p>
                    <label for="paid_currency">Paid Currency </label> 
                    <?php echo form_input(array('name' => 'paid_currency', 'id' => 'paid_currency', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($paid_currency) ? $paid_currency : set_value('paid_currency'))) ?>
                    <?php echo form_error('paid_currency', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>				
				<p>
                    <label for="paytime">Paytime </label> 
                    <?php echo form_input(array('name' => 'paytime', 'id' => 'paytime', 'class' => 'text-input small-input','readonly' => 'true', 'maxlength' => '100','value' => isset($paytime) ? $paytime : set_value('paytime'))) ?>
                    <?php echo form_error('paytime', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>	
            </div>
            <!-- ends paypals inputs -->			
			<div>
                <div id="fileQueue">
                    <table border="0" cellpadding="2" cellspacing="2">
                        <tr>
                            <td id="images_uploaded">
                                <?php
                                        if (!empty($images)) 
                                        {
                                            $files = explode('|', $images);
											//echo "<pre>";print_r($files);die();
                                            $n     = count($files);
                                            for ($i = 0; $i < $n; $i++) 
                                            {
                                                $image_path    = base_url() . 'assets/uploads/advertisement_images/' . $files[$i];
                                                $link_prefix   = '|http://(www\.)?' . str_replace('.', '\.', $_SERVER['HTTP_HOST']) . '|i';
                                                $file_path     = $_SERVER['DOCUMENT_ROOT'] . preg_replace($link_prefix, '', $image_path);
                                                $image_details = @getimagesize($file_path);
                                                $w             = ($image_details[0] > 128) ? 128 : $image_details[0];
                                                //$order         = $this->common_model->query_single_data('boutique_advertisements','file_name',$files[$i],'image_order');
                                                ?>
                                        <div id="uploaded_<?php echo $files[$i] ?>">
                                            <a target="_blank" href="<?php echo base_url() ?>assets/uploads/advertisement_images/<?php echo $files[$i] ?>">
                                                <img alt="" border="0" src="<?php echo base_url(); ?>assets/uploads/advertisement_images/<?php echo $files[$i] ?>" width="<?php echo $w ?>" />
                                            </a>
                                            <!--&nbsp;position&nbsp;<input type="text" name="image_position[]" size="5" maxlength="2" value="<?php// echo $order ?>" />-->
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
                                        $balance_files = 1 - $num_of_uploaded_files;
                                        //$balance_files = 1;
                                ?>
                            </td>
                        </tr>
                    </table>	
                </div>
                <div id="uploading_status"><p></p></div>
                <div id="upload_panel" <?php if ($balance_files == 0) : ?>style="display:none;"<?php endif ?>>
                    <p><strong>Image&nbsp;</strong>[ Maximum 5 files are allowed. Maximum filesize: 2MB. Allowed image files: .jpg, .gif ]</p>
                    <input id="image_input" name="image_input" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:$('#image_input').uploadifyUpload();">Upload Files</a> | <a href="javascript:$('#image_input').uploadifyClearQueue();">Clear Queue</a>
                </div>
            </div>
            <br>
            <p>
                <?php echo form_input(array('name' => 'num_of_files', 'id' => 'num_of_files', 'style' => 'display:none;', 'value' => $balance_files)) ?>
                <?php echo form_input(array('name' => 'num_of_files_uploaded', 'id' => 'num_of_files_uploaded', 'style' => 'display:none;', 'value' => 0)) ?>
                <?php echo form_input(array('name' => 'images', 'id' => 'images', 'style' => 'display:none;', 'value' => $images)) ?>               
				
				<?php echo form_submit(array('name' => 'submit_advertisement_input', 'id' => 'submit_advertisement_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>