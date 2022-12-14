{include file='_head.tpl'}
{include file='_header.tpl' wrapperClass='market'}

<!-- page header -->
<div class="page-header">
    <div class="container d-flex flex-row align-items-center">
        {include file='__svg_icons.tpl' icon="shn-products" class="header-img" width="200px" height="200px"}

        <div class="d-flex flex-column w-100">
            <h2>
                {if $current_category}
                    {$current_category['category_name']}
                    <span>{__("all your products")}</span>
                    <span>{__("in one place")}</span>
                {else}
                    {__("MarketPlace")}
                    <span>{__("all your products")}</span>
                    <span>{__("in one place")}</span>
                {/if}
            </h2>

            <form class="js_search-form" data-handle="market">
                <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder='{if $current_category}I am looking for {$current_category['category_name']|strtolower}{else}{__("I am looking for")}{/if}'>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-danger">{__("search.")}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="container mt20 offcanvas">
    <div class="row">

        {if !$current_category['category_dominant']}
        <!-- left panel -->
        <div class="col-md-4 col-lg-3 offcanvas-sidebar">
            <!-- add new product -->
            {if $user->_data['can_sell_products']}
                <div class="mb10">
                    <button type="button" class="btn btn-sm btn-dark btn-block rounded-pill" data-toggle="modal" data-url="posts/product.php?do=create" data-callback="geocompletionSetup">
                        <i class="fa fa-cart-plus mr10"></i>{__("Add New Product")}
                    </button>
                </div>
            {/if}
            <!-- add new product -->

            <!-- categories -->
                <div class="card">
                    <div class="card-body with-nav">
                        <ul class="side-nav">
                            {if $view != "category"}
                                <li class="active">
                                    <a href="{$system['system_url']}/market">
                                        {__("All")}
                                    </a>
                                </li>
                            {else}
                                <li>
                                    {if $current_category['parent']}
                                        <a href="{$system['system_url']}/market/category/{$current_category['parent']['category_id']}/{$current_category['parent']['category_url']}">
                                            <i class="fas fa-arrow-alt-circle-left mr5"></i>{__($current_category['parent']['category_name'])}
                                        </a>
                                    {else}
                                        <a href="{$system['system_url']}/market">
                                            {if $current_category['sub_categories']}<i class="fas fa-arrow-alt-circle-left mr5"></i>{/if}{__("All")}
                                        </a>
                                    {/if}
                                </li>
                            {/if}
                            {foreach $categories as $category}
                                <li {if $view == "category" && $current_category['category_id'] == $category['category_id']}class="active"{/if}>
                                    <a href="{$system['system_url']}/market/category/{$category['category_id']}/{$category['category_url']}">
                                        {__($category['category_name'])}
                                        {if $category['sub_categories']}
                                            <span class="float-right"><i class="fas fa-angle-right"></i></span>
                                        {/if}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            <!-- categories -->
            {/if}
        </div>
        <!-- left panel -->

        <!-- right panel -->
        <div class="col-md-{if $current_category['category_dominant']}12{else}8{/if} col-lg-{if $current_category['category_dominant']}12{else}9{/if} offcanvas-mainbar">

            {include file='_ads.tpl'}

            {if $view == "search"}
                <div class="bs-callout bs-callout-info mt0">
                    <!-- results counter -->
                    <span class="badge badge-pill badge-lg badge-light">{$total}</span> {__("results were found for the search for")} "<strong class="text-primary">{htmlentities($query, ENT_QUOTES, 'utf-8')}</strong>"
                    <!-- results counter -->
                </div>
            {/if}

            {if $view == "" && $promoted_products}
                <div class="articles-widget-header">
                    <div class="articles-widget-title">
                        {if $current_category}
                            Promoted {$current_category['category_name']}
                        {else}
                            {__("Promoted Products")}
                        {/if}
                    </div>
                </div>
                <div class="row mb20">
                    {foreach $promoted_products as $post}
                        <div class="col-md-6 col-lg-4">
                            <div class="card product boosted">
                                <div class="boosted-icon" data-toggle="tooltip" title="{__("Promoted")}">
                                    <i class="fa fa-bullhorn"></i>
                                </div>
                                <div class="product-image">
                                    <div class="product-price">
                                        {if $post['product']['price'] > 0}
                                            {print_money($post['product']['price'])}
                                        {else}
                                            {__("Free")}
                                        {/if}
                                    </div>
                                    {if $post['photos_num'] > 0}
                                        <img  loading="lazy" src="{$system['system_uploads']}/{$post['photos'][0]['source']}">
                                    {else}
                                        <img  loading="lazy" src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_product.jpg">
                                    {/if}
                                    <div class="product-overlay">
                                        <a class="btn btn-sm btn-outline-secondary rounded-pill" href="{$system['system_url']}/posts/{$post['post_id']}">
                                            {__("More")}
                                        </a>
                                        {if $post['author_id'] != $user->_data['user_id'] || $post['product']['sold'] }
                                            <button type="button" class="btn btn-sm btn-info rounded-pill js_chat-start" data-uid="{$post['author_id']}" data-name="{$post['post_author_name']}"><i class="fa fa-comments mr5"></i>{__("Buy")}</button>
                                        {/if}
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="product-meta title">
                                        <a href="{$system['system_url']}/posts/{$post['post_id']}" class="title">{$post['product']['name']}</a>
                                    </div>
                                    <div class="product-meta">
                                        {if $post['product']['rent'] }{__("For rent")}{else}{__("For sale")}{/if}
                                    </div>
                                    {if !$current_category['category_dominant']}
                                    <div class="product-meta">
                                        <i class="fa fa-tag fa-fw mr5" style="color: #1f9cff;"></i>{__("Type")}:
                                        {if $post['product']['status'] == "new"}{__("New")}{else}{__("Used")}{/if}
                                    </div>
                                    {/if}
                                    <div class="product-meta">
                                        <i class="fa fa-map-marker fa-fw"></i> {if $post['product']['location']}{$post['product']['location']}{else}{__("N/A")}{/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            {/if}


                <div class="articles-widget-header clearfix">

                    {if $current_category['category_dominant']}
                        <div class="float-right">
                            <button type="button" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-url="posts/product.php?do=create&category_id={$current_category['category_id']}" data-callback="geocompletionSetup">
                                <i class="fa fa-cart-plus mr10"></i>Add new {$current_category['category_name']|strtolower}
                            </button>
                        </div>
                    {/if}
                    <!-- sort -->
                    <div class="float-right">
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle ml10" data-toggle="dropdown" data-display="static">
                                {if !$sort || $sort == "latest"}
                                    <i class="fas fa-bars fa-fw"></i> {__("Latest")}
                                {elseif $sort == "price-high"}
                                    <i class="fas fa-sort-amount-down fa-fw"></i> {__("Price High")}
                                {elseif $sort == "price-low"}
                                    <i class="fas fa-sort-amount-down-alt fa-fw"></i> {__("Price Low")}
                                {/if}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="?{if $distance}distance={$distance}&{/if}sort=latest" class="dropdown-item"><i class="fas fa-bars fa-fw mr10"></i>{__("Latest")}</a>
                                <a href="?{if $distance}distance={$distance}&{/if}sort=price-high" class="dropdown-item"><i class="fas fa-sort-amount-down fa-fw mr10"></i>{__("Price High")}</a>
                                <a href="?{if $distance}distance={$distance}&{/if}sort=price-low" class="dropdown-item"><i class="fas fa-sort-amount-down-alt fa-fw mr10"></i>{__("Price Low")}</a>
                            </div>
                        </div>
                    </div>
                    <!-- sort -->
                    {if $user->_logged_in && $system['location_finder_enabled'] && !$current_category['category_dominant']}
                        <!-- location filter -->
                        <div class="float-right">
                            <div class="dropdown">
{*                                <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown" data-display="static">*}
{*                                    <i class="fa fa-map-marker-alt mr5"></i>{__("Location")}*}
{*                                </button>*}
                                <div class="dropdown-menu dropdown-menu-right">
                                    <form class="ptb15 plr15" method="get" action="?">
                                        <div class="form-group">
                                            <label class="form-control-label">{__("Distance")}</label>
                                            <div>
                                                {if $sort}
                                                    <input type="hidden" name="sort" value="{$sort}">
                                                {/if}
                                                <input type="range" class="custom-range" min="1" max="5000" name="distance" value="{if $distance}{$distance}{else}5000{/if}" oninput="this.form.distance_value.value=this.value">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">{if $system['system_distance'] == "mile"}{__("ML")}{else}{__("KM")}{/if}</span>
                                                    </div>
                                                    <input disabled type="number" class="form-control" min="1" max="5000" name="distance_value" value="{if $distance}{$distance}{else}5000{/if}" oninput="this.form.distance.value=this.value">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-block btn-primary"><i class="fa fa-filter mr5"></i>{__("Filter")}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- location filter -->
                    {/if}
                    <div class="articles-widget-title">
                        {if $current_category}
                            {$current_category['category_name']}
                        {else}
                            {__("Products")}
                        {/if}
                    </div>
                </div>
            {if $rows}
                <div class="row">
                    {foreach $rows as $post}
                        <div class="col-md-6 col-lg-4">
                            <div class="card product {if $post['product']['sold']}sold{/if}">
                                <div class="product-image">
                                    <div class="product-price">
                                        {if $post['product']['price'] > 0}
                                            {print_money($post['product']['price'])}
                                        {else}
                                            {__("Free")}
                                        {/if}
                                    </div>
                                    {if $post['photos_num'] > 0}
                                        <img  loading="lazy" src="{$system['system_uploads']}/{$post['photos'][0]['source']}">
                                    {else}
                                        <img  loading="lazy" src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_product.jpg">
                                    {/if}
                                    <div class="product-overlay">
                                        <a class="btn btn-sm btn-outline-secondary rounded-pill" href="{$system['system_url']}/posts/{$post['post_id']}">
                                            {__("More")}
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="product-meta title">
                                        <a href="{$system['system_url']}/posts/{$post['post_id']}" class="title">{$post['product']['name']}</a>
                                    </div>
                                    <div class="product-meta">
                                        <span class="badge">{if $post['product']['rent'] }{__("For rent")}{else}{__("For sale")}{/if}</span>
                                    </div>
                                    {if !$current_category['category_dominant']}
                                    <div class="product-meta">
                                        <i class="fa fa-tag fa-fw mr5" style="color: #1f9cff;"></i>{__("Type")}:
                                        {if $post['product']['status'] == "new"}{__("New")}{else}{__("Used")}{/if}
                                    </div>
                                    {/if}
                                    <div class="product-meta">
                                        <i class="fa fa-map-marker fa-fw"></i> {if $post['product']['location']}{$post['product']['location']}{else}{__("N/A")}{/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>

                {$pager}
            {else}
                {include file='_no_data.tpl'}
            {/if}
        </div>
        <!-- right panel -->

    </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
