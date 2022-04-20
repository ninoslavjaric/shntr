<?php
/* Smarty version 3.1.40, created on 2022-04-07 11:48:09
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/ajax.lightbox.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624ecf798ba784_74688824',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '18efdd7b9a7a4742a19d62449403cd99299c2c9d' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/ajax.lightbox.tpl',
      1 => 1638116302,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__feeds_post_photo.tpl' => 1,
  ),
),false)) {
function content_624ecf798ba784_74688824 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('post', $_smarty_tpl->tpl_vars['photo']->value['post']);?>

<div class="lightbox-post" data-id="<?php if ($_smarty_tpl->tpl_vars['photo']->value['is_single']) {
echo $_smarty_tpl->tpl_vars['post']->value['post_id'];
} else {
echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];
}?>">
	<div class="js_scroller" data-slimScroll-height="100%">
        <?php $_smarty_tpl->_subTemplateRender('file:__feeds_post_photo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_lightbox'=>true), 0, false);
?>
	</div>
</div><?php }
}
