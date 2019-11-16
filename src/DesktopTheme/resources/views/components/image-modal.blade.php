@push('styles')
    .modal {
        display: none;
        position: fixed;
        z-index: 10000;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, .7);
    }

    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        width: 90%;
        max-width: 800px;
    }

    .modal-nested-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding-top: 20px;
        padding-bottom: 20px;
        height: 80%;
        width: 80%;
        max-width: 800px;
    }

    .close {
        background-color: rgba(0, 0, 0, .9);
        color: white;
        padding: 8px 12px;
        position: absolute;
        right: 0;
        font-size: 35px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #999;
        text-decoration: none;
        cursor: pointer;
    }

    img.hover-shadow {
        transition: 0.3s;
    }

    .hover-shadow:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .image-notice-text{
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        color:gray;
    }
@endpush

<div class="modal" id="image_modal">
    <div class="modal-content">
        <div>
            <span class="close cursor">&times;</span>
        </div>
        <div class="modal-nested-content">
            <div>
                <img src="{{ $product->getOriginalImageUrl() }}" alt="{{trim($productName)}}"
                     style="width:100%; height:100%;">
            </div>
        </div>
        <div class="image-notice-text">
            <label>Image may differ from actual product.</label>
        </div>
    </div>
</div>

@pushonce('image-modal', 'rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        var imageModal = document.getElementById('image_modal');

        var span = document.getElementsByClassName("close")[0];

        windowLib.onMessage('open-image-modal', function(){
            imageModal.style.display = "block";
        });

        span.onclick = function () {
            imageModal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == imageModal) {
                imageModal.style.display = "none";
            }
        }
    });
@endpushonce