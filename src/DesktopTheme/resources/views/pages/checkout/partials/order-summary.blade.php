<hr style="border-top: 2px solid lightgrey;"/>
<table class="total-table">
    @for($i=0; $i<5; $i++)
    <tr id="osc__summary-block-{{ $i }}" class="osc__summary-block" style="display:none;">
        <th class="osc__summary-block__title b0"></th>
        <td class="text-right osc__summary-block__value b0"></td>
    </tr>
    @endfor
</table>

@push('rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    windowLib.onMessage('quote-updated', function(quote) {
        renderOrderSummaryTable(quote.orderSummary);
    });

    $(document).on('click', '.os__summary-block-remove-coupon', function() {
        $.ajaxDELETE('/ajax/quote/coupon', {}, function(data) {
            windowLib.sendMessage('osc-ajax-responsed', data);
        });
    });

    var quote = getGlobalConfigValue('init_quote');
    renderOrderSummaryTable(quote.orderSummary);

    function renderOrderSummaryTable(orderSummary) {

        resetOrderSummaryTable();

        var hasCoupon = false;

        for (var i = 0; i < orderSummary.length; i++) {

            var summaryEntry = orderSummary[i];

            var selector = 'tr#osc__summary-block-' + i;
            $(selector).show();

            var elTitle = $(selector + ' th.osc__summary-block__title');

            if (summaryEntry.title.toLowerCase().indexOf('discount') !== -1) {
                $(selector).addClass('osc__summary-block-discount');
                var $removeCross = $('<i class="os__summary-block-remove-coupon fa fa-times"></i>');
                elTitle.text(summaryEntry.title).append($removeCross);
                hasCoupon = true;
            } else {
                elTitle.text(summaryEntry.title);
            }
            var elValue = $(selector + ' td.osc__summary-block__value');
            elValue.html(summaryEntry.valueText);
        }

        hasCoupon ? $('.cart__discount').hide() : $('.cart__discount').show();
    }

    function resetOrderSummaryTable() {
        $('.osc__summary-block').each(function() {
            $(this).hide().removeClass('osc__summary-block-discount');
            $(this).find('th').empty();
            $(this).find('td').empty();
        });
    }
});
@endpush
