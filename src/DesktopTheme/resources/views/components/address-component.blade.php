<ul>
    <li>
        <div style="word-wrap:break-word;">
            <h4>
                <span class="badge badge-dark pull-right">{{$index}}</span>
            </h4>
            <div class="block-dashboard__title">

            <h2>
                {{$addr->getFirstName() }} {{ $addr->getLastName() }}
                <span id="addressEntryId{{$addr->getId()}}"
                      class="badge badge-primary"
                      style="visibility: hidden;">current selected</span>
                @if($type==2 && $default_billing_addr_id == $addr->getId())
                    <span class="badge badge-primary">Default Invoice Address</span>
                @endif
                @if($type==2 && $default_delivery_addr_id == $addr->getId())
                    <span class="badge badge-primary">Default Delivery Address</span>
                @endif
            </h2>
            </div>
            <p>
                {{ $addr->getCompany() }}
                <br/>
                {{ $addr->getFirstName() }} {{ $addr->getLastName() }}
                <br/>
                {{ $addr->getStreet1() }}
                @if($addr->getStreet2())
                    <br/>
                    {{ $addr->getStreet2() }}
                @endif
                <br/>
                {{ $addr->getCity(',') }} {{ $addr->getState() }} {{ $addr->getPostalCode() }}
            </p>
        </div>
    </li>

    <li>
        @if($type == 1)
            <button type="button" class="btn-sm btn-success address-confirm__btn"
                address-id="{{$addr->getId()}}"
                mode="apply"
            >Apply
            </button>
            <button type="button" class="btn-sm btn-primary address-modal__btn" data-toggle="modal"
                data-target="#addressModal" address-id="{{$addr->getId()}}"
                mode="edit"
            >Edit</button>
        @endif

        @if($type == 2)
            <button type="button" class="btn-sm btn-primary address-modal__btn" data-toggle="modal"
                data-target="#addressModal" address-id="{{$addr->getId()}}"
                mode="edit"
            >Edit</button>
            <button type="button" class="btn-sm btn-danger address-confirm__btn" address-id="{{$addr->getId()}}" mode="delete">Delete</button>
            @if($default_billing_addr_id != $addr->getId())
                <button type="button" class="btn-sm btn-success address-confirm__btn" address-id="{{$addr->getId()}}" mode="default_billing">
                    Set As Default Invoice Address
                </button>
            @endif
            @if($default_delivery_addr_id != $addr->getId())
                <button type="button" class="btn-sm btn-success address-confirm__btn" address-id="{{$addr->getId()}}" mode="default_delivery">
                    Set As Default Delivery Address
                </button>
            @endif
        @endif
    </li>
</ul>

@pushonce('my-address-components', 'rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    $( document ).ready(function() {
        $('.address-modal__btn').click(function() {
            windowLib.sendMessage('address-modal-data-init', {address_id: $(this).attr('address-id'), mode: $(this).attr('mode'), modal:"#addressModal"});
        });
        $('.address-confirm__btn').click(function() {
            windowLib.sendMessage('confirm-action', {address_id: $(this).attr('address-id'), mode: $(this).attr('mode'), modal:"#addressModal"});
        });
    });
} );
@endpushonce
