<div class="card">

    {if $sub_view == ""}

        <div class="card-header with-icon">
            <i class="fa fa-dollar-sign mr10"></i>{__("Webmail")}
        </div>

        <div class="tab-content">

            <div class="tab-pane active" id="*@shntr.com">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover js_dataTable">
                            <thead>
                            <tr>
                                <th>{__("Subject")}</th>
                                <th>{__("Sender")}</th>
                                <th>{__("Recipient")}</th>
                                <th>{__("Date")}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $rows as $row}
                                <tr>
                                    <td>
                                        <a href="/admincp/webmail/email/{$row['key']}">{$row['subject']}</a>
                                    </td>
                                    <td>{$row['from']}</td>
                                    <td>{$row['to']}</td>
                                    <td data-order="{$row['lastModified']|strtotime}">
                                        <span class="js_moment" data-time="{$row['date']|date_format:"%e %B %Y"}">
                                            {$row['date']|date_format:"%e %B %Y"}
                                        </span>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="#" class="btn btn-primary" disabled>{__("New email")}</a>
                </div>
            </div>
        </div>

    {elseif $sub_view == "email"}

        <div class="card">
            <div class="card-header with-icon">
                <i class="fa fa-dollar-sign mr10"></i>{__("Email")}
            </div>
            <div class="card-body">
                <iframe style="width: 100%;height: 1000px;border-color: rgb(0, 142, 199);" src="/admincp/webmail/email-if/{$emailKey}"></iframe>
            </div>
        </div>
    {/if}

</div>
