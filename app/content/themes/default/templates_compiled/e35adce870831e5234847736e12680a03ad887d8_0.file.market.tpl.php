<?php
/* Smarty version 3.1.40, created on 2022-04-07 12:46:13
  from '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/market.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_624edd15ea8256_60577792',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e35adce870831e5234847736e12680a03ad887d8' => 
    array (
      0 => '/home/httpd/vhosts/shntr.com/sngine.shntr.com/content/themes/default/templates/market.tpl',
      1 => 1642784686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_ads.tpl' => 1,
    'file:_no_data.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_624edd15ea8256_60577792 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page header -->
<div class="page-header">
	<img class="floating-img d-none d-md-block" src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/headers/undraw_online_shopping_ga73.svg">
    <div class="circle-2"></div>
    <div class="circle-3"></div>
    <div class="container">
        <h2><?php echo __("Marketplace");?>
</h2>
        <p class="text-xlg"><?php echo __($_smarty_tpl->tpl_vars['system']->value['system_description_marketplace']);?>
</p>
        <div class="row mt20">
            <div class="col-sm-9 col-lg-6 mx-sm-auto">
                <form class="js_search-form" data-handle="market">
                    <div class="input-group">
                        <input type="text" class="form-control" name="query" placeholder='<?php echo __("Search for products");?>
'>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-danger"><?php echo __("Search");?>
</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="container mt20 offcanvas">
	<div class="row">

		<!-- left panel -->
		<div class="col-md-4 col-lg-3 offcanvas-sidebar">
			<!-- add new product -->
			<?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_sell_products']) {?>
				<div class="mb10">
					<button type="button" class="btn btn-sm btn-success btn-block rounded-pill" data-toggle="modal" data-url="posts/product.php?do=create">
		                <i class="fa fa-cart-plus mr10"></i><?php echo __("Add New Product");?>

		            </button>
				</div>
			<?php }?>
            <!-- add new product -->

            <!-- categories -->
			<div class="card">
				<div class="card-body with-nav">
					<ul class="side-nav">
						<?php if ($_smarty_tpl->tpl_vars['view']->value != "category") {?>
							<li class="active">
								<a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/market">
	                                <?php echo __("All");?>

	                            </a>
							</li>
						<?php } else { ?>
							<li>
								<?php if ($_smarty_tpl->tpl_vars['current_category']->value['parent']) {?>
									<a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/market/category/<?php echo $_smarty_tpl->tpl_vars['current_category']->value['parent']['category_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['current_category']->value['parent']['category_url'];?>
">
		                                <i class="fas fa-arrow-alt-circle-left mr5"></i><?php echo __($_smarty_tpl->tpl_vars['current_category']->value['parent']['category_name']);?>

		                            </a>
								<?php } else { ?>
									<a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/market">
		                                <?php if ($_smarty_tpl->tpl_vars['current_category']->value['sub_categories']) {?><i class="fas fa-arrow-alt-circle-left mr5"></i><?php }
echo __("All");?>

		                            </a>
								<?php }?>
							</li>
						<?php }?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
							<li <?php if ($_smarty_tpl->tpl_vars['view']->value == "category" && $_smarty_tpl->tpl_vars['current_category']->value['category_id'] == $_smarty_tpl->tpl_vars['category']->value['category_id']) {?>class="active"<?php }?>>
								<a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/market/category/<?php echo $_smarty_tpl->tpl_vars['category']->value['category_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['category']->value['category_url'];?>
">
	                                <?php echo __($_smarty_tpl->tpl_vars['category']->value['category_name']);?>

	                                <?php if ($_smarty_tpl->tpl_vars['category']->value['sub_categories']) {?>
	                                	<span class="float-right"><i class="fas fa-angle-right"></i></span>
	                                <?php }?>
	                            </a>
							</li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</div>
			</div>
			<!-- categories -->
		</div>
		<!-- left panel -->

		<!-- right panel -->
		<div class="col-md-8 col-lg-9 offcanvas-mainbar">

			<?php $_smarty_tpl->_subTemplateRender('file:_ads.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<?php if ($_smarty_tpl->tpl_vars['view']->value == "search") {?>
				<div class="bs-callout bs-callout-info mt0">
                    <!-- results counter -->
                    <span class="badge badge-pill badge-lg badge-light"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span> <?php echo __("results were found for the search for");?>
 "<strong class="text-primary"><?php echo htmlentities($_smarty_tpl->tpl_vars['query']->value,ENT_QUOTES,'utf-8');?>
</strong>"
                    <!-- results counter -->
                </div>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['view']->value == '' && $_smarty_tpl->tpl_vars['promoted_products']->value) {?>
				<div class="articles-widget-header">
                    <div class="articles-widget-title"><?php echo __("Promoted Products");?>
</div>
                </div>
				<div class="row mb20">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['promoted_products']->value, 'post');
$_smarty_tpl->tpl_vars['post']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->do_else = false;
?>
						<div class="col-md-6 col-lg-4">
							<div class="card product boosted">
								<div class="boosted-icon" data-toggle="tooltip" title="<?php echo __("Promoted");?>
">
					                <i class="fa fa-bullhorn"></i>
					            </div>
								<div class="product-image">
									<div class="product-price">
										<?php if ($_smarty_tpl->tpl_vars['post']->value['product']['price'] > 0) {?>
						                    <?php echo print_money($_smarty_tpl->tpl_vars['post']->value['product']['price']);?>

						                <?php } else { ?>
						                    <?php echo __("Free");?>

						                <?php }?>
									</div>
									<?php if ($_smarty_tpl->tpl_vars['post']->value['photos_num'] > 0) {?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['post']->value['photos'][0]['source'];?>
">
									<?php } else { ?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_product.jpg">
									<?php }?>
									<div class="product-overlay">
										<a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">
											<?php echo __("More");?>

										</a>
										<?php if ($_smarty_tpl->tpl_vars['post']->value['author_id'] != $_smarty_tpl->tpl_vars['user']->value->_data['user_id']) {?>
									        <button type="button" class="btn btn-sm btn-info rounded-pill js_chat-start" data-uid="<?php echo $_smarty_tpl->tpl_vars['post']->value['author_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['post']->value['post_author_name'];?>
"><i class="fa fa-comments mr5"></i><?php echo __("Buy");?>
</button>
									    <?php }?>
									</div>
								</div>
								<div class="product-info">
									<div class="product-meta title">
										<a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
" class="title"><?php echo $_smarty_tpl->tpl_vars['post']->value['product']['name'];?>
</a>
									</div>
									<div class="product-meta">
										<i class="fa fa-tag fa-fw mr5" style="color: #1f9cff;"></i><?php echo __("Type");?>
: 
										<?php if ($_smarty_tpl->tpl_vars['post']->value['product']['status'] == "new") {
echo __("New");
} else {
echo __("Used");
}?>
									</div>
									<div class="product-meta">
										<i class="fa fa-map-marker fa-fw"></i> <?php if ($_smarty_tpl->tpl_vars['post']->value['product']['location']) {
echo $_smarty_tpl->tpl_vars['post']->value['product']['location'];
} else {
echo __("N/A");
}?>
									</div>
								</div>
							</div>
						</div>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</div>
            <?php }?>
			
			<?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
				<div class="articles-widget-header clearfix">
					<!-- sort -->
					<div class="float-right">
						<div class="dropdown">
							<button type="button" class="btn btn-sm btn-light dropdown-toggle ml10" data-toggle="dropdown" data-display="static">
								<?php if (!$_smarty_tpl->tpl_vars['sort']->value || $_smarty_tpl->tpl_vars['sort']->value == "latest") {?>
									<i class="fas fa-bars fa-fw"></i> <?php echo __("Latest");?>

								<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value == "price-high") {?>
									<i class="fas fa-sort-amount-down fa-fw"></i> <?php echo __("Price High");?>

								<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value == "price-low") {?>
									<i class="fas fa-sort-amount-down-alt fa-fw"></i> <?php echo __("Price Low");?>

								<?php }?>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="?<?php if ($_smarty_tpl->tpl_vars['distance']->value) {?>distance=<?php echo $_smarty_tpl->tpl_vars['distance']->value;?>
&<?php }?>sort=latest" class="dropdown-item"><i class="fas fa-bars fa-fw mr10"></i><?php echo __("Latest");?>
</a>
								<a href="?<?php if ($_smarty_tpl->tpl_vars['distance']->value) {?>distance=<?php echo $_smarty_tpl->tpl_vars['distance']->value;?>
&<?php }?>sort=price-high" class="dropdown-item"><i class="fas fa-sort-amount-down fa-fw mr10"></i><?php echo __("Price High");?>
</a>
								<a href="?<?php if ($_smarty_tpl->tpl_vars['distance']->value) {?>distance=<?php echo $_smarty_tpl->tpl_vars['distance']->value;?>
&<?php }?>sort=price-low" class="dropdown-item"><i class="fas fa-sort-amount-down-alt fa-fw mr10"></i><?php echo __("Price Low");?>
</a>
							</div>
						</div>
					</div>
					<!-- sort -->
					<?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in && $_smarty_tpl->tpl_vars['system']->value['location_finder_enabled']) {?>
						<!-- location filter -->
						<div class="float-right">
							<div class="dropdown">
								<button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" data-display="static">
									<i class="fa fa-map-marker-alt mr5"></i><?php echo __("Location");?>

								</button>
								<div class="dropdown-menu dropdown-menu-right">
									<form class="ptb15 plr15" method="get" action="?">
										<div class="form-group">
											<label class="form-control-label"><?php echo __("Distance");?>
</label>
											<div>
												<?php if ($_smarty_tpl->tpl_vars['sort']->value) {?>
													<input type="hidden" name="sort" value="<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
">
												<?php }?>
												<input type="range" class="custom-range" min="1" max="5000" name="distance" value="<?php if ($_smarty_tpl->tpl_vars['distance']->value) {
echo $_smarty_tpl->tpl_vars['distance']->value;
} else { ?>5000<?php }?>" oninput="this.form.distance_value.value=this.value">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1"><?php if ($_smarty_tpl->tpl_vars['system']->value['system_distance'] == "mile") {
echo __("ML");
} else {
echo __("KM");
}?></span>
													</div>
													<input disabled type="number" class="form-control" min="1" max="5000" name="distance_value" value="<?php if ($_smarty_tpl->tpl_vars['distance']->value) {
echo $_smarty_tpl->tpl_vars['distance']->value;
} else { ?>5000<?php }?>" oninput="this.form.distance.value=this.value">
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-sm btn-block btn-primary"><i class="fa fa-filter mr5"></i><?php echo __("Filter");?>
</button>
									</form>
								</div>
							</div>
						</div>
						<!-- location filter -->
					<?php }?>
                    <div class="articles-widget-title"><?php echo __("Products");?>
</div>
                </div>
				
				<div class="row">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'post');
$_smarty_tpl->tpl_vars['post']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->do_else = false;
?>
						<div class="col-md-6 col-lg-4">
							<div class="card product">
								<div class="product-image">
									<div class="product-price">
										<?php if ($_smarty_tpl->tpl_vars['post']->value['product']['price'] > 0) {?>
						                    <?php echo print_money($_smarty_tpl->tpl_vars['post']->value['product']['price']);?>

						                <?php } else { ?>
						                    <?php echo __("Free");?>

						                <?php }?>
									</div>
									<?php if ($_smarty_tpl->tpl_vars['post']->value['photos_num'] > 0) {?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['post']->value['photos'][0]['source'];?>
">
									<?php } else { ?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_product.jpg">
									<?php }?>
									<div class="product-overlay">
										<a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">
											<?php echo __("More");?>

										</a>
										<?php if ($_smarty_tpl->tpl_vars['post']->value['author_id'] != $_smarty_tpl->tpl_vars['user']->value->_data['user_id']) {?>
									        <button type="button" class="btn btn-sm btn-info rounded-pill js_chat-start" data-uid="<?php echo $_smarty_tpl->tpl_vars['post']->value['author_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['post']->value['post_author_name'];?>
"><i class="fa fa-comments mr5"></i><?php echo __("Buy");?>
</button>
									    <?php }?>
									</div>
								</div>
								<div class="product-info">
									<div class="product-meta title">
										<a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
" class="title"><?php echo $_smarty_tpl->tpl_vars['post']->value['product']['name'];?>
</a>
									</div>
									<div class="product-meta">
										<i class="fa fa-tag fa-fw mr5" style="color: #1f9cff;"></i><?php echo __("Type");?>
: 
										<?php if ($_smarty_tpl->tpl_vars['post']->value['product']['status'] == "new") {
echo __("New");
} else {
echo __("Used");
}?>
									</div>
									<div class="product-meta">
										<i class="fa fa-map-marker fa-fw"></i> <?php if ($_smarty_tpl->tpl_vars['post']->value['product']['location']) {
echo $_smarty_tpl->tpl_vars['post']->value['product']['location'];
} else {
echo __("N/A");
}?>
									</div>
								</div>
							</div>
						</div>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</div>

				<?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

			<?php } else { ?>
				<?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
		</div>
		<!-- right panel -->

	</div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
