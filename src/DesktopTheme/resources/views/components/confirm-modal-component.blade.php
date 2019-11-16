<div class="modal" tabindex="-1" role="dialog" id="confirmModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 id="confirm-modal-message" style="text-align: center;"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirm-btn">Continue</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        var passedData = '';
        windowLib.onMessage('confirm-action', function(data){
            passedData = data;
            var $confirmMessage = $('#confirm-modal-message');
            switch(data['mode']){
                case 'delete':
                    $confirmMessage.html('Are you sure to delete this address?');
                    break;
                case 'default_billing':
                    $confirmMessage.html('Are you sure to set this address as your default invoice address?');
                    break;
                case 'default_delivery':
                    $confirmMessage.html('Are you sure to set this address as your default delivery address?');
                    break;
            }
            $('#confirmModal').modal('show');
        });

        $('#confirm-btn').click(function(){
            windowLib.sendMessage('address-confirm-init', passedData);
        });
    })
@endpush


