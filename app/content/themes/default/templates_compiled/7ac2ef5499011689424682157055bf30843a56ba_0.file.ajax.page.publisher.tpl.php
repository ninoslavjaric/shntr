<?php
/* Smarty version 3.1.40, created on 2022-04-07 10:01:59
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/ajax.page.publisher.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624eb6974a4273_62164293',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ac2ef5499011689424682157055bf30843a56ba' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/ajax.page.publisher.tpl',
      1 => 1638116302,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__categories.recursive_options.tpl' => 1,
    'file:__custom_fields.tpl' => 1,
  ),
),false)) {
function content_624eb6974a4273_62164293 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
    <h6 class="modal-title">
        <i class="fa fa-flag mr10" style="color: #2196f3;"></i><?php echo __("Create New Page");?>

    </h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="js_ajax-forms" data-url="pages_groups_events/create.php?type=page&do=create">
    <div class="modal-body">
        <div class="form-group">
            <label class="form-control-label" for="title"><?php echo __("Name Your Page");?>
</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
        <div class="form-group">
            <label class="form-control-label" for="username"><?php echo __("Page Username");?>
</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text d-none d-sm-block"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/</span>
                </div>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <span class="form-text">
                <?php echo __("Can only contain alphanumeric characters (A–Z, 0–9) and periods ('.')");?>

            </span>
        </div>
        <div class="form-group">
            <label class="form-control-label" for="category"><?php echo __("Category");?>
</label>
            <select class="form-control" name="category" id="category">
                <option><?php echo __("Select Category");?>
</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-control-label" for="description"><?php echo __("About");?>
</label>
            <textarea class="form-control" name="description" name="description"></textarea>
        </div>
        <!-- custom fields -->
        <?php if ($_smarty_tpl->tpl_vars['custom_fields']->value) {?>
        <?php $_smarty_tpl->_subTemplateRender('file:__custom_fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_custom_fields'=>$_smarty_tpl->tpl_vars['custom_fields']->value,'_registration'=>true), 0, false);
?>
        <?php }?>
        <!-- custom fields -->
        <!-- error -->
        <div class="alert alert-danger mb0 mt10 x-hidden"></div>
        <!-- error -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo __("Cancel");?>
</button>
        <button type="submit" class="btn btn-primary"><?php echo __("Create");?>
</button>
    </div>
</form><?php }
}
