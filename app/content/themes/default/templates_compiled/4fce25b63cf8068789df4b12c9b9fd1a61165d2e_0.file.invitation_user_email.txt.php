<?php
/* Smarty version 3.1.40, created on 2022-04-07 13:09:45
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/emails/invitation_user_email.txt' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624ee2997b14b8_14594548',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4fce25b63cf8068789df4b12c9b9fd1a61165d2e' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/emails/invitation_user_email.txt',
      1 => 1638116302,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_624ee2997b14b8_14594548 (Smarty_Internal_Template $_smarty_tpl) {
echo __("Hi");?>
,

<?php echo __("Your friend");?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->_data['name'];?>
 <?php echo __("invite you to our website");?>
 <?php echo $_smarty_tpl->tpl_vars['system']->value['system_title'];?>


<?php echo __("To complete the registration process, please follow this link");?>
:
<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/signup?ref=<?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_name'];?>
&invitation_code=<?php echo $_smarty_tpl->tpl_vars['code']->value;?>


<?php echo $_smarty_tpl->tpl_vars['system']->value['system_title'];?>
 <?php echo __("Team");
}
}
