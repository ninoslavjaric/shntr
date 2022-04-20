<?php
/* Smarty version 3.1.40, created on 2022-04-07 07:27:08
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/group.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624e924c8c8e91_00572344',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ab8053b519f9400c8f4e758dd1222cea7b8feb93' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/group.tpl',
      1 => 1644002934,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:__feeds_user.tpl' => 6,
    'file:__feeds_photo.tpl' => 2,
    'file:_publisher.tpl' => 1,
    'file:_pinned_post.tpl' => 1,
    'file:_posts.tpl' => 2,
    'file:__feeds_album.tpl' => 1,
    'file:_album.tpl' => 1,
    'file:__feeds_video.tpl' => 1,
    'file:__categories.recursive_options.tpl' => 1,
    'file:__custom_fields.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_624e924c8c8e91_00572344 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
<div class="container offcanvas">
    <div class="row">

        <!-- side panel -->
        <div class="col-12 col-md-4 col-lg-3 d-block d-sm-none d-md-block offcanvas-sidebar mt20 js_sticky-sidebar">
            <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        </div>
        <!-- side panel -->

        <!-- content panel -->
        <div class="col-12 col-md-8 col-lg-9 offcanvas-mainbar">
            <!-- profile-header -->
            <div class="profile-header">
                <!-- profile-cover -->
                <div class="profile-cover-wrapper">
                    <?php if ($_smarty_tpl->tpl_vars['group']->value['group_cover_id']) {?>
                        <!-- full-cover -->
                        <img class="js_position-cover-full x-hidden" src="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_cover_full'];?>
">
                        <!-- full-cover -->
                        
                        <!-- cropped-cover -->
                        <img class="js_position-cover-cropped js_lightbox" data-init-position="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_cover_position'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_cover_id'];?>
" data-image="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_cover_full'];?>
" data-context="album" src="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_cover'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
">
                        <!-- cropped-cover -->
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>
                        <!-- buttons -->
                        <div class="profile-cover-buttons">
                            <div class="profile-cover-change">
                                <i class="fa fa-camera js_x-uploader" data-handle="cover-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"></i>
                            </div>
                            <div class="profile-cover-position <?php if (!$_smarty_tpl->tpl_vars['group']->value['group_cover']) {?>x-hidden<?php }?>">
                                <input class="js_position-picture-val" type="hidden" name="position-picture-val">
                                <i class="fa fa-crop-alt js_init-position-picture" data-handle="group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"></i>
                            </div>
                            <div class="profile-cover-position-buttons">
                                <i class="fa fa-check fa-fw js_save-position-picture"></i>
                            </div>
                            <div class="profile-cover-position-buttons">
                                <i class="fa fa-times fa-fw js_cancel-position-picture"></i>
                            </div>
                            <div class="profile-cover-delete <?php if (!$_smarty_tpl->tpl_vars['group']->value['group_cover']) {?>x-hidden<?php }?>">
                                <i class="fa fa-trash js_delete-cover" data-handle="cover-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"></i>
                            </div>
                        </div>

                        <!-- loaders -->
                        <div class="profile-cover-change-loader">
                            <div class="progress x-progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="profile-cover-position-loader">
                            <i class="fa fa-arrows-alt mr5"></i><?php echo __("Drag to reposition cover");?>

                        </div>
                        <!-- loaders -->
                    <?php }?>
                </div>
                <!-- profile-cover -->

                <!-- profile-avatar -->
                <div class="profile-avatar-wrapper">
                    <img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_picture_id']) {?> class="js_lightbox" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_picture_id'];?>
" data-context="album" data-image="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_picture_full'];?>
" <?php } elseif (!$_smarty_tpl->tpl_vars['group']->value['group_picture_default']) {?> class="js_lightbox-nodata" data-image="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_picture'];?>
" <?php }?>  src="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_picture'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
">
                    
                    <?php if ($_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>
                        <!-- buttons -->
                        <div class="profile-avatar-change">
                            <i class="fa fa-camera js_x-uploader" data-handle="picture-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"></i>
                        </div>
                        <div class="profile-avatar-crop <?php if ($_smarty_tpl->tpl_vars['group']->value['group_picture_default']) {?>x-hidden<?php }?>">
                            <i class="fa fa-crop-alt js_init-crop-picture" data-image="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_picture_full'];?>
" data-handle="group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"></i>
                        </div>
                        <div class="profile-avatar-delete <?php if ($_smarty_tpl->tpl_vars['group']->value['group_picture_default']) {?>x-hidden<?php }?>">
                            <i class="fa fa-trash js_delete-picture" data-handle="picture-group"></i>
                        </div>
                        <!-- buttons -->
                        <!-- loaders -->
                        <div class="profile-avatar-change-loader">
                            <div class="progress x-progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!-- loaders -->
                    <?php }?>
                </div>
                <!-- profile-avatar -->

                <!-- profile-name -->
                <div class="profile-name-wrapper">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
</a>
                    <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "public") {?>
                        <i data-toggle="tooltip" data-placement="top" title='<?php echo __("Public Group");?>
' class="fa fa-globe fa-fw privacy-badge"></i>
                    <?php } elseif ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "closed") {?>
                        <i data-toggle="tooltip" data-placement="top" title='<?php echo __("Closed Group");?>
' class="fa fa-unlock-alt fa-fw privacy-badge"></i>
                    <?php } elseif ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "secret") {?>
                        <i data-toggle="tooltip" data-placement="top" title='<?php echo __("Secret Group");?>
' class="fa fa-lock fa-fw privacy-badge"></i>
                    <?php }?>
                </div>
                <!-- profile-name -->

                <!-- profile-buttons -->
                <div class="profile-buttons-wrapper">
                    <?php if ($_smarty_tpl->tpl_vars['group']->value['i_joined'] == "approved") {?>
                        <button type="button" class="btn btn-sm btn-success btn-delete js_leave-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
" data-privacy="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_privacy'];?>
">
                            <i class="fa fa-check mr5"></i><?php echo __("Joined");?>

                        </button>
                    <?php } elseif ($_smarty_tpl->tpl_vars['group']->value['i_joined'] == "pending") {?>
                        <button type="button" class="btn btn-sm btn-warning js_leave-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
" data-privacy="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_privacy'];?>
">
                            <i class="fa fa-clock mr5"></i><?php echo __("Pending");?>

                        </button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-sm btn-success js_join-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
" data-privacy="<?php if ($_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>public<?php } else {
echo $_smarty_tpl->tpl_vars['group']->value['group_privacy'];
}?>">
                            <i class="fa fa-user-plus mr5"></i><?php echo __("Join");?>

                        </button>
                    <?php }?>
                    
                    <?php if (!$_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>
                        <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
                            <!-- report -->
                            <div class="d-inline-block dropdown ml5">
                                <button type="button" class="btn btn-icon btn-rounded btn-light" data-toggle="dropdown" data-display="static">
                                    <i class="fa fa-ellipsis-v fa-fw"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- report -->
                                    <div class="dropdown-item pointer js_report" data-handle="group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                        <i class="fa fa-flag fa-fw mr10"></i><?php echo __("Report");?>

                                    </div>
                                    <!-- report -->
                                    <!-- manage -->
                                    <?php if ($_smarty_tpl->tpl_vars['user']->value->_is_admin) {?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/admincp/groups/edit_group/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                            <i class="fa fa-cog fa-fw mr10"></i><?php echo __("Edit in Admin Panel");?>

                                        </a>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['user']->value->_is_moderator) {?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/modcp/groups/edit_group/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                            <i class="fa fa-cog fa-fw mr10"></i><?php echo __("Edit in Moderator Panel");?>

                                        </a>
                                    <?php }?>
                                    <!-- manage -->
                                </div>
                            </div>
                            <!-- report -->
                        <?php }?>
                    <?php }?>
                </div>
                <!-- profile-buttons -->

                <!-- profile-tabs -->
                <div class="profile-tabs-wrapper narrow custom-scrollbar">
                    <ul>
                        <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "closed" && $_smarty_tpl->tpl_vars['group']->value['i_joined'] != "approved" && !$_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>
                            <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
">
                                    <i class="fa fa-info-circle fa-fw mr5"></i><?php echo __("About");?>

                                </a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
" <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>class="active"<?php }?>>
                                    <i class="fa fa-newspaper fa-fw mr5"></i><?php echo __("Timeline");?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/photos" <?php if ($_smarty_tpl->tpl_vars['view']->value == "photos" || $_smarty_tpl->tpl_vars['view']->value == "albums" || $_smarty_tpl->tpl_vars['view']->value == "album") {?>class="active"<?php }?>>
                                    <i class="fa fa-images fa-fw mr5"></i><?php echo __("Photos");?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/videos" <?php if ($_smarty_tpl->tpl_vars['view']->value == "videos") {?>class="active"<?php }?>>
                                    <i class="fa fa-video fa-fw mr5"></i><?php echo __("Videos");?>

                                </a>
                            </li>
                            <?php if (!$_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/members" <?php if ($_smarty_tpl->tpl_vars['view']->value == "members" || $_smarty_tpl->tpl_vars['view']->value == "invites") {?>class="active"<?php }?>>
                                        <i class="fa fa-users fa-fw mr5"></i><?php echo __("Members");?>

                                    </a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/settings" <?php if ($_smarty_tpl->tpl_vars['view']->value == "settings") {?>class="active"<?php }?>>
                                        <i class="fa fa-cog"></i> <?php echo __("Settings");?>

                                    </a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
                <!-- profile-tabs -->
            </div>
            <!-- profile-header -->

            <!-- profile-content -->
            <div class="row">
                <!-- view content -->
                <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>

                    <!-- right panel -->
                    <div class="order-1 col-lg-4 order-lg-2">
                        <!-- panel [about] -->
                        <div class="card">
                            <div class="card-body">
                                <?php if (!is_empty($_smarty_tpl->tpl_vars['group']->value['group_description'])) {?>
                                    <div class="about-bio">
                                        <div class="js_readmore overflow-hidden">
                                            <?php echo $_smarty_tpl->tpl_vars['group']->value['group_description'];?>

                                        </div>
                                    </div>
                                <?php }?>
                                <ul class="about-list">
                                    <!-- privacy -->
                                    <li>
                                        <div class="about-list-item">
                                            <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "public") {?>
                                                <i class="fa fa-globe fa-fw fa-lg"></i>
                                                <?php echo __("Public Group");?>

                                            <?php } elseif ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "closed") {?>
                                                <i class="fa fa-unlock-alt fa-fw fa-lg"></i>
                                                <?php echo __("Closed Group");?>

                                            <?php } elseif ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "secret") {?>
                                                <i class="fa fa-lock fa-fw fa-lg"></i>
                                                <?php echo __("Secret Group");?>

                                            <?php }?>
                                        </div>
                                    </li>
                                    <!-- privacy -->
                                    <!-- members -->
                                    <li>
                                        <div class="about-list-item">
                                            <i class="fa fa-users fa-fw fa-lg"></i>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/members"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_members'];?>
 <?php echo __("members");?>
</a>
                                        </div>
                                    </li>
                                    <!-- members -->
                                    <!-- category -->
                                    <li>
                                        <div class="about-list-item">
                                            <i class="fa fa-tag fa-fw fa-lg"></i>
                                            <?php echo __($_smarty_tpl->tpl_vars['group']->value['group_category_name']);?>

                                        </div>
                                    </li>
                                    <!-- category -->
                                </ul>
                            </div>
                        </div>
                        <!-- panel [about] -->

                        <!-- custom fields [basic] -->
                        <?php if ($_smarty_tpl->tpl_vars['custom_fields']->value['basic']) {?>
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <i class="fa fa-info-circle mr5"></i>
                                    <strong><?php echo __("Info");?>
</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="about-list">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['custom_fields']->value['basic'], 'custom_field');
$_smarty_tpl->tpl_vars['custom_field']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['custom_field']->value) {
$_smarty_tpl->tpl_vars['custom_field']->do_else = false;
?>
                                            <?php if ($_smarty_tpl->tpl_vars['custom_field']->value['value']) {?>
                                                <li>
                                                    <strong><?php echo __($_smarty_tpl->tpl_vars['custom_field']->value['label']);?>
</strong><br>
                                                    <?php if ($_smarty_tpl->tpl_vars['custom_field']->value['type'] == "textbox" && $_smarty_tpl->tpl_vars['custom_field']->value['is_link']) {?>
                                                        <a href="<?php echo $_smarty_tpl->tpl_vars['custom_field']->value['value'];?>
"><?php echo $_smarty_tpl->tpl_vars['custom_field']->value['value'];?>
</a>
                                                    <?php } else { ?>
                                                        <?php echo $_smarty_tpl->tpl_vars['custom_field']->value['value'];?>

                                                    <?php }?>
                                                </li>
                                            <?php }?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>
                                </div>
                            </div>
                        <?php }?>
                        <!-- custom fields [basic] -->

                        <!-- invite friends -->
                        <?php if ($_smarty_tpl->tpl_vars['group']->value['i_joined'] == "approved" && $_smarty_tpl->tpl_vars['group']->value['invites']) {?>
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="float-right">
                                        <small><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/invites"><?php echo __("See All");?>
</a></small>
                                    </div>
                                    <i class="fa fa-user-tag mr5"></i>
                                    <strong><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/invites"><?php echo __("Invite Friends");?>
</a></strong>
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['invites'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                        <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"],'_small'=>true), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>
                                </div>
                            </div>
                        <?php }?>
                        <!-- invite friends -->

                        <!-- photos -->
                        <?php if ($_smarty_tpl->tpl_vars['group']->value['photos']) {?>
                            <div class="card panel-photos">
                                <div class="card-header bg-transparent">
                                    <i class="fa fa-images mr5"></i>
                                    <strong><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/photos"><?php echo __("Photos");?>
</a></strong>
                                </div>
                                <div class="card-body ptb10 plr10">
                                    <div class="row no-gutters">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['photos'], 'photo');
$_smarty_tpl->tpl_vars['photo']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['photo']->value) {
$_smarty_tpl->tpl_vars['photo']->do_else = false;
?>
                                            <?php $_smarty_tpl->_subTemplateRender('file:__feeds_photo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_context'=>"photos",'_small'=>true), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <!-- photos -->
                    </div>
                    <!-- right panel -->

                    <!-- left panel -->
                    <div class="order-2 col-lg-8 order-lg-1">
                        <!-- super admin alert -->
                        <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['user_group'] < 3 && ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "secret" || $_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "closed") && ($_smarty_tpl->tpl_vars['group']->value['i_joined'] != "approved" && !$_smarty_tpl->tpl_vars['group']->value['i_admin'])) {?>
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
                                <div class="icon"><i class="fa fa-info-circle fa-2x"></i></div>
                                <div class="text align-middle">
                                    <?php echo __("You can access this as your account is system admin account!");?>

                                </div>
                            </div>
                        <?php }?>
                        <!-- super admin alert -->

                        <?php if ($_smarty_tpl->tpl_vars['get']->value == "posts_group") {?>
                            <!-- group requests -->
                            <?php if ($_smarty_tpl->tpl_vars['group']->value['i_admin'] && $_smarty_tpl->tpl_vars['group']->value['total_requests'] > 0) {?>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
                                    <div class="icon"><i class="fa fa-users fa-lg"></i></div>
                                    <div class="text align-middle">
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/settings/requests" class="alert-link">
                                            <span class="badge badge-light mr5"><?php echo $_smarty_tpl->tpl_vars['group']->value['total_requests'];?>
</span><?php if ($_smarty_tpl->tpl_vars['group']->value['total_requests'] == 1) {
echo __("person");
} else {
echo __("persons");
}?> <?php echo __("wants to join this group");?>

                                        </a>
                                    </div>
                                </div>
                            <?php }?>
                            <!-- group requests -->

                            <!-- group pending posts -->
                            <?php if ($_smarty_tpl->tpl_vars['group']->value['pending_posts'] > 0) {?>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
                                    <div class="icon"><i class="fa fa-comments fa-lg"></i></div>
                                    <div class="text align-middle">
                                        <a href="?pending" class="alert-link">
                                            <?php if ($_smarty_tpl->tpl_vars['group']->value['i_admin']) {?>
                                                <span class="badge badge-light mr5"><?php echo $_smarty_tpl->tpl_vars['group']->value['pending_posts'];?>
</span><?php if ($_smarty_tpl->tpl_vars['group']->value['pending_posts'] == 1) {
echo __("post");
} else {
echo __("posts");
}?> <?php echo __("pending needs your approval");?>

                                            <?php } else { ?>
                                                <?php echo __("You have");?>
<span class="badge badge-light mlr5"><?php echo $_smarty_tpl->tpl_vars['group']->value['pending_posts'];?>
</span><?php if ($_smarty_tpl->tpl_vars['group']->value['pending_posts'] == 1) {
echo __("post");
} else {
echo __("posts");
}?> <?php echo __("pending");?>

                                            <?php }?>
                                        </a>
                                    </div>
                                </div>
                            <?php }?>
                            <!-- group pending posts -->

                            <!-- publisher -->
                            <?php if ($_smarty_tpl->tpl_vars['group']->value['i_joined'] == "approved" && ($_smarty_tpl->tpl_vars['group']->value['group_publish_enabled'] || (!$_smarty_tpl->tpl_vars['group']->value['group_publish_enabled'] && $_smarty_tpl->tpl_vars['group']->value['i_admin']))) {?>
                                <?php $_smarty_tpl->_subTemplateRender('file:_publisher.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_handle'=>"group",'_id'=>$_smarty_tpl->tpl_vars['group']->value['group_id']), 0, false);
?>
                            <?php }?>
                            <!-- publisher -->

                            <!-- pinned post -->
                            <?php if ($_smarty_tpl->tpl_vars['pinned_post']->value) {?>
                                <?php $_smarty_tpl->_subTemplateRender('file:_pinned_post.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('post'=>$_smarty_tpl->tpl_vars['pinned_post']->value,'_get'=>"posts_group"), 0, false);
?>
                            <?php }?>
                            <!-- pinned post -->

                            <!-- posts -->
                            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"posts_group",'_id'=>$_smarty_tpl->tpl_vars['group']->value['group_id']), 0, false);
?>
                            <!-- posts -->
                        <?php } else { ?>
                            <!-- posts -->
                            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>$_smarty_tpl->tpl_vars['get']->value,'_id'=>$_smarty_tpl->tpl_vars['group']->value['group_id'],'_title'=>__("Pending Posts")), 0, true);
?>
                            <!-- posts -->
                        <?php }?>
                    </div>
                    <!-- left panel -->
                
                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "photos") {?>
                    <!-- photos -->
                    <div class="col-12">
                        <div class="card panel-photos">
                            <div class="card-header with-icon with-nav">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-images mr10"></i><?php echo __("Photos");?>

                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/photos"><?php echo __("Photos");?>
</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/albums"><?php echo __("Albums");?>
</a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="card-body">
                                <?php if ($_smarty_tpl->tpl_vars['group']->value['photos']) {?>
                                    <ul class="row no-gutters">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['photos'], 'photo');
$_smarty_tpl->tpl_vars['photo']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['photo']->value) {
$_smarty_tpl->tpl_vars['photo']->do_else = false;
?>
                                            <?php $_smarty_tpl->_subTemplateRender('file:__feeds_photo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_context'=>"photos"), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>
                                    <!-- see-more -->
                                    <div class="alert alert-info see-more js_see-more" data-get="photos" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
" data-type='group'>
                                        <span><?php echo __("See More");?>
</span>
                                        <div class="loader loader_small x-hidden"></div>
                                    </div>
                                    <!-- see-more -->
                                <?php } else { ?>
                                    <p class="text-center text-muted mt10">
                                        <?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
 <?php echo __("doesn't have photos");?>

                                    </p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- photos -->
                
                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "albums") {?>
                    <!-- albums -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header with-icon with-nav">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-images mr10"></i><?php echo __("Photos");?>

                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/photos"><?php echo __("Photos");?>
</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/albums"><?php echo __("Albums");?>
</a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="card-body">
                                <?php if ($_smarty_tpl->tpl_vars['group']->value['albums']) {?>
                                    <ul class="row">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['albums'], 'album');
$_smarty_tpl->tpl_vars['album']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['album']->value) {
$_smarty_tpl->tpl_vars['album']->do_else = false;
?>
                                        <?php $_smarty_tpl->_subTemplateRender('file:__feeds_album.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>
                                    <?php if (count($_smarty_tpl->tpl_vars['group']->value['albums']) >= $_smarty_tpl->tpl_vars['system']->value['max_results_even']) {?>
                                        <!-- see-more -->
                                        <div class="alert alert-info see-more js_see-more" data-get="albums" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
" data-type='group'>
                                            <span><?php echo __("See More");?>
</span>
                                            <div class="loader loader_small x-hidden"></div>
                                        </div>
                                        <!-- see-more -->
                                    <?php }?>
                                <?php } else { ?>
                                    <p class="text-center text-muted mt10">
                                        <?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
 <?php echo __("doesn't have albums");?>

                                    </p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- albums -->
                
                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "album") {?>
                    <!-- albums -->
                    <div class="col-12">
                        <div class="card panel-photos">
                            <div class="card-header with-icon with-nav">
                                <!-- back to albums -->
                                <div class="float-right">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/albums" class="btn btn-sm btn-light">
                                        <i class="fa fa-arrow-circle-left mr5"></i><?php echo __("Back to Albums");?>

                                    </a>
                                </div>
                                <!-- back to albums -->

                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-images mr10"></i><?php echo __("Photos");?>

                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/photos"><?php echo __("Photos");?>
</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/albums"><?php echo __("Albums");?>
</a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="card-body">
                            <?php $_smarty_tpl->_subTemplateRender('file:_album.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                            </div>
                        </div>
                    </div>
                    <!-- albums -->

                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "videos") {?>
                    <!-- videos -->
                    <div class="col-12">
                        <div class="card panel-videos">
                            <div class="card-header with-icon">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-video mr10"></i><?php echo __("Videos");?>

                                </div>
                                <!-- panel title -->
                            </div>
                            <div class="card-body">
                                <?php if ($_smarty_tpl->tpl_vars['group']->value['videos']) {?>
                                    <ul class="row no-gutters">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['videos'], 'video');
$_smarty_tpl->tpl_vars['video']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['video']->value) {
$_smarty_tpl->tpl_vars['video']->do_else = false;
?>
                                            <?php $_smarty_tpl->_subTemplateRender('file:__feeds_video.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>
                                    <!-- see-more -->
                                    <div class="alert alert-info see-more js_see-more" data-get="videos" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
" data-type='group'>
                                        <span><?php echo __("See More");?>
</span>
                                        <div class="loader loader_small x-hidden"></div>
                                    </div>
                                    <!-- see-more -->
                                <?php } else { ?>
                                    <p class="text-center text-muted mt10">
                                        <?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
 <?php echo __("doesn't have videos");?>

                                    </p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- videos -->
                
                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "members") {?>
                    <!-- members -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header with-icon with-nav">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-users mr10"></i><?php echo __("Members");?>

                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/members">
                                            <?php echo __("Members");?>

                                            <span class="badge badge-pill badge-info"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_members'];?>
</span>
                                        </a>
                                    </li>
                                    <?php if ($_smarty_tpl->tpl_vars['group']->value['i_joined'] == "approved") {?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/invites">
                                                <?php echo __("Invites");?>

                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="card-body">
                                <?php if ($_smarty_tpl->tpl_vars['group']->value['group_members'] > 0) {?>
                                    <ul class="row">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['members'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                        <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"]), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>

                                    <?php if ($_smarty_tpl->tpl_vars['group']->value['group_members'] >= $_smarty_tpl->tpl_vars['system']->value['max_results_even']) {?>
                                        <!-- see-more -->
                                        <div class="alert alert-info see-more js_see-more" data-get="group_members" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                            <span><?php echo __("See More");?>
</span>
                                            <div class="loader loader_small x-hidden"></div>
                                        </div>
                                        <!-- see-more -->
                                    <?php }?>
                                <?php } else { ?>
                                    <p class="text-center text-muted mt10">
                                        <?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
 <?php echo __("doesn't have members");?>

                                    </p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- members -->
                
                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "invites") {?>
                    <!-- invites -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header with-icon with-nav">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-users mr10"></i><?php echo __("Members");?>

                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/members">
                                            <?php echo __("Members");?>

                                            <span class="badge badge-pill badge-info"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_members'];?>
</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/invites">
                                            <?php echo __("Invites");?>

                                        </a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="card-body">
                                <?php if ($_smarty_tpl->tpl_vars['group']->value['invites']) {?>
                                    <ul class="row">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['invites'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                        <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"]), 0, true);
?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>

                                    <?php if (count($_smarty_tpl->tpl_vars['group']->value['invites']) >= $_smarty_tpl->tpl_vars['system']->value['max_results_even']) {?>
                                        <!-- see-more -->
                                        <div class="alert alert-info see-more js_see-more" data-get="group_invites" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                            <span><?php echo __("See More");?>
</span>
                                            <div class="loader loader_small x-hidden"></div>
                                        </div>
                                        <!-- see-more -->
                                    <?php }?>
                                <?php } else { ?>
                                    <p class="text-center text-muted mt10">
                                        <?php echo __("No friends to invite");?>

                                    </p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- invites -->
                
                <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "settings") {?>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body with-nav">
                                <ul class="side-nav">
                                    <li <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '') {?>class="active"<?php }?>>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/settings"><i class="fa fa-cog fa-fw mr5"></i><?php echo __("Group Settings");?>
</a>
                                    </li>
                                    <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] != "public") {?>
                                        <li <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "requests") {?>class="active"<?php }?>>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/settings/requests"><i class="fa fa-user-plus fa-fw mr5"></i><?php echo __("Join Requests");?>
</a>
                                        </li>
                                    <?php }?>
                                    <li <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "members") {?>class="active"<?php }?>>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/settings/members"><i class="fa fa-users fa-fw mr5"></i><?php echo __("Members");?>
</a>
                                    </li>
                                    <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['user_id'] == $_smarty_tpl->tpl_vars['group']->value['group_admin']) {?>
                                        <li <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "delete") {?>class="active"<?php }?>>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
/settings/delete"><i class="fa fa-trash fa-fw mr5"></i><?php echo __("Delete Group");?>
</a>
                                        </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <!-- edit -->
                        <div class="card">
                            <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '') {?>
                                <div class="card-header with-icon">
                                    <i class="fa fa-cog mr10"></i><?php echo __("Group Settings");?>

                                </div>
                                <form class="js_ajax-forms" data-url="pages_groups_events/create.php?type=group&do=edit&id=<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-control-label" for="title"><?php echo __("Name Your Group");?>
</label>
                                            <input type="text" class="form-control" name="title" id="title" placeholder='<?php echo __("Name of your group");?>
' value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="username"><?php echo __("Group Username");?>
</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text d-none d-sm-block"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups/</span>
                                                </div>
                                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
">
                                            </div>
                                            <span class="form-text">
                                                <?php echo __("Can only contain alphanumeric characters (A–Z, 0–9) and periods ('.')");?>

                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="privacy"><?php echo __("Select Privacy");?>
</label>
                                            <select class="form-control selectpicker" name="privacy">
                                                <option <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "public") {?>selected<?php }?> value="public" data-content="<div class='option'><div class='icon'><i class='fa fa-globe fa-2x'></i></div><div class='text'><b><?php echo __("Public Group");?>
</b><br><?php echo __("Anyone can see the group, its members and their posts");?>
.
                                                </div></div>"><?php echo __("Public Group");?>
</option>
                                                <option <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "closed") {?>selected<?php }?> value="closed" data-content="<div class='option'><div class='icon'><i class='fa fa-unlock-alt fa-2x'></i></div><div class='text'><b><?php echo __("Closed Group");?>
</b><br><?php echo __("Only members can see posts");?>
.
                                                </div></div>"><?php echo __("Closed Group");?>
</option>
                                                <option <?php if ($_smarty_tpl->tpl_vars['group']->value['group_privacy'] == "secret") {?>selected<?php }?> value="secret" data-content="<div class='option'><div class='icon'><i class='fa fa-lock fa-2x'></i></div><div class='text'><b><?php echo __("Secret Group");?>
</b><br><?php echo __("Only members can find the group and see posts");?>
.
                                                </div></div>"><?php echo __("Secret Group");?>
</option>
                                            </select>
                                            <span class="form-text">
                                                (<?php echo __("Note: Change group privacy to public will approve any pending join requests");?>
)
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="title"><?php echo __("Category");?>
</label>
                                            <select class="form-control" name="category" id="category">
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
                                                    <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('data_category'=>$_smarty_tpl->tpl_vars['group']->value['group_category']), 0, true);
?>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="description"><?php echo __("About");?>
</label>
                                            <textarea class="form-control" name="description" id="description"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_description'];?>
</textarea>
                                        </div>
                                        <!-- custom fields -->
                                        <?php if ($_smarty_tpl->tpl_vars['custom_fields']->value['basic']) {?>
                                        <?php $_smarty_tpl->_subTemplateRender('file:__custom_fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_custom_fields'=>$_smarty_tpl->tpl_vars['custom_fields']->value['basic'],'_registration'=>false), 0, false);
?>
                                        <?php }?>
                                        <!-- custom fields -->

                                        <div class="divider"></div>

                                        <div class="form-table-row">
                                            <div>
                                                <div class="form-control-label h6"><?php echo __("Members Can Publish Posts?");?>
</div>
                                                <div class="form-text d-none d-sm-block"><?php echo __("Members can publish posts or only group admins");?>
</div>
                                            </div>
                                            <div class="text-right">
                                                <label class="switch" for="group_publish_enabled">
                                                    <input type="checkbox" name="group_publish_enabled" id="group_publish_enabled" <?php if ($_smarty_tpl->tpl_vars['group']->value['group_publish_enabled']) {?>checked<?php }?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-table-row">
                                            <div>
                                                <div class="form-control-label h6"><?php echo __("Post Approval");?>
</div>
                                                <div class="form-text d-none d-sm-block">
                                                    <?php echo __("All posts must be approved by a group admin");?>
<br>
                                                    (<?php echo __("Note: Disable it will approve any pending posts");?>
)
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <label class="switch" for="group_publish_approval_enabled">
                                                    <input type="checkbox" name="group_publish_approval_enabled" id="group_publish_approval_enabled" <?php if ($_smarty_tpl->tpl_vars['group']->value['group_publish_approval_enabled']) {?>checked<?php }?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- error -->
                                        <div class="alert alert-danger mb0 x-hidden"></div>
                                        <!-- error -->
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary"><?php echo __("Save Changes");?>
</button>
                                    </div>
                                </form>
                            <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "requests") {?>
                                <div class="card-header with-icon">
                                    <i class="fa fa-user-plus mr10"></i><?php echo __("Member Requests");?>

                                </div>
                                <div class="card-body">
                                    <?php if ($_smarty_tpl->tpl_vars['group']->value['requests']) {?>
                                        <ul>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['requests'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                            <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"]), 0, true);
?>
                                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        </ul>

                                        <?php if (count($_smarty_tpl->tpl_vars['group']->value['requests']) >= $_smarty_tpl->tpl_vars['system']->value['max_results']) {?>
                                            <!-- see-more -->
                                            <div class="alert alert-info see-more js_see-more" data-get="group_requests" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                                <span><?php echo __("See More");?>
</span>
                                                <div class="loader loader_small x-hidden"></div>
                                            </div>
                                            <!-- see-more -->
                                        <?php }?>
                                    <?php } else { ?>
                                        <p class="text-center text-muted mt10">
                                            <?php echo __("No Requests");?>

                                        </p>
                                    <?php }?>
                                </div>
                            <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "members") {?>
                                <div class="card-header with-icon">
                                    <i class="fa fa-users mr10"></i><?php echo __("Members");?>

                                </div>
                                <div class="card-body">
                                    <!-- admins -->
                                    <div class="heading-small mb20">
                                        <?php echo __("Admins");?>
 <span class="text-muted">(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_admins_count'];?>
)</span>
                                    </div>
                                    <div class="pl-md-4">
                                        <?php if ($_smarty_tpl->tpl_vars['group']->value['group_admins']) {?>
                                            <ul>
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['group_admins'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                                <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"]), 0, true);
?>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            </ul>

                                            <?php if ($_smarty_tpl->tpl_vars['group']->value['group_admins_count'] >= $_smarty_tpl->tpl_vars['system']->value['max_results_even']) {?>
                                                <!-- see-more -->
                                                <div class="alert alert-info see-more js_see-more" data-get="group_admins" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                                    <span><?php echo __("See More");?>
</span>
                                                    <div class="loader loader_small x-hidden"></div>
                                                </div>
                                                <!-- see-more -->
                                            <?php }?>
                                        <?php } else { ?>
                                            <p class="text-center text-muted mt10">
                                                <?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
 <?php echo __("doesn't have admins");?>

                                            </p>
                                        <?php }?>
                                    </div>
                                    <!-- admins -->

                                    <div class="divider"></div>

                                    <!-- members -->
                                    <div class="heading-small mb20">
                                        <?php echo __("All Members");?>
 <span class="text-muted">(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_members'];?>
)</span>
                                    </div>
                                    <div class="pl-md-4">
                                        <?php if ($_smarty_tpl->tpl_vars['group']->value['group_members'] > 0) {?>
                                            <ul>
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value['members'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                                <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"]), 0, true);
?>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            </ul>

                                            <?php if ($_smarty_tpl->tpl_vars['group']->value['group_members'] >= $_smarty_tpl->tpl_vars['system']->value['max_results_even']) {?>
                                                <!-- see-more -->
                                                <div class="alert alert-info see-more js_see-more" data-get="group_members_manage" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                                    <span><?php echo __("See More");?>
</span>
                                                    <div class="loader loader_small x-hidden"></div>
                                                </div>
                                                <!-- see-more -->
                                            <?php }?>
                                        <?php } else { ?>
                                            <p class="text-center text-muted mt10">
                                                <?php echo $_smarty_tpl->tpl_vars['group']->value['group_title'];?>
 <?php echo __("doesn't have members");?>

                                            </p>
                                        <?php }?>
                                    </div>
                                    <!-- members -->
                                </div>
                            <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "delete") {?>
                                <div class="card-header with-icon">
                                    <i class="fa fa-trash mr10"></i><?php echo __("Delete Group");?>

                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <div class="icon">
                                            <i class="fa fa-exclamation-triangle fa-2x"></i>
                                        </div>
                                        <div class="text pt5">
                                            <?php echo __("Once you delete your group you will no longer can access it again");?>

                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-danger js_delete-group" data-id="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
">
                                            <i class="fa fa-trash mr10"></i><?php echo __("Delete Group");?>

                                        </button>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                        <!-- edit -->
                    </div>
                
                <?php }?>
                <!-- view content -->
            </div>
            <!-- profile-content -->
        </div>
        <!-- content panel -->

    </div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
