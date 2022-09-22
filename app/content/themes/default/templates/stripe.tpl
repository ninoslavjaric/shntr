{if $view == 'success'}
    successful payment
{elseif $view == 'fail'}
    failed payment
{else}
    <form action="/buy-tokens/checkout" method="POST">
        <button type="submit" id="checkout-button">Buy tokens</button>
    </form>
{/if}
