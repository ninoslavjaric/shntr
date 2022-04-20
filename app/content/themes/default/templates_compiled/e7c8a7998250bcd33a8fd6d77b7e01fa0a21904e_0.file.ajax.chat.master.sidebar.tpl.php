<?php
/* Smarty version 3.1.40, created on 2022-04-08 22:23:54
  from '/var/www/html/content/themes/default/templates/ajax.chat.master.sidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_6250b5fa0801b2_76803195',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7c8a7998250bcd33a8fd6d77b7e01fa0a21904e' => 
    array (
      0 => '/var/www/html/content/themes/default/templates/ajax.chat.master.sidebar.tpl',
      1 => 1649371889,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6250b5fa0801b2_76803195 (Smarty_Internal_Template $_smarty_tpl) {
?><ul>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebar_friends']->value, '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
        <li class="feeds-item">
            <div class="data-container clickable small js_chat-start" data-uid="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_id'];?>
" data-name="<?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['_user']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_lastname'];
}?>" data-link="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];?>
">
                <div class="data-avatar">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_picture'];?>
" alt="">
                </div>
                <div class="data-content">
                    <div class="float-right">
                        <i class="fa fa-circle <?php if ($_smarty_tpl->tpl_vars['_user']->value['user_is_online']) {?>online<?php } else { ?>offline<?php }?>"></i>
                    </div>
                    <div>
                        <strong>
                            <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['_user']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_lastname'];
}?>
                        </strong>
                        <?php if ($_smarty_tpl->tpl_vars['system']->value['chat_status_enabled'] && !$_smarty_tpl->tpl_vars['_user']->value['user_is_online']) {?>
                            <br>
                            <small>
                                <?php ob_start();
echo __("Last Seen");
$_prefixVariable1 = ob_get_clean();
echo $_prefixVariable1;?>
 <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_last_seen'];?>
"><?php echo $_smarty_tpl->tpl_vars['_user']->value['user_last_seen'];?>
</span>
                            </small>
                        <?php }?>
                    </div>
                </div>
            </div>
        </li>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</ul><?php }
}
