<?php
/* Smarty version 3.1.40, created on 2022-04-07 04:50:58
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/admin.coinpayments.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624e6db2650a63_10423352',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9689f2aa15d5b270a26d3fe6d3b7a9fafdc62f4b' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/admin.coinpayments.tpl',
      1 => 1638116302,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_624e6db2650a63_10423352 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="card">
    <div class="card-header with-icon">
        <i class="fab fa-bitcoin mr10"></i><?php echo __("CoinPayments Transactions");?>

    </div>

    <div class="card-body">

        <?php if (!$_smarty_tpl->tpl_vars['system']->value['coinpayments_enabled']) {?>
            <div class="alert alert-warning">
                <div class="icon">
                    <i class="fa fa-exclamation-triangle fa-2x"></i>
                </div>
                <div class="text pt5">
                    <?php echo __("CoinPayments is disabled");?>
, <?php echo __("Make sure you have configured");?>
 <a class="alert-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/settings/payments"><?php echo __("Payments Settings");?>
</a>
                </div>
            </div>
        <?php }?>

        <div class="alert alert-info">
            <div class="icon">
                <i class="fa fa-info-circle fa-2x"></i>
            </div>
            <div class="text pt5">
                <?php echo __("You can visit your CoinPayments account to see the transactions in more details");?>

            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover js_dataTable">
                <thead>
                    <tr>
                        <th><?php echo __("TXN_ID");?>
</th>
                        <th><?php echo __("User");?>
</th>
                        <th><?php echo __("Product");?>
</th>
                        <th><?php echo __("Amount");?>
</th>
                        <th><?php echo __("Created");?>
</th>
                        <th><?php echo __("Updated");?>
</th>
                        <th><?php echo __("Status");?>
</th>
                        <th><?php echo __("Status Message");?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['coinpayments_transactions']->value, 'transaction');
$_smarty_tpl->tpl_vars['transaction']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaction']->value) {
$_smarty_tpl->tpl_vars['transaction']->do_else = false;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['transaction']->value['transaction_txn_id'];?>
</td>
                            <td>
                                <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['transaction']->value['user_name'];?>
">
                                    <img class="tbl-image" src="<?php echo $_smarty_tpl->tpl_vars['transaction']->value['user_picture'];?>
">
                                    <br>
                                    <span class="badge badge-pill badge-lg badge-light">
                                        <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['transaction']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['transaction']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['transaction']->value['user_lastname'];
}?>
                                    </span>
                                </a>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['transaction']->value['product'];?>
</td>
                            <td><?php echo print_money($_smarty_tpl->tpl_vars['transaction']->value['amount']);?>
</td>
                            <td>
                                <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['transaction']->value['created_at'];?>
"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['created_at'];?>
</span>
                            </td>
                            <td>
                                <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['transaction']->value['last_update'];?>
"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['last_update'];?>
</span>
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['transaction']->value['status'] == '-1') {?>
                                    <span class="badge badge-pill badge-lg badge-danger"><?php echo __("Error");?>
</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['transaction']->value['status'] == '0') {?>
                                    <span class="badge badge-pill badge-lg badge-info"><?php echo __("Processing");?>
</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['transaction']->value['status'] == '1') {?>
                                    <span class="badge badge-pill badge-lg badge-warning"><?php echo __("Pending");?>
</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['transaction']->value['status'] == '2') {?>
                                    <span class="badge badge-pill badge-lg badge-success"><?php echo __("Complete");?>
</span>
                                <?php }?>
                            </td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['transaction']->value['status_message'];?>

                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        </div>
    </div>

</div><?php }
}
