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
                            {if $row['link']}
                                <a href="{$row['link']}" target="_blank">link</a>
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
<div class="card">
    <div class="card-header with-icon">
        <i class="fa fa-dollar-sign mr10"></i>{__("Token sell request list")}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover js_dataTable">
                <thead>
                <tr>
                    <th>{__("ID")}</th>
                    <th>{__("Seller")}</th>
                    {* <th>{__("Email")}</th> *}
                    <th>{__("Address")}</th>
                    <th>{__("Country")}</th>
                    <th>{__("Amount")}</th>
                    <th>{__("Iban")}</th>
                    <th>{__("Post time")}</th>
                    <th>{__("State")}</th>
                </tr>
                </thead>
                <tbody>
                {$id=1}
                {foreach $posts as $post}
                    {if $post['state']=='pending'}
                        <tr>
                            <td>{$id}</td>
                            <td>{$post['name']}</td>
                            {* <td>{$post['user_email']}</td> *}
                            <td>{$post['address']}</td>
                            <td>{$post['country']}</td>
                            <td>{$post['sell_amount_token']}</td>
                            <td>{$post['iban']}</td>
                            <td>{$post['post_time']}</td>
                            <td>
                                <select id="inputState" class="form-control request-change-state" data-id="{$post['id']}" data-handle="sell_token">
                                    <option {if $post['state']=='pending'}{'selected'}{/if} value="pending">Pending</option>
                                    <option {if $post['state']=='in_process'}{'selected'}{/if} value="in_process">In process</option>
                                    <option {if $post['state']=='completed'}{'selected'}{/if} value="completed">Completed</option>
                                </select>
                            </td>
                        </tr>
                        <div style="display: none;">{$id++}</div>
                    {/if}
                {/foreach}
                {foreach $posts as $post}
                    {if $post['state']=='in_process'}
                        <tr>
                            <td>{$id}</td>
                            <td>{$post['name']}</td>
                            {* <td>{$post['user_email']}</td> *}
                            <td>{$post['address']}</td>
                            <td>{$post['country']}</td>
                            <td>{$post['sell_amount_token']}</td>
                            <td>{$post['iban']}</td>
                            <td>{$post['post_time']}</td>
                            <td>
                                <select id="inputState" class="form-control request-change-state" data-id="{$post['id']}" data-handle="sell_token">
                                    <option {if $post['state']=='pending'}{'selected'}{/if} value="pending">Pending</option>
                                    <option {if $post['state']=='in_process'}{'selected'}{/if} value="in_process">In process</option>
                                    <option {if $post['state']=='completed'}{'selected'}{/if} value="completed">Completed</option>
                                </select>
                            </td>
                        </tr>
                        <div style="display: none;">{$id++}</div>
                    {/if}
                {/foreach}
                {foreach $posts as $post}
                    {if $post['state']=='completed'}
                        <tr>
                            <td>{$id}</td>
                            <td>{$post['name']}</td>
                            {* <td>{$post['user_email']}</td> *}
                            <td>{$post['address']}</td>
                            <td>{$post['country']}</td>
                            <td>{$post['sell_amount_token']}</td>
                            <td>{$post['iban']}</td>
                            <td>{$post['post_time']}</td>
                            <td>
                                <select id="inputState" class="form-control request-change-state" data-id="{$post['id']}">
                                    <option {if $post['state']=='pending'}{'selected'}{/if} value="pending">Pending</option>
                                    <option {if $post['state']=='in_process'}{'selected'}{/if} value="in_process">In process</option>
                                    <option {if $post['state']=='completed'}{'selected'}{/if} value="completed">Completed</option>
                                </select>
                            </td>
                        </tr>
                        <div style="display: none;">{$id++}</div>
                    {/if}
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
