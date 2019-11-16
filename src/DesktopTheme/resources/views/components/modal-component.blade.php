<div class="modal {{ ($fade ?? false) ? 'fade' : '' }} tc__modal"
     id="{{ $refId }}"
     data-backdrop="static"
     data-keyboard="false"
     role="dialog">
    <div class="modal-dialog {{ ($large ?? false) ? 'modal-lg' : '' }} {{ ($center ?? false) ? 'modal-dialog-centered' : '' }}">
        <div class="modal-content tc__modal-content__{{$refId}}">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
            </div>

            <div class="modal-body" style="overflow-y: unset">
                <div class="alert alert-danger modal-messagebox" style="display:none;"></div>
                @include($contentTemplate, ["formId" => "tc-modal-form-" . $refId])
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light modal__close-btn"
                        data-dismiss="modal"
                        value="{{$refId}}"
                >Close</button>
                @yield("{$refId}_submitButton")
            </div>

        </div>

    </div>
</div>

@pushonce('modal-component', 'rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        $(".tc__modal").on('shown.bs.modal', function(){

        });

        $(".tc__modal").on('hide.bs.modal', function() {
            var modal = $(this).getModal();
            modal.clearValidation();
            modal.displayMessage();
        });

        if ($.fn && $.fn.getModal === undefined) {
            $.fn.getModal = function (selector) {
                if (selector !== undefined) {
                    return $(selector);
                }
                var modal = $('.tc__modal.show');
                if (modal.length) {
                    return modal;
                }
            }
        }

        if ($.fn && $.fn.clearValidation === undefined) {
            $.fn.clearValidation = function () {
                $(this).find("form").each(function(){
                    var form = $(this);
                    var v = form.validate();
                    $('[name]', form[0]).each(function () {
                        v.successList.push(this);
                        v.showErrors();
                    });
                    v.resetForm();
                    v.reset();
                })
            };
        }

        if ($.fn && $.fn.displayMessage === undefined) {
            $.fn.displayMessage = function (message) {
                var msgBox = $(".modal-dialog > .modal-content > .modal-body > .modal-messagebox", this);
                if (msgBox.length) {
                    if (message && message !== '') {
                        msgBox.show().html(message);
                    } else {
                        msgBox.hide();
                    }
                }
            }
        }

        if ($.fn && $.fn.setModalTitle === undefined) {
            $.fn.setModalTitle = function (title) {
                var box = $(".modal-dialog > .modal-content > .modal-header > .modal-title", this);
                if (box.length) {
                    box.html(title);
                }
            }
        }
    })
@endpushonce
