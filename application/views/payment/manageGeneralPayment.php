<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php echo form_hidden('base_url', base_url()) ?>
    <?php 
		if ($action == 'edit')
		{ 
			echo form_open_multipart('payment/manageGeneralPayment/' . $id, array('id' => 'general_payment_input_form'));
			echo form_hidden('action', 'edit'); 
			echo form_hidden('payment_mode', $mode_of_payment); 
			if($mode_of_payment == 'paypal') 
			{
				$paypals_panel="style='background-color:#cccccc;'";
				$cheques_panel="style='display:none;'";
			}
			elseif($mode_of_payment == 'cheque') 
			{
				$cheques_panel="style='background-color:#cccccc;'";
				$paypals_panel="style='display:none;'";
			}
			else {
				$paypals_panel="style='display:none;'";
				$cheques_panel="style='display:none;'";
			}
		}
		 else 
		{ 
			echo form_open_multipart('payment/manageGeneralPayment', array('id' => 'general_payment_input_form')); 
			$paypals_panel="style='display:none;'";$cheques_panel="style='display:none;'";
		} 
	?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label>Select Product Stock</label>
                <?php foreach ($stocks as $s): ?>
                    <?php $stock_options[$s->id] = $s->bill_no ?>
                <?php endforeach ?>
                <?php if (isset($product_stock_id)) : ?>
                    <?php echo form_dropdown('product_stock_id', $stock_options, $product_stock_id, 'class="small-input"') ?>
                <?php else : ?>
                    <?php echo form_dropdown('product_stock_id', $stock_options, '0', 'class="small-input"') ?>
                <?php endif ?>
            </p>

            <p>
                <label for="amount">Amount</label>
                <?php echo form_input(array('name' => 'amount', 'id' => 'amount', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($amount) ? $amount : set_value('amount'))) ?>
                <?php echo form_error('amount', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="payment_date">Payment Date</label>
                <?php echo form_input(array('name' => 'payment_date', 'id' => 'payment_date', 'class' => 'text-input small-input', 'readonly'=>'readonly', 'maxlength' => '60', 'value' => isset($payment_date) ? $payment_date : set_value('payment_date'))) ?>
                <?php echo form_error('payment_date', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			
			<p>
                <label for="mode_of_payment">Mode of Payment</label>
				<?php 
					if(isset($mode_of_payment)=='cash') $selected='selected="selected"';
					elseif(isset($mode_of_payment)=='cheque')  $selected='selected="selected"';
					//elseif(isset($mode_of_payment)=='paypal')  $selected='selected="selected"';
					elseif(isset($mode_of_payment)=='other')  $selected='selected="selected"';
					else $selected='';
				?>
				<select name="mode_of_payment" class="small-input" id="mode_of_payment">					
					<option value="cash"  <?php echo $selected;?>>Cash</option>
					<option value="cheque"<?php echo $selected;?>>Cheque</option>
					<!--<option value="paypal"<?php echo $selected;?>>Paypal</option>-->
					<option value="other" <?php echo $selected;?>>Other</option>
				</select>				
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
                    <?php echo form_input(array('name' => 'cheque_issue_date', 'id' => 'cheque_issue_date', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($cheque_issue_date) ? $cheque_issue_date : set_value('cheque_issue_date'))) ?>
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
                    <?php echo form_input(array('name' => 'paytime', 'id' => 'paytime', 'class' => 'text-input small-input', 'maxlength' => '100','value' => isset($paytime) ? $paytime : set_value('paytime'))) ?>
                    <?php echo form_error('paytime', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>	
            </div>
            <!-- ends paypals inputs -->	
			
			<p>
				<?php echo form_submit(array('name' => 'submit_other_payment_input', 'id' => 'submit_other_payment_input', 'class' => 'button'), 'Submit') ?>
			</p>
		</fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>