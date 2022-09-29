{include file='_head.tpl'}
{include file='_header.tpl' wrapperClass='search-page'}

<!-- page header -->
<div class="page-header">
    <div class="container d-flex flex-row align-items-center">
        {include file='__svg_icons.tpl' icon="shn-magnifier" class="header-img" width="200px" height="200px"}

        <div class="d-flex flex-column w-100">
            <h2>
                {__("Search")}
                <span style="max-width: 700px">{__("Discover new people, create new connections and make new friends")}</span>
            </h2>

            <!-- search form -->
            <div class="card search-page-form">
                <div class="card-body">
                    <form class="js_search-form" data-tab="{$tab}">
                        <div class="form-group mb0">
                            <div class="input-group">
                                <input id="search-input2" type="text" class="form-control" name="query" placeholder='{__("I am looking for")}' value="{$query}">
                                <div class="input-group-append">
                                    <button type="submit" name="submit" class="btn btn-dark search-form-submit">{__("search.")}</button>
                                </div>
                            </div>
                        </div>
                        <div class="search-wrapper d-md-block mb0">
                            <form>
                                <div id="search-results2" class="dropdown-menu dropdown-widget dropdown-search js_dropdown-keepopen">
                                    <div class="dropdown-widget-header">
                                        <span class="title">{__("Search Results")}</span>
                                    </div>
                                    <div class="dropdown-widget-body">
                                        <div class="loader loader_small ptb10"></div>
                                    </div>
                                    <a class="dropdown-widget-footer" id="search-results-all2" href="{$system['system_url']}/search/">{__("See All Results")}</a>
                                </div>
                            </form>
                        </div>
                        {if $tab == "users"}
                        <hr>
                        <div class="form-group mb0">
                            <div class="input-group col-4">
                                <select name="current_city" id="current_city" class="form-control">
                                    <option value="">---</option>
                                    {foreach $current_cities as $city}
                                        <option value="{$city}" {if $city==$query_options.current_city}selected{/if}>
                                            {$city}
                                        </option>
                                    {/foreach}
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger plr30"><i class="fas fa-city mr10"></i>{__("Current city")}</button>
                                </div>
                            </div>
                        </div>
                        {/if}
                    </form>
                </div>
            </div>
            <!-- search form -->
        </div>
    </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="container offcanvas">
    <div class="row">

        <!-- side panel -->
        <div class="col-12 d-block d-sm-none offcanvas-sidebar mt30">
            {include file='_sidebar.tpl'}
        </div>
        <!-- side panel -->

        <!-- content panel -->
        <div class="col-12 offcanvas-mainbar">
            <div class="row">
                <!-- left panel -->
                <div class="col-lg-12">
                    <!-- panel nav -->
                    <ul class="nav nav-fill nav-search mb10">
                        {if $system['people_enabled']}
                            <li class="nav-item">
                                <a class="nav-link btn {if $tab == "" || $tab == "people"}btn-dark{/if}" href="{$system['system_url']}/search/{$query}/people{$query_string}">
                                    <i class="fa fa-calendar mr5"></i><strong>{__("People")}</strong>
                                </a>
                            </li>
                        {/if}
                        <li class="nav-item">
                            <a class="nav-link btn {if $tab == "posts"}btn-dark{/if}" href="{$system['system_url']}/search/{if $hashtag}hashtag/{/if}{$query}/posts{$query_string}">
                                <i class="fa fa-newspaper mr5"></i><strong>{__("Posts")}</strong>
                            </a>
                        </li>
                        {if $system['blogs_enabled']}
                            <li class="nav-item">
                                <a class="nav-link btn {if $tab == "articles"}btn-dark{/if}" href="{$system['system_url']}/search/{if $hashtag}hashtag/{/if}{$query}/articles{$query_string}">
                                    <i class="fab fa-blogger-b mr5"></i><strong>{__("Articles")}</strong>
                                </a>
                            </li>
                        {/if}
{*                        <li class="nav-item">*}
{*                            <a class="nav-link btn {if $tab == "users"}btn-dark{/if}" href="{$system['system_url']}/search/{$query}/users{$query_string}">*}
{*                                <i class="fa fa-user mr5"></i><strong>{__("Users")}</strong>*}
{*                            </a>*}
{*                        </li>*}
                        {if $system['pages_enabled']}
                            <li class="nav-item">
                                <a class="nav-link btn {if $tab == "pages"}btn-dark{/if}" href="{$system['system_url']}/search/{$query}/pages{$query_string}">
                                    <i class="fa fa-flag mr5"></i><strong>{__("Pages")}</strong>
                                </a>
                            </li>
                        {/if}
                        {if $system['groups_enabled']}
                            <li class="nav-item">
                                <a class="nav-link btn {if $tab == "groups"}btn-dark{/if}" href="{$system['system_url']}/search/{$query}/groups{$query_string}">
                                    <i class="fa fa-users mr5"></i><strong>{__("Groups")}</strong>
                                </a>
                            </li>
                        {/if}
                        {if $system['events_enabled']}
                            <li class="nav-item">
                                <a class="nav-link btn {if $tab == "events"}btn-dark{/if}" href="{$system['system_url']}/search/{$query}/events{$query_string}">
                                    <i class="fa fa-calendar mr5"></i><strong>{__("Events")}</strong>
                                </a>
                            </li>
                        {/if}
                    </ul>
                    <!-- panel nav -->

                    <div class="tab-content">

                        <div class="tab-pane active">
                            {if $tab == "" || $tab == "people"}
                                <div class="">
                                    <div id="search-results_page">
                                        <div class="dropdown-widget-body">
                                            {include file='_no_data.tpl'}
                                        </div>
                                    </div>
                                </div>
                            {elseif $results}
                                <ul>
                                    {if $tab == "posts"}
                                        <!-- posts -->
                                        {foreach $results as $post}
                                        {include file='__feeds_post.tpl'}
                                        {/foreach}
                                        <!-- posts -->
                                    {elseif $tab == "articles"}
                                        <!-- articles -->
                                        {foreach $results as $post}
                                        {include file='__feeds_post.tpl'}
                                        {/foreach}
                                        <!-- articles -->
                                    {elseif $tab == "users"}
                                        <!-- users -->
                                        {foreach $results as $_user}
                                        {include file='__feeds_user.tpl' _tpl="list" _connection=$_user['connection']}
                                        {/foreach}
                                        <!-- users -->
                                    {elseif $tab == "pages"}
                                        <!-- pages -->
                                        {foreach $results as $_page}
                                        {include file='__feeds_page.tpl' _tpl="list"}
                                        {/foreach}
                                        <!-- pages -->
                                    {elseif $tab == "groups"}
                                        <!-- groups -->
                                        {foreach $results as $_group}
                                        {include file='__feeds_group.tpl' _tpl="list"}
                                        {/foreach}
                                        <!-- groups -->
                                    {elseif $tab == "events"}
                                        <!-- events -->
                                        {foreach $results as $_event}
                                        {include file='__feeds_event.tpl' _tpl="list"}
                                        {/foreach}
                                        <!-- events -->
                                    {/if}
                                </ul>

                                {if count($results) >= $system['search_results']}
                                    <!-- see-more -->
                                    <div class="alert alert-post see-more mb20 js_see-more js_see-more-infinite" data-get="search_{$tab}" data-filter="{$query}">
                                        <span>{__("More Results")}</span>
                                        <div class="loader loader_small x-hidden"></div>
                                    </div>
                                    <!-- see-more -->
                                {/if}
                            {else}
                                {include file='_no_data.tpl'}
                            {/if}
                        </div>

                    </div>
                </div>
                <!-- left panel -->

                <!-- right panel -->
                <div class="col-lg-4">
                    {include file='_ads_campaigns.tpl'}
                    {include file='_ads.tpl'}
                    {include file='_widget.tpl'}
                </div>
                <!-- right panel -->
            </div>
        </div>
        <!-- content panel -->

    </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
