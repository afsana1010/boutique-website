<div class="content-box-header">
    <h3><?php echo $form_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
        <?php if ($action == 'edit'): ?>    
            <?php echo form_open('product_section/manage/' . $id, array('id' => 'section_input_form')) ?>
        <?php else : ?>
            <?php echo form_open('product_section/manage', array('id' => 'section_input_form')) ?>
        <?php endif ?>
        <?php echo form_hidden('base_url', base_url()) ?>

        <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label for="name">Section Name </label> 
                <?php echo form_input(array('name' => 'name', 'id' => 'name', 'class' => 'text-input small-input', 'maxlength' => '30', 'value' => isset($name) ? $name : set_value('name'))) ?>
                <?php echo form_error('name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="is_active">Section Status </label>
                <?php if ($action == 'edit'): ?> 
                    <?php $check_active   = ($is_active == 0) ? FALSE : TRUE ?>
                    <?php $check_inactive = ($is_active == 1) ? FALSE : TRUE ?>
                <?php else: ?>
                    <?php $check_active   = FALSE ?>
                    <?php $check_inactive = TRUE ?>
                <?php endif ?>

                <?php echo form_radio(array('name' => 'is_active', 'id' => 'is_active', 'value' => '1', 'checked' => $check_active)) . '&nbsp;Active&nbsp;&nbsp;' ?>
                <?php echo form_radio(array('name' => 'is_active', 'id' => 'is_active', 'value' => '0', 'checked' => $check_inactive)) . 'Inactive' ?>
            </p>

            <p>        
                <?php echo form_submit(array('name' => 'submit_section_input', 'id' => 'submit_section_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     

        <div class="clear"></div><!-- End .clear -->

<?php echo form_close() ?>
    </div>        
</div>