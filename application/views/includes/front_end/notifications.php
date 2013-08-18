<?php if ($this->session->flashdata('success_message')): ?>
    <div class="success">
        <div><?php echo $this->session->flashdata('success_message') ?></div>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('error_message')): ?>
    <div class="error">
        <div><?php echo $this->session->flashdata('error_message') ?></div>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('warning_message')): ?>
    <div class="warning">
        <div><?php echo $this->session->flashdata('warning_message') ?></div>
    </div>
<?php endif ?>
<?php if (isset($notifications)): ?>
    <?php echo $notifications ?>
<?php endif ?>


<?php if (isset($success)): ?>
    <div class="success">
        <div><?php echo $success_message ?></div>
    </div>
<?php endif ?>

<?php if (isset($error)): ?>
    <div class="error">
        <div><?php echo $error_message ?></div>
    </div>
<?php endif ?>

<?php if (isset($warning)): ?>
    <div class="error">
        <div><?php echo $warning_message ?></div>
    </div>
<?php endif ?>