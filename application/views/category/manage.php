<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('category/manage/' . $id, array('id' => 'stock_input_form')) ?>
    <?php else : ?>
        <?php echo form_open('category/manage', array('id' => 'stock_input_form')) ?>
    <?php endif ?>
        
       <fieldset>
            <p>
                <label for="name">Category Name </label> 
                <?php echo form_input(array('name' => 'name', 'id' => 'name', 'class' => 'text-input small-input', 'maxlength' => '100', 'value' => isset($name) ? $name : set_value('name'))) ?>
                <?php echo form_error('name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label>Product Section</label>
                <?php foreach ($sections as $sec): ?>
                    <?php $section_options[$sec->id] = ucfirst($sec->name) ?>
                <?php endforeach ?>
                <?php if (isset($product_section_id)) : ?>
                    <?php echo form_dropdown('product_section_id', $section_options, $product_section_id, 'class=""') ?>
                <?php else : ?>
                    <?php echo form_dropdown('product_section_id', $section_options, '0', 'class=""') ?>
                <?php endif ?>
            </p>

            <p>
                <?php echo form_submit(array('name' => 'submit_stock_input', 'id' => 'submit_stock_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>