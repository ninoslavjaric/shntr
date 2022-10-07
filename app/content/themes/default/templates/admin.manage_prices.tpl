<div class="card">
    <div class="card-header with-icon">
        <i class="fa fa-dollar-sign mr10"></i>{__("Manage Prices")}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form class="js_ajax-forms" data-url="admin/prices.php?edit=manage_prices">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-control-label">{__("Price for creating a page")}</label>
                        <input type="number" class="form-control" name="page_price" value="{$page_price}">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">{__("Price for creating a product")}</label>
                        <input type="number" class="form-control" name="product_price" value="{$product_price}">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">{__("Price for creating an event")}</label>
                        <input type="number" class="form-control" name="event_price" value="{$event_price}">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">{__("Price for creating a group")}</label>
                        <input type="number" class="form-control" name="group_price" value="{$group_price}">
                    </div>

                    <!-- success -->
                    <div class="alert alert-success mb0 x-hidden"></div>
                    <!-- success -->

                    <!-- error -->
                    <div class="alert alert-danger mb0 x-hidden"></div>
                    <!-- error -->
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                </div>
            </form>
        </div>
    </div>
</div>
