<?php if ($this->session->flashdata('success_message')): ?>
    <div class="notification success png_bg">
        <div><?php echo $this->session->flashdata('success_message') ?></div>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('error_message')): ?>
    <div class="notification error png_bg">
        <div><?php echo $this->session->flashdata('error_message') ?></div>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('attention_message')): ?>
    <div class="notification attention png_bg">
        <div><?php echo $this->session->flashdata('attention_message') ?></div>
    </div>
<?php endif ?>
<?php if (isset($notifications)): ?>
    <?php echo $notifications ?>
<?php endif ?>