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
                <input id="product_price_input" name="price" type="text" class="form-control" value="{$post['product']['price']}">
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
            {if !$market_category['category_dominant']}
            <div class="form-group col-md-4">
                <label class="form-control-label">{__("Status")}</label>
                <select name="status" class="form-control">
                    <option {if $post['product']['status'] == "new"}selected{/if} value="new">{__("New")}</option>
                    <option {if $post['product']['status'] == "old"}selected{/if} value="old">{__("Used")}</option>
                </select>
            </div>
            {else}
                <input type="hidden" name="status" value="new">
            {/if}
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
        <!-- custom fields -->
        <div class="row">
            <div class="form-group col-md-3">
                <label class="form-control-label">{__("Photos")}</label>
                <div class="attachments clearfix" data-type="photos">
                    <ul>
                        <li class="add">
                            <i class="fa fa-camera js_x-uploader" data-handle="publisher-mini" data-multiple="true"></i>
                        </li>

                        {foreach $post['photos'] as $photo}
                        <li class="item deletable" data-photos="{$system['system_uploads']}/{$post['photo']}" data-src="{$photo['source']}" data-photo_id="{$photo['photo_id']}" data-post_id="{$post['post_id']}">
                            <img alt="" src="{$post['og_image']}">
                            <input type="hidden" name="img-ids[]" value="{$photo['photo_id']}">
                            <button type="button" class="close js_publisher-mini-attachment-image-remover" data-photo_id="{$photo['photo_id']}" data-post_id="{$post['post_id']}" data-photos="{$system['system_uploads']}/{$post['photo']}" title="Remove"><span>×</span></button>
                        </li>
                        {/foreach}

                    </ul>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label class="form-control-label">{__("Files")}</label>
                <div class="attachments clearfix" data-type="file">
                    <ul>
                        <li class="add">
                            <i class="fa fa-file js_x-uploader" data-type="file" data-handle="publisher-mini" data-multiple="true"></i>
                        </li>
                        {foreach $post['files'] as $file}
                            <li class="file-item item deletable" data-toggle="tooltip" title="" data-src="{$file['source']}" data-original-title="{$file['file_title']}">
                                <div class="svg-container " style=" ">
                                    <svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.5049 5.55143C20.504 5.54216 20.5024 5.53313 20.5009 5.52411C20.5003 5.5211 20.5001 5.51799 20.4995 5.51499C20.4973 5.50421 20.4946 5.49368 20.4915 5.48331C20.4911 5.48205 20.4909 5.4807 20.4905 5.47945C20.4872 5.46877 20.4834 5.45835 20.4793 5.44812C20.4789 5.44707 20.4785 5.44596 20.4781 5.44491C20.4741 5.43514 20.4694 5.42566 20.4646 5.41634C20.4638 5.41479 20.4632 5.41318 20.4624 5.41163C20.4577 5.40296 20.4526 5.39464 20.4473 5.38637C20.4459 5.38426 20.4448 5.38206 20.4434 5.38C20.4383 5.37228 20.4326 5.36496 20.4269 5.35764C20.425 5.35524 20.4234 5.35273 20.4214 5.35038C20.4143 5.3417 20.4067 5.33343 20.3988 5.32541C20.3981 5.32466 20.3975 5.32386 20.3967 5.32311L15.1837 0.110075C15.1828 0.109173 15.1818 0.108421 15.1808 0.107519C15.173 0.0998496 15.1649 0.0924311 15.1565 0.0854637C15.1537 0.083208 15.1508 0.0813033 15.148 0.0791479C15.1411 0.0737845 15.1342 0.0684211 15.1269 0.0635589C15.1244 0.0618546 15.1217 0.0604511 15.1191 0.058797C15.1113 0.0538346 15.1035 0.0489223 15.0953 0.0445614C15.0935 0.043609 15.0916 0.042807 15.0897 0.0419048C15.0807 0.0372431 15.0714 0.0327318 15.062 0.0287719C15.0608 0.0282707 15.0595 0.0279198 15.0583 0.0274185C15.0481 0.0233584 15.0379 0.0195489 15.0274 0.0163409C15.026 0.0159398 15.0247 0.0156892 15.0233 0.0152882C15.013 0.0122807 15.0025 0.00952381 14.9918 0.00736842C14.9887 0.00671679 14.9854 0.00646617 14.9822 0.00591479C14.9734 0.0043609 14.9645 0.00280702 14.9554 0.00190476C14.943 0.000651629 14.9304 0 14.9179 0H2.48679C1.39506 0 0.506836 0.88822 0.506836 1.97995V23.6341C0.506836 24.7258 1.39506 25.614 2.48679 25.614H18.5269C19.6186 25.614 20.5068 24.7258 20.5068 23.6341V5.58897C20.5068 5.57639 20.5062 5.56386 20.5049 5.55143ZM15.2938 1.28351L19.2233 5.21303H16.5219C15.8447 5.21303 15.2938 4.66216 15.2938 3.98496V1.28351ZM18.5269 24.8622H2.48679C1.80964 24.8622 1.25872 24.3113 1.25872 23.6341V1.97995C1.25872 1.30276 1.80964 0.75188 2.48679 0.75188H14.5419V3.98496C14.5419 5.07669 15.4301 5.96491 16.5219 5.96491H19.755V23.6341C19.755 24.3113 19.204 24.8622 18.5269 24.8622Z" fill="black"></path>
                                        <path d="M17.3239 12.4311H14.9177C14.7101 12.4311 14.5418 12.5993 14.5418 12.807C14.5418 13.0147 14.7101 13.183 14.9177 13.183H17.3239C17.5315 13.183 17.6998 13.0147 17.6998 12.807C17.6998 12.5993 17.5315 12.4311 17.3239 12.4311Z" fill="black"></path>
                                        <path d="M3.68978 13.183H13.3139C13.5215 13.183 13.6898 13.0147 13.6898 12.807C13.6898 12.5993 13.5215 12.4311 13.3139 12.4311H3.68978C3.48216 12.4311 3.31384 12.5993 3.31384 12.807C3.31384 13.0147 3.48216 13.183 3.68978 13.183Z" fill="black"></path>
                                        <path d="M17.3239 7.61905H7.29879C7.09117 7.61905 6.92285 7.78732 6.92285 7.99499C6.92285 8.20266 7.09117 8.37093 7.29879 8.37093H17.3239C17.5315 8.37093 17.6998 8.20266 17.6998 7.99499C17.6998 7.78732 17.5315 7.61905 17.3239 7.61905Z" fill="black"></path>
                                        <path d="M3.68978 8.37093H5.69495C5.90256 8.37093 6.07089 8.20266 6.07089 7.99499C6.07089 7.78732 5.90256 7.61905 5.69495 7.61905H3.68978C3.48216 7.61905 3.31384 7.78732 3.31384 7.99499C3.31384 8.20266 3.48216 8.37093 3.68978 8.37093Z" fill="black"></path>
                                        <path d="M17.3239 17.2431H9.70486C9.49724 17.2431 9.32892 17.4114 9.32892 17.6191C9.32892 17.8267 9.49724 17.995 9.70486 17.995H17.3239C17.5315 17.995 17.6998 17.8267 17.6998 17.6191C17.6998 17.4114 17.5315 17.2431 17.3239 17.2431Z" fill="black"></path>
                                        <path d="M8.10081 17.2431H3.68978C3.48216 17.2431 3.31384 17.4114 3.31384 17.6191C3.31384 17.8267 3.48216 17.995 3.68978 17.995H8.10081C8.30843 17.995 8.47675 17.8267 8.47675 17.6191C8.47675 17.4114 8.30843 17.2431 8.10081 17.2431Z" fill="black"></path>
                                        <path d="M17.3239 10.0251H3.68978C3.48216 10.0251 3.31384 10.1933 3.31384 10.401C3.31384 10.6087 3.48216 10.7769 3.68978 10.7769H17.3239C17.5315 10.7769 17.6998 10.6087 17.6998 10.401C17.6998 10.1933 17.5315 10.0251 17.3239 10.0251Z" fill="black"></path>
                                        <path d="M17.3239 14.8371H3.68978C3.48216 14.8371 3.31384 15.0054 3.31384 15.213C3.31384 15.4207 3.48216 15.589 3.68978 15.589H17.3239C17.5315 15.589 17.6998 15.4207 17.6998 15.213C17.6998 15.0054 17.5315 14.8371 17.3239 14.8371Z" fill="black"></path>
                                    </svg>
                                    <input type="hidden" name="file-ids[]" value="{$file['file_id']}">
                                </div>
                                <button type="button" class="close js_publisher-mini-attachment-file-remover" title="Remove"><span>×</span></button>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
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
