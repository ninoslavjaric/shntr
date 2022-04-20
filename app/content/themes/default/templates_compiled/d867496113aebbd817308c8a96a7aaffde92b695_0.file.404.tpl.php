<?php
/* Smarty version 3.1.40, created on 2022-04-17 00:23:31
  from '/var/www/html/content/themes/default/templates/404.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_625b5e03942879_55874039',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd867496113aebbd817308c8a96a7aaffde92b695' => 
    array (
      0 => '/var/www/html/content/themes/default/templates/404.tpl',
      1 => 1649371885,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_625b5e03942879_55874039 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
<div class="container mt20 offcanvas">
	<div class="row">

		<!-- side panel -->
		<div class="col-12 d-block d-sm-none offcanvas-sidebar">
			<?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		</div>
        <!-- side panel -->

        <!-- content panel -->
	    <div class="col-12 offcanvas-mainbar">
    		<div class="notfound-wrapper">
				<div class="notfound">
					<div class="notfound-circle">
						<i class="far fa-frown"></i>
					</div>
					<h1>404</h1>
					<h2><?php echo __("Oops! Page Not Be Found");?>
</h2>
					<p class="mt10"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
					<a class="btn btn-primary rounded-pill" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
"><?php echo __("Back to homepage");?>
</a>
				</div>
			</div>
	    </div>
	    <!-- content panel -->
		
	</div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
