{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page header -->
<div class="page-header">
    <img class="floating-img d-none d-md-block" src="{$system['system_url']}/content/themes/{$system['theme']}/images/headers/undraw_product_teardown_elol.svg">
    <div class="circle-2"></div>
    <div class="circle-3"></div>
    <div class="inner">
        <h2>{__("Getting Started")}</h2>
        <p class="text-xlg">{__("This information will let us know more about you")}</p>
    </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="container" style="margin-top: -25px;">
    <div class="row">
    	<div class="col-12 col-md-10 mx-md-auto">
            <div class="card shadow">
                <div class="card-body">

                    <!-- nav -->
                    <ul class="nav nav-pills nav-fill nav-started mb30 js_wizard-steps">
                        <li class="nav-item">
                            <a class="nav-link active" href="#step-1">
                                <h4 class="mb5">{__("Step 1")}</h4>
                                <p class="mb0">{__("Upload your photo")}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#step-2">
                                <h4 class="mb5">{__("Step 2")}</h4>
                                <p class="mb0">{__("Update your info")}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#step-3">
                                <h4 class="mb5">{__("Step 3")}</h4>
                                <p class="mb0">{__("Add Friends")}</p>
                            </a>
                        </li>
                    </ul>
                    <!-- nav -->

                    <!-- tabs -->
                    <div class="js_wizard-content" id="step-1">
                        <div class="text-center">
                            <h3 class="mb5">{__("Welcome")} <span class="text-primary">{$user->_data['name']}</span></h3>
                            <p class="mb20">{__("Let's start with your photo")}</p>
                        </div>

                        <!-- profile-avatar -->
                        <div class="position-relative" style="height: 170px;">
                            <div class="profile-avatar-wrapper static">
                                <img src="{$user->_data['user_picture']}" alt="">

                                <!-- buttons -->
                                <div class="profile-avatar-change">
                                    <i class="fa fa-camera js_x-uploader" data-handle="picture-user"></i>
                                </div>
                                <div class="profile-avatar-change-loader">
                                    <div class="progress x-progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="profile-avatar-crop {if $user->_data['user_picture_default'] || !$user->_data['user_picture_id']}x-hidden{/if}">
                                    <i class="fa fa-crop-alt js_init-crop-picture" data-image="{$user->_data['user_picture_full']}" data-handle="user" data-id="{$user->_data['user_id']}"></i>
                                </div>
                                <div class="profile-avatar-delete {if $user->_data['user_picture_default']}x-hidden{/if}">
                                    <i class="fa fa-trash js_delete-picture" data-handle="picture-user"></i>
                                </div>
                                <!-- buttons -->
                            </div>
                        </div>
                        <!-- profile-avatar -->

                        <!-- buttons -->
                        <div class="clearfix mt20">
                            <button id="activate-step-2" class="btn btn-primary float-right">{__("Next Step")}<i class="fas fa-arrow-circle-right ml5"></i></button>
                        </div>
                        <!-- buttons -->
                    </div>

                    <div class="js_wizard-content x-hidden" id="step-2">
                        <div class="text-center">
                            <h3 class="mb5">{__("Update your info")}</h3>
                            <p class="mb20">{__("Share your information with our community")}</p>
                        </div>

                        <form class="js_ajax-forms" data-url="users/started.php">
                            <div class="heading-small mb20">
                                {__("Location")}
                            </div>
                            <div class="pl-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="country">{__("Country")}</label>
                                    <select class="form-control" name="country" id="country">
                                        <option value="none">{__("Select Country")}</option>
                                        {foreach $countries as $country}
                                            <option {if $user->_data['user_country'] == $country['country_id']}selected{/if} value="{$country['country_id']}">{$country['country_name']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                {if $system['location_info_enabled']}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label" for="city">{__("Current City")}</label>
                                            <input type="text" class="form-control js_geocomplete" data-type="places" name="city" id="city" value="{$user->_data['user_current_city']}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label" for="hometown">{__("Hometown")}</label>
                                            <input type="text" class="form-control js_geocomplete" data-type="places" name="hometown" id="hometown" value="{$user->_data['user_hometown']}">
                                        </div>
                                    </div>
                                {/if}
                            </div>

                            <div class="pl-md-4">
                                <div class="row">
                                    {if $system['relationship_info_enabled']}
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label">{__("Relationship Status")}</label>
                                            <select name="relationship" class="form-control">
                                                <option value="none">{__("Select Relationship")}</option>
                                                <option {if $user->_data['user_relationship'] == "single"}selected{/if} value="single">{__("Single")}</option>
                                                <option {if $user->_data['user_relationship'] == "relationship"}selected{/if} value="relationship">{__("In a relationship")}</option>
                                                <option {if $user->_data['user_relationship'] == "married"}selected{/if} value="married">{__("Married")}</option>
                                                <option {if $user->_data['user_relationship'] == "complicated"}selected{/if} value="complicated">{__("It's complicated")}</option>
                                                <option {if $user->_data['user_relationship'] == "separated"}selected{/if} value="separated">{__("Separated")}</option>
                                                <option {if $user->_data['user_relationship'] == "divorced"}selected{/if} value="divorced">{__("Divorced")}</option>
                                                <option {if $user->_data['user_relationship'] == "widowed"}selected{/if} value="widowed">{__("Widowed")}</option>
                                            </select>
                                        </div>
                                    {/if}
                                    <div class="form-group col-md-6">
                                        <span class="form-text form-control-label">
                                            {__("I'm jewish")}
                                        </span>
                                        <label class="switch" for="is_jewish">
                                            <input type="checkbox" name="is_jewish" id="is_jewish" {if $user->_data['user_is_jewish']}checked{/if}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="pl-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">{__("Birthdate")}</label>
                                    <div class="form-row">
                                        <div class="col">
                                            <select class="form-control" name="birth_month">
                                                <option value="none">{__("Select Month")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '1'}selected{/if} value="1">{__("Jan")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '2'}selected{/if} value="2">{__("Feb")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '3'}selected{/if} value="3">{__("Mar")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '4'}selected{/if} value="4">{__("Apr")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '5'}selected{/if} value="5">{__("May")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '6'}selected{/if} value="6">{__("Jun")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '7'}selected{/if} value="7">{__("Jul")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '8'}selected{/if} value="8">{__("Aug")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '9'}selected{/if} value="9">{__("Sep")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '10'}selected{/if} value="10">{__("Oct")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '11'}selected{/if} value="11">{__("Nov")}</option>
                                                <option {if $user->_data['user_birthdate_parsed']['month'] == '12'}selected{/if} value="12">{__("Dec")}</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="birth_day">
                                                <option value="none">{__("Select Day")}</option>
                                                {for $i=1 to 31}
                                                    <option {if $user->_data['user_birthdate_parsed']['day'] == $i}selected{/if} value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="birth_year">
                                                <option value="none">{__("Select Year")}</option>
                                                {for $i=1905 to 2022}
                                                    <option {if $user->_data['user_birthdate_parsed']['year'] == $i}selected{/if} value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {if $system['biography_info_enabled']}
                                <div class="pl-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">{__("About Me")}</label>
                                        <textarea class="form-control" name="biography">{$user->_data['user_biography']}</textarea>
                                    </div>
                                </div>
                            {/if}

                            {if $system['work_info_enabled']}
                                <div class="divider"></div>

                                <div class="heading-small mb20">
                                    {__("Work")}
                                </div>
                                <div class="pl-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="work_title">{__("Work Title")}</label>
                                        <input type="text" class="form-control" name="work_title" id="work_title" value="{$user->_data['user_work_title']}">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label" for="work_place">{__("Work Place")}</label>
                                            <input type="text" class="form-control" name="work_place" id="work_place" value="{$user->_data['user_work_place']}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label" for="work_url">{__("Work Website")}</label>
                                            <input type="text" class="form-control" name="work_url" id="work_url" value="{$user->_data['user_work_url']}">
                                        </div>
                                    </div>
                                </div>
                            {/if}

                            {if $system['education_info_enabled']}
                                <div class="divider"></div>

                                <div class="heading-small mb20">
                                    {__("Education")}
                                </div>
                                <div class="pl-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="edu_major">{__("Major")}</label>
                                        <input type="text" class="form-control" name="edu_major" id="edu_major" value="{$user->_data['user_edu_major']}">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label" for="edu_school">{__("School")}</label>
                                            <input type="text" class="form-control" name="edu_school" id="edu_school" value="{$user->_data['user_edu_school']}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label" for="edu_class">{__("Class")}</label>
                                            <input type="text" class="form-control" name="edu_class" id="edu_class" value="{$user->_data['user_edu_class']}">
                                        </div>
                                    </div>
                                </div>
                            {/if}

                            {if $system['interests_enabled']}
                                <div class="divider"></div>

                                <div class="heading-small mb20">
                                    {__("Interests")}
                                </div>
                                <div class="pl-md-4" style="max-height: 500px; overflow-y: scroll; overflow-x:auto">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{__("Title")}</th>
                                            <th>{__("Check")}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {foreach $user->get_interests() as $interest}
                                            <tr>
                                                <td>
                                                    {$interest['title']}
                                                </td>
                                                <td>
                                                    <input type="checkbox" value="{$interest['id']}" name="interests[]" {if $interest['interested']}checked{/if}>
                                                </td>
                                            </tr>
                                        {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            {/if}

                            <!-- success -->
                            <div class="alert alert-success x-hidden"></div>
                            <!-- success -->

                            <!-- error -->
                            <div class="alert alert-danger x-hidden"></div>
                            <!-- error -->

                            <!-- buttons -->
                            <div class="clearfix mt20">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle mr5"></i>{__("Save Changes")}</button>
                                    <button type="button" class="btn btn-primary" id="activate-step-3">{__("Next Step")}<i class="fas fa-arrow-circle-right ml5"></i></button>
                                </div>
                            </div>
                            <!-- buttons -->
                        </form>
                    </div>

                    <div class="js_wizard-content x-hidden" id="step-3">
                        <div class="text-center">
                            <h3 class="mb5">{__("Add Friends")}</h3>
                            <p class="mb20">{__("Get latest activities from our popular users")}</p>
                        </div>

                        <!-- new people -->
                        {if $new_people}
                            <ul class="row">
                                {foreach $new_people as $_user}
                                {include file='__feeds_user.tpl' _tpl="box" _connection="add"}
                                {/foreach}
                            </ul>
                        {/if}
                        <!-- new people -->

                        <!-- buttons -->
                        <div class="clearfix mt20">
                            <a href="{$system['system_url']}/started/finished" class="btn btn-danger float-right"><i class="fas fa-check-circle mr5"></i>{__("Finish")}</a>
                        </div>
                        <!-- buttons -->
                    </div>
                    <!-- tabs -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}

<script>
    $(function() {

        var wizard_steps = $('.js_wizard-steps li a');
        var wizard_content = $('.js_wizard-content');

        wizard_content.hide();

        wizard_steps.click(function(e) {
            e.preventDefault();
            var $target = $($(this).attr('href'));
            if(!$(this).hasClass('disabled')) {
                wizard_steps.removeClass('active');
                $(this).addClass('active');
                wizard_content.hide();
                $target.show();
            }
        });

        $('.js_wizard-steps li a.active').trigger('click');

        $('#activate-step-2').on('click', function(e) {
            $('.js_wizard-steps li:eq(1) a').removeClass('disabled');
            $('.js_wizard-steps li a[href="#step-2"]').trigger('click');
        });

        $('#activate-step-3').on('click', function(e) {
            $('.js_ajax-forms').submit();
            $('.js_wizard-steps li:eq(2) a').removeClass('disabled');
            $('.js_wizard-steps li a[href="#step-3"]').trigger('click');
        });

    });
</script>
