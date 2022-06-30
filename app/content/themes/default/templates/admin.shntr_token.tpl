<div class="card">
    <div class="card-header with-icon">
        <i class="fa fa-dollar-sign mr10"></i>{__("Transactions History")}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover js_dataTable">
                <thead>
                <tr>
                    <th>{__("ID")}</th>
                    <th>{__("Amount")}</th>
                    <th>{__("Sender")}</th>
                    <th>{__("Recipient")}</th>
                    <th>{__("Note")}</th>
                    <th>{__("Created at")}</th>
                </tr>
                </thead>
                <tbody>
                {foreach $rows as $row}
                    <tr>
                        <td>{$row@iteration}</td>
                        <td>{$row['amount']|number_format:2}</td>
                        <td><a target="_blank" href="/{$row['sender_name']}">{$row['sender_name']}</a></td>
                        <td><a target="_blank" href="/{$row['recipient_name']}">{$row['recipient_name']}</a></td>
                        <td>
                            {if !empty($row['note'])}
                                {$row['note']}
                            {else}
                                ---
                            {/if}
                        </td>
                        <td>
                            <span class="js_moment" data-time="{$row['created_at']}">{$row['created_at']}</span>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
