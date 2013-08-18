<div class="content-box column-left">
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo $table_title ?> from <?php echo date('F j, Y', strtotime($from_date)) ?> to <?php echo date('F j, Y', strtotime($to_date)) ?></h3>
    </div> <!-- End .content-box-header -->
    
    <div class="content-box-content">
        <div class="tab-content default-tab" style="display: block;">
            <h4 style="color:green; font-weight:bold;">INCOME</h4>
            <hr />
            <table style="color:green;">
                <tr class="info">
                    <td>&nbsp;</td><td>&nbsp;</td>
                </tr>
                
                <?php if(isset($product_sold)): ?>
                <?php $total_income = $product_sold['sold_amount']; ?>
                <tr class="info">
                    <td>Product Sold</td><td><?php echo 'S$ ' . number_format($total_income, 2, '.', '') ?></td>
                </tr>
                <?php endif ?>
                
                <tr class="info">
                    <td>&nbsp;</td><td>&nbsp;</td>
                </tr>
                <tr class="info">
                    <td align="right">TOTAL INCOME</td>
                    <td>
                        <strong style="color:green;"><?php echo 'S$ ' . number_format($total_income, 2, '.', '') ?></strong>
                    </td>
                </tr>
            </table>
            <br /><br />
            
            <h4 style="color:red; font-weight:bold;">EXPENSES</h4>
            <hr />
            <table style="color:red;">
                <?php $total_expenses   = 0.0 ?>
                <?php $overall_total    = 0.0 ?>
                <?php $general_expenses = 0.0 ?>
                <?php $other_expenses   = 0.0 ?>
                <?php if (isset($general_payment)): ?>
                    <?php foreach ($general_payment as $gp): ?>
                        <tr class="info">
                            <td>Product Bought</td><td><?php echo $gp['general_payment'] ?></td>
                        </tr>
                        <?php $general_expenses = $general_expenses + $gp['general_payment'] ?>
                   <?php endforeach ?>
                <?php endif ?>
                <?php if (isset($expenses)): ?>
                    <?php foreach ($expenses as $exp): ?>
                        <?php $other_expenses = $other_expenses + $exp['expense_amount']; ?>
                        <tr class="info">
                            <td>
                                <?php echo $exp['expense_name'] ?>
                            </td>
                            <td>
                                <?php echo 'S$ ' . number_format($exp['expense_amount'], 2, '.', '') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif ?>
                <tr class="info">
                    <td>&nbsp;</td><td>&nbsp;</td>
                </tr>
                <?php $total_expenses = $general_expenses + $other_expenses ?>
                <tr class="info">
                    <td>TOTAL EXPENSES</td>
                    <td><strong style="color:red;"><?php echo 'S$ ' . number_format($total_expenses, 2, '.', '') ?></strong></td>
                </tr>			
                <tr class="info">
                    <td>&nbsp;</td><td>&nbsp;</td>
                </tr>
            </table>
            <?php $overall_total = $total_income - $total_expenses ?>
            <table>
                <tr class="info" style="font-weight:bold;">
                    <td><strong>OVERALL TOTAL</strong></td>
                    <td><strong><?php echo 'S$ ' . number_format($overall_total, 2, '.', '') ?></strong></td>
                </tr>
            </table>
        </div> <!-- End #tab3 -->        
    </div> <!-- End .content-box-content -->

    
</div>