<?php
/* Smarty version 3.1.40, created on 2022-04-08 22:38:19
  from '/var/www/html/content/themes/default/templates/ajax.chat.conversation.messages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_6250b95b583187_45015380',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ef393f8a6726180518350b046c72a63379957e2' => 
    array (
      0 => '/var/www/html/content/themes/default/templates/ajax.chat.conversation.messages.tpl',
      1 => 1649371894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:ajax.chat.messages.tpl' => 1,
  ),
),false)) {
function content_6250b95b583187_45015380 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['conversation']->value['total_messages'] >= $_smarty_tpl->tpl_vars['system']->value['max_results']) {?>
	<!-- see-more -->
	<div class="alert alert-chat see-more small js_see-more" data-id=<?php echo $_smarty_tpl->tpl_vars['conversation']->value['conversation_id'];?>
  data-get="messages">
	    <span><?php echo __("Loading Older Messages");?>
</span>
	    <div class="loader loader_small x-hidden"></div>
	</div>
	<!-- see-more -->
<?php }?>

<ul>
    <?php $_smarty_tpl->_subTemplateRender('file:ajax.chat.messages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('messages'=>$_smarty_tpl->tpl_vars['conversation']->value['messages']), 0, false);
?>
</ul><?php }
}
