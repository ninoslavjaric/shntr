<div class="modal-header">
    <h6 class="modal-title">
        <i class="fa fa-shopping-cart mr10" style="color: #2b53a4;"></i>
        {if $market_category}
            New {$market_category['category_name']|strtolower} item
        {else}
            {__("Sell New Product")}
        {/if}
    </h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="publisher-mini">
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
                <input name="name" type="text" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label class="form-control-label">{__("Price")}</label>
                <input id="product_price_input" name="price" type="text" class="form-control">
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
                            {include file='__categories.recursive_options.tpl'}
                        {/foreach}
                    </select>
                {/if}
            </div>
            <div class="form-group col-md-2">
                <label class="form-control-label">{__("Offer")}</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rent1" value="0" checked>
                    <label class="form-check-label" for="rent1">{__('Sell')}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rent" id="rent2" value="1">
                    <label class="form-check-label" for="rent2">{__('Rent')}</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="form-control-label">{__("Status")}</label>
                <select name="status" class="form-control">
                    <option value="new">{__("New")}</option>
                    <option value="old">{__("Used")}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-control-label">{__("Location")}</label>
            <input type="text" class="form-control js_geocomplete" data-type="places" name="location">
        </div>
        <div class="form-group">
            <label class="form-control-label">{__("Description")}</label>
            <textarea name="message" rows="5" dir="auto" class="form-control"></textarea>
        </div>
        <!-- custom fields -->
        {if $custom_fields}
        {include file='__custom_fields.tpl' _custom_fields=$custom_fields _registration=true}
        {/if}
        <!-- custom fields -->
        <div class="row">
            <div class="form-group col-md-3">
                <label class="form-control-label">{__("Photos")}</label>
                <div class="attachments clearfix" data-type="photos">
                    <ul>
                        <li class="add">
                            <i class="fa fa-camera js_x-uploader" data-handle="publisher-mini" data-multiple="true"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label class="form-control-label">{__("Files")}</label>
                <div class="attachments clearfix" data-type="file">
                    <ul>
                        <li class="add">
                            <i class="fa fa-camera js_x-uploader" data-type="file" data-handle="publisher-mini" data-multiple="true"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- error -->
        <div class="alert alert-danger mb0 x-hidden"></div>
        <!-- error -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary js_publisher-btn js_publisher-product">{__("Publish")}<span class="badge">for {$price} tokens</span></button>
    </div>
</form>
