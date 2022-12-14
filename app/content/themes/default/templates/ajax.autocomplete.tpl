<ul>
    {foreach $users as $_user}
    <li>
        <div
            class="data-container clickable small {if $type == 'tags'}js_tag-add{else}js_autocomplete-add{/if}"
            data-uid="{$_user['user_id']}"
            data-name="{if $system['show_usernames_enabled']}{$_user['user_name']}{else}{$_user['user_firstname']} {$_user['user_lastname']}{/if}"

            {if $_user['paywalled']}
                data-paywalled="{$_user['paywalled']['paywall_price']}"
                data-paywall-author-name="{$_user['paywalled']['paywall_author_name']}"
                data-paywall-author-id="{$_user['paywalled']['paywall_author_id']}"
            {/if}
        >
            <div class="data-avatar">
                <img  loading="lazy" class="data-avatar" src="{$_user['user_picture']}" alt="">
            </div>
            <div class="data-content">
                <div><strong>{if $system['show_usernames_enabled']}{$_user['user_name']}{else}{$_user['user_firstname']} {$_user['user_lastname']}{/if}</strong></div>
            </div>
        </div>
    </li>
    {/foreach}
</ul>
