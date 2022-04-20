<?php
/* Smarty version 3.1.40, created on 2022-04-08 22:39:07
  from '/var/www/html/content/themes/default/templates/__feeds_photo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_6250b98bee6c98_11721499',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '19a61f7d72e69b8de105a5ac28349c0e3cdc2fae' => 
    array (
      0 => '/var/www/html/content/themes/default/templates/__feeds_photo.tpl',
      1 => 1649371893,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6250b98bee6c98_11721499 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="<?php if ($_smarty_tpl->tpl_vars['_small']->value) {?>col-4<?php } else { ?>col-6 col-md-4 col-lg-2<?php }?> <?php if ($_smarty_tpl->tpl_vars['photo']->value['blur']) {?>x-blured<?php }?>">
    <a class="pg_photo <?php if (!$_smarty_tpl->tpl_vars['_small']->value) {?>large<?php }?> js_lightbox" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/photos/<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-image="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['photo']->value['source'];?>
" data-context="<?php echo $_smarty_tpl->tpl_vars['_context']->value;?>
" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['photo']->value['source'];?>
);">
    	<?php if (!$_smarty_tpl->tpl_vars['_small']->value && ($_smarty_tpl->tpl_vars['_manage']->value || $_smarty_tpl->tpl_vars['photo']->value['manage'])) {?>
	    	<div class="pg_photo-btn">
	            <button type="button" class="close js_delete-photo" data-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-toggle="tooltip" data-placement="top" title='<?php echo __("Delete");?>
'>
	                <span aria-hidden="true">&times;</span>
	            </button>
	        </div>
        <?php }?>
    </a>
</div><?php }
}
