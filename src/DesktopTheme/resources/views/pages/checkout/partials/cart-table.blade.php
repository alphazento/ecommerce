@push('styles')
    .items-table td{
        border: 0;
    }
    .osc__item-img{
        width: 300px;
    }
    .osc__product-name{
        word-break: break-word;
        -ms-word-break: break-word;
        color: black;
        font-weight: bold;
    }
    .osc__product-info{
        min-height: 99px;
    }
    .osc__product-info td{
        border-bottom: 0;
        padding: 0;
    }
    .osc__padding-left-5{
        padding-left: 5px;
    }
    .osc__update-quantity{
        width: 50%;
    }
@endpush
<table class="items-table">
    <tbody>
    @for ($it = 0; $it < 50; $it++)
    <tr id="osc__orderreview-block{{$it}}" style="display:none;" class="osc__order-product">
        <td>
            <div class="osc__item-img">
                <img src=@asset("/tonercitytheme/assets/img/logo-small.png")>
            </div>
        </td>
        <td>
            <table class="osc__product-info">
                <tr>
                    <td>
                        <div class="osc__item-name">
                            <a class="osc__product-name" href=""></a>
                        </div>
                    </td>
                    <td style="vertical-align: top;">
                        <div class="osc__item-remove osc__remove-product" data-id="" style="font-size: 1.1em;"><i class="fa fa-times"></i></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="osc__padding-left-5">
                            <label for="quantity-selector-{{ $it }}">Qty </label>
                            <select id="quantity-selector-{{ $it }}" name="quantity" class="searched-products__select osc__update-quantity osc__margin-left-5" data-id="">
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="text-right osc__product-price"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endfor
    </tbody>
</table>

@push('rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    $('.osc__remove-product').click(function() {
        var $me = $(this);
        $.ajaxDELETE('/ajax/quote/products/' + $(this).attr('data-id'), {}, function(response) {
            if (response.success) {
                $me.closest('.osc__order-product').hide();
            }
            windowLib.sendMessage('osc-ajax-responsed', response);
        })
    });

    $('.osc__update-quantity').on('change', function() {
        windowLib.sendMessage('updating-quote', {});
        $.ajaxPOST('/ajax/quote/products/' + $(this).attr('data-id') + '/qty', { buyqty: this.value }, function(data) {
            windowLib.sendMessage('osc-ajax-responsed', data);
        })
    });

    var bindItem = function(i, item) {
        var block = $('#osc__orderreview-block' + i);
        $(".osc__remove-product", block[0]).attr('data-id', item.product_id);
        $(".osc__update-quantity", block[0]).attr('data-id', item.product_id);
        $(".osc__update-quantity", block[0]).val(item.qty);
        $(".osc__product-name", block[0]).html(item.name);
        $(".osc__product-name", block[0]).attr('href', item.url);
        $(".osc__item-img > img", block[0]).attr('src', item.image);
        $(".osc__product-price", block[0]).html('$' + item.formated_price);
        block.addClass('osc__orderreview-block-active');
        block.show();
    };

    var assignItems = function(items) {
        for (var i = 0; i < items.length; i++) {
            bindItem(i, items[i]);
        }
        for (var i = items.length; i < 50; i++) {
            var blockSelector = '#osc__orderreview-block' + i;
            $(blockSelector).hide();
        }
    };

    windowLib.onMessage('quote-updated', function(quote) {
        assignItems(quote.items);
    });

    var initQuote = getGlobalConfigValue('init_quote');
    assignItems(initQuote.items);
})
@endpush
