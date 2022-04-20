<?php
/* Smarty version 3.1.40, created on 2022-04-07 12:36:38
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/information.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624edad6d5a945_02693159',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e17b7a78188d9fadeacbd75931506a89156b07a1' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/information.tpl',
      1 => 1638116302,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../css/style.css' => 1,
    'file:../css/style.rtl.css' => 1,
    'file:__feeds_user.tpl' => 3,
    'file:__feeds_page.tpl' => 1,
    'file:__feeds_group.tpl' => 1,
    'file:__feeds_event.tpl' => 1,
    'file:__feeds_post.tpl' => 1,
  ),
),false)) {
function content_624edad6d5a945_02693159 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/httpd/vhosts/shntr.com/sngine.shntr.com/includes/libs/Smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<!doctype html>
<html lang="<?php echo $_smarty_tpl->tpl_vars['system']->value['language']['code'];?>
" <?php if ($_smarty_tpl->tpl_vars['system']->value['language']['dir'] == "RTL") {?> dir="RTL" <?php }?>>
    <head>
        <!-- Meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
        
        <!-- Title -->
        <title><?php echo __("My Information");?>
</title>

        <!-- Fonts [Roboto|Font-Awesome] -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <!-- Fonts [Roboto|Font-Awesome] -->
        
        <!-- CSS -->
        <?php if ($_smarty_tpl->tpl_vars['system']->value['language']['dir'] == "LTR") {?>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <style type="text/css"><?php $_smarty_tpl->_subTemplateRender("file:../css/style.css", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></style>
        <?php } else { ?>
            <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
            <style type="text/css"><?php $_smarty_tpl->_subTemplateRender("file:../css/style.rtl.css", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></style>
        <?php }?>
        <!-- CSS -->

        <!-- CSS Customized -->
        <style>
            body {
                padding-top: 0;
            }
            header {
                background: var(--header-bg-color);
                text-align: center;
                font-size: 34px;
                font-weight: 300;
                line-height: 70px;
                padding: 70px 0 100px;
            }
            header a, 
            header a:hover {
                color: #fff;
            }
            .user-profile-picture {
                position: absolute;
                top: -50px;
                left: 50%;
                transform: translate(-50%);
            }
        </style>
        <!-- CSS Customized -->
    </head>
    <body <?php if ($_smarty_tpl->tpl_vars['system']->value['theme_mode_night']) {?>class="night-mode"<?php }?>>
        <!-- header -->
        <header>
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_title'];?>
</a>
        </header>
        <!-- header -->

        <!-- container -->
        <div class="container" style="margin-top: -25px;">
            <div class="card shadow">
                <div class="card-body page-content">
                    <!-- welcome -->
                    <div class="text-center">
                        <img class="img-thumbnail rounded-circle user-profile-picture" src="<?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_picture'];?>
" width="99" height="99">
                    </div>
                    <h3 class="mtb20 text-center"><span class="text-primary"><?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_lastname'];?>
</span></h3>
                    <!-- welcome -->

                    <!-- information & sessions -->
                    <?php if ($_smarty_tpl->tpl_vars['user_data']->value['information']) {?>
                        <!-- information -->
                        <div class="section-title bg-gradient-primary mb20">
                            <i class="fa fa-coins mr10"></i><?php echo __("Your Information");?>

                        </div>
                        <ul class="list-group mb20">
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo $_smarty_tpl->tpl_vars['user_data']->value['information']['user_id'];?>
</span>
                                <?php echo __("User ID");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo $_smarty_tpl->tpl_vars['user_data']->value['information']['user_name'];?>
</span>
                                <?php echo __("User Name");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo $_smarty_tpl->tpl_vars['user_data']->value['information']['user_firstname'];?>
</span>
                                <?php echo __("User First Name");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo $_smarty_tpl->tpl_vars['user_data']->value['information']['user_lastname'];?>
</span>
                                <?php echo __("User Last Name");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo $_smarty_tpl->tpl_vars['user_data']->value['information']['user_email'];?>
</span>
                                <?php echo __("User Email");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo $_smarty_tpl->tpl_vars['user_data']->value['information']['user_phone'];?>
</span>
                                <?php echo __("User Phone");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo __($_smarty_tpl->tpl_vars['user_data']->value['information']['user_gender']);?>
</span>
                                <?php echo __("User Gender");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['user_data']->value['information']['user_registered'],"%e %B %Y");?>
</span>
                                <?php echo __("Joined");?>

                            </li>
                            <li class="list-group-item">
                                <span class="float-right badge badge-lg badge-pill badge-secondary"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['user_data']->value['information']['user_last_seen'],"%e %B %Y");?>
</span>
                                <?php echo __("Last Login");?>

                            </li>
                        </ul>
                        <!-- information -->

                        <!-- sessions -->
                        <div class="section-title bg-gradient-red mb20">
                            <i class="fa fa-shield-alt mr10"></i><?php echo __("Your Sessions");?>

                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['information']['sessions']) {?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover <?php if ($_smarty_tpl->tpl_vars['system']->value['theme_mode_night']) {?>table-dark<?php }?>">
                                    <thead>
                                        <tr>
                                            <th><?php echo __("ID");?>
</th>
                                            <th><?php echo __("Browser");?>
</th>
                                            <th><?php echo __("OS");?>
</th>
                                            <th><?php echo __("Date");?>
</th>
                                            <th><?php echo __("IP");?>
</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['information']['sessions'], 'session');
$_smarty_tpl->tpl_vars['session']->iteration = 0;
$_smarty_tpl->tpl_vars['session']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['session']->value) {
$_smarty_tpl->tpl_vars['session']->do_else = false;
$_smarty_tpl->tpl_vars['session']->iteration++;
$__foreach_session_0_saved = $_smarty_tpl->tpl_vars['session'];
?>
                                            <tr>
                                                <td><?php echo $_smarty_tpl->tpl_vars['session']->iteration;?>
</td>
                                                <td>
                                                    <?php echo $_smarty_tpl->tpl_vars['session']->value['user_browser'];?>
 <?php if ($_smarty_tpl->tpl_vars['session']->value['session_id'] == $_smarty_tpl->tpl_vars['user']->value->_data['active_session_id']) {?><span class="badge badge-pill badge-lg badge-success"><?php echo __("Active Session");?>
</span><?php }?>
                                                </td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['session']->value['user_os'];?>
</td>
                                                <td>
                                                    <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['session']->value['session_date'];?>
"><?php echo $_smarty_tpl->tpl_vars['session']->value['session_date'];?>
</span>
                                                </td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['session']->value['user_ip'];?>
</td>
                                            </tr>
                                        <?php
$_smarty_tpl->tpl_vars['session'] = $__foreach_session_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                        <!-- sessions -->
                    <?php }?>
                    <!-- information & sessions -->

                    <!-- friends -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['friends'])) {?>
                        <div class="section-title bg-gradient-teal mb20">
                            <i class="fa fa-users mr10"></i><?php echo __("Your Friends");?>
 <span class="badge badge-pill badge-lg badge-warning"><?php echo count($_smarty_tpl->tpl_vars['user_data']->value['friends']);?>
</span>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['friends']) {?>
                            <ul class="row">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['friends'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"],'_no_action'=>true), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- friends -->

                    <!-- followings -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['followings'])) {?>
                        <div class="section-title bg-gradient-teal mb20">
                            <i class="fa fa-users mr10"></i><?php echo __("Your Followings");?>
 <span class="badge badge-pill badge-lg badge-warning"><?php echo count($_smarty_tpl->tpl_vars['user_data']->value['followings']);?>
</span>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['followings']) {?>
                            <ul class="row">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['followings'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"],'_no_action'=>true), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- followings -->

                    <!-- followers -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['followers'])) {?>
                        <div class="section-title bg-gradient-teal mb20">
                            <i class="fa fa-users mr10"></i><?php echo __("Your Followers");?>
 <span class="badge badge-pill badge-lg badge-warning"><?php echo count($_smarty_tpl->tpl_vars['user_data']->value['followers']);?>
</span>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['followers']) {?>
                            <ul class="row">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['followers'], '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                                <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box",'_connection'=>$_smarty_tpl->tpl_vars['_user']->value["connection"],'_no_action'=>true), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- followers -->

                    <!-- pages -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['pages'])) {?>
                        <div class="section-title bg-gradient-warning mb20">
                            <i class="fa fa-flag mr10"></i><?php echo __("Your Likes");?>
 <span class="badge badge-pill badge-lg badge-warning"><?php echo count($_smarty_tpl->tpl_vars['user_data']->value['pages']);?>
</span>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['pages']) {?>
                            <ul class="row">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['pages'], '_page');
$_smarty_tpl->tpl_vars['_page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_page']->value) {
$_smarty_tpl->tpl_vars['_page']->do_else = false;
?>
                                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_page.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box"), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- pages -->

                    <!-- groups -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['groups'])) {?>
                        <div class="section-title bg-gradient-warning mb20">
                            <i class="fa fa-users mr10"></i><?php echo __("Your groups");?>
 <span class="badge badge-pill badge-lg badge-warning"><?php echo count($_smarty_tpl->tpl_vars['user_data']->value['groups']);?>
</span>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['groups']) {?>
                            <ul class="row">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['groups'], '_group');
$_smarty_tpl->tpl_vars['_group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_group']->value) {
$_smarty_tpl->tpl_vars['_group']->do_else = false;
?>
                                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_group.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box",'_no_action'=>true), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- groups -->

                    <!-- events -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['events'])) {?>
                        <div class="section-title bg-gradient-warning mb20">
                            <i class="fa fa-calendar mr10"></i><?php echo __("Your events");?>
 <span class="badge badge-pill badge-lg badge-warning"><?php echo count($_smarty_tpl->tpl_vars['user_data']->value['events']);?>
</span>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['events']) {?>
                            <ul class="row">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['events'], '_event');
$_smarty_tpl->tpl_vars['_event']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_event']->value) {
$_smarty_tpl->tpl_vars['_event']->do_else = false;
?>
                                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_event.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"box"), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- events -->

                    <!-- posts -->
                    <?php if (is_array($_smarty_tpl->tpl_vars['user_data']->value['posts'])) {?>
                        <div class="section-title bg-gradient-purple mb20">
                            <i class="fa fa-newspaper mr10"></i><?php echo __("Your posts");?>

                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['user_data']->value['posts']) {?>
                            <ul>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_data']->value['posts'], 'post');
$_smarty_tpl->tpl_vars['post']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->do_else = false;
?>
                                <?php $_smarty_tpl->_subTemplateRender('file:__feeds_post.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"posts_information"), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-center text-muted mt10">
                                <?php echo __("No data to show");?>

                            </p>
                        <?php }?>
                    <?php }?>
                    <!-- posts -->
                </div>
            </div>
        </div>
        <!-- container -->

        <!-- footer -->
        <div class="container">
            <div class="footer text-center">
                &copy; <?php echo date('Y');?>
 <?php echo $_smarty_tpl->tpl_vars['system']->value['system_title'];?>

            </div>
        </div>
        <!-- footer -->
    </body>
</html><?php }
}
