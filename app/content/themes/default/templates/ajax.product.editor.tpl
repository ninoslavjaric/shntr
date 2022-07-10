<div class="modal-header">
    <h6 class="modal-title">
        <i class="fa fa-shopping-cart mr10" style="color: #2b53a4;"></i>
        {if $market_category}
            Edit {$market_category['category_name']|strtolower} item
        {else}
            {__("Edit Product")}
        {/if}
    </h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="js_ajax-forms" data-url="posts/edit.php">
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-8">
                <label class="form-control-label">
                    {if $market_category}
                        {$market_category['category_name']} item name
                    {else}
                        {__("Product Name")}
                    {/if}
                </label>
                <input name="name" type="text" class="form-control" value="{$post['product']['name']}">
            </div>
            <div class="form-group col-md-4">
                <label class="form-control-label">{__("Price")}</label>
                <input name="price" type="text" class="form-control" value="{$post['product']['price']}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="form-control-label">{__("Category")}</label>
                {if $market_category}
                    <input type="hidden" name="category" value="{$market_category['category_id']}">
                    <input class="form-control" type="text" value="{$market_category['category_name']}" disabled>
                {else}
                <select name="category" class="form-control">
                    {foreach $market_categories as $category}
                        {include file='__categories.recursive_options.tpl' data_category=$post['product']['category_id']}
                    {/foreach}
                </select>
                {/if}
            </div>
            <div class="form-group col-md-2">
                <label class="form-control-label">{__("Offer")}</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rent1" value="0" {if !$post['product']['rent']}checked{/if}>
                    <label class="form-check-label" for="rent1">{__('Sell')}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rent2" value="1" {if $post['product']['rent']}checked{/if}>
                    <label class="form-check-label" for="rent2">{__('Rent')}</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="form-control-label">{__("Status")}</label>
                <select name="status" class="form-control">
                    <option {if $post['product']['status'] == "new"}selected{/if} value="new">{__("New")}</option>
                    <option {if $post['product']['status'] == "old"}selected{/if} value="old">{__("Used")}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-control-label">{__("Location")}</label>
            <input type="text" class="form-control js_geocomplete" data-type="places" data-id="{$post['product']['location_id']}" name="location" value="{$post['product']['location']}">
        </div>
        <div class="form-group">
            <label class="form-control-label">{__("Description")}</label>
            <textarea name="message" rows="5" dir="auto" class="form-control">{$post['text_plain']}</textarea>
        </div>
        <!-- custom fields -->
        {if $custom_fields['basic']}
        {include file='__custom_fields.tpl' _custom_fields=$custom_fields['basic'] _registration=false}
        {/if}
        <div class="form-group">
            <label for="" class="form-control-label">{__('Potential buyers')}</label>
            <select name="buying_candidate_id" id="">
                <option value="0">---</option>
                {foreach $potential_buyers as $potential_buyer}
                    <option value="{$potential_buyer['user_id']}" {if $potential_buyer['user_id'] == $post['product']['buying_candidate_id']}selected{/if}>{$potential_buyer['user_name']}</option>
                {/foreach}
            </select>
        </div>
        <!-- custom fields -->
        <!-- error -->
        <div class="alert alert-danger mb0 x-hidden"></div>
        <!-- error -->
    </div>
    <div class="modal-footer">
        <input type="hidden" name="handle" value="product">
        <input type="hidden" name="id" value="{$post['post_id']}">
        <button type="button" class="btn btn-light" data-dismiss="modal">{__("Cancel")}</button>
        <button type="submit" class="btn btn-primary">{__("Save")}</button>
    </div>
</form>
