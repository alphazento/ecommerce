@push('styles')
    .osc__grand-total{
        background-color: #808080;
        color: white;
        font-size: 15px;
        line-height: 30px;
        padding: 3px 5px;
    }
    #grand-total{
        float: right;
    }
    #control-comment-text-area, #add-comment-label{
        cursor:pointer;
    }
    #word-count-part{
        font-size: 12px;
        text-align: right;
    }
    .osc__comment-fail{
        color: red;
        font-size: 12px;
    }
@endpush

<div class="cart__discount mb-4">
    <div class="block discount" id="block-discount">
        <div class="title">
            <b id="block-discount-heading">Add a coupon
                <i class="fa fa-chevron-down ml-1"></i>
            </b>
        </div>
        <div id="block-discount-area" class="content" style="display: none;">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group mt-2">
                        <input value=""
                                name="coupon" type="text"
                                class="form-control"
                                placeholder="Enter coupon code here"
                                aria-label="Coupon code"
                                aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn--orange osc__btn-applycoupon" id="button-addon2" type="button">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="osc__grand-total">
    <b>Grand Total</b>
    <span id="grand-total"></span>
</div>
<form name="tc__order-comment-form" action="{{ route('checkout.osc.updateComment') }}" method="post">
    @csrf_field()
    {{ method_field('PUT') }}
    <div class="cart__comment">
        <div class="form-group">
            <div class="title" id="control-comment-text-area">
                <label for="comment" class="osc__form-label" id="add-comment-label">Add Comment <i class="fa fa-chevron-down ml-1"></i></label>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="comment-part" style="display: none;">
                        <textarea name="comment" class="form-control" id="comment" rows="3"></textarea>
                        <div id="word-count-part"><span id="count-word"></span>/100</div>
                    </div>
                    <span class="osc__comment-fail" style="display:none;"></span>
                </div>
            </div>
        </div>
    </div>
</form>


@push('rqjs_body')
    requirejs(['jQuery', 'windowLib', 'loadingNotification', 'Noty'], function($, windowLib, notifier, Noty) {
        var quoteSnapshot = @json($quoteSnapshot);
        renderGrandTotal(quoteSnapshot);
        var coupon_code = "{{ $appliedCoupon['code'] ?? ''}}";
        var comment = "{{ $quoteSnapshot->comment ?? '' }}";
        $('#count-word').html(comment.length);

        var discountBlockShow = false;
        var toggleDiscountBlock = function() {
            discountBlockShow = !discountBlockShow;
            if (discountBlockShow) {
                $('#block-discount-area').show();
                var $icon = $('#block-discount-heading > i');
                $icon.removeClass("fa-chevron-down");
                $icon.addClass("fa-chevron-up");
            } else {
                $('#block-discount-area').hide();
                var $icon = $('#block-discount-heading > i');
                $icon.removeClass("fa-chevron-up");
                $icon.addClass("fa-chevron-down");
            }
        }


        $('#block-discount-heading').click(toggleDiscountBlock);
        if (coupon_code) {
            $('input[name=coupone]').val(coupon_code);
            toggleDiscountBlock();
        }

        $('#comment').on('input', function(e){
            var commentLength = $(this).val().length;
            if(commentLength >= 100){
                e.preventDefault();
                $(this).val($(this).val().substring(0, 100));
            }
        });

        $('#comment').keyup(function(){
            $('#count-word').html($(this).val().length);
        });

        var commentTextArea = false;
        var toggleCommentTextArea = function() {
            commentTextArea = !commentTextArea;
            if(commentTextArea){
                $('#comment-part').show();
                var $icon = $('#add-comment-label > i');
                $icon.removeClass('fa-chevron-down');
                $icon.addClass('fa-chevron-up');
            }else{
                $('#comment-part').hide();
                var $icon = $('#add-comment-label > i');
                $icon.removeClass('fa-chevron-up');
                $icon.addClass('fa-chevron-down');
            }
        }

        $('#control-comment-text-area').click(toggleCommentTextArea);
        if(comment){
            $('#comment').val(comment);
            toggleCommentTextArea();
        }

        $('.osc__btn-applycoupon').click(function() {
            var coupon = $('input[name=coupon]').val();
            var $me = $(this);
            $.ajaxPUT('/ajax/quote/coupon', {coupon:coupon}, function(data) {
                $me.parent().siblings('input').val('');
                windowLib.sendMessage('osc-ajax-responsed', data);
            })
        });

        windowLib.onMessage('quote-updated', function(quote) {
            renderGrandTotal(quote);
        });

        function renderGrandTotal(quote) {
            var grandTotal = '$' + (quote.grand_total / 100).toFixed(2);
            $('#grand-total').html(grandTotal);
        }
    });
@endpush
