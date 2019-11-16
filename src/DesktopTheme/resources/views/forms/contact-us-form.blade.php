<form name="contact_us" method="post" class="fullwidth" action="{{route('post.contact-us')}}"
      id="contact-us-form">
      @csrf_field()
    <div class="form-group">
        <label>Name <span class="required">*</span></label>
        <input name="name" value="{{old('name')}}" type="text" id="name" class="form-control" placeholder="Contact Name"
               required>

    </div>
    <div class="form-group">
        <label>Email <span class="required">*</span></label>
        <input name="email" value="{{old('email')}}" type="email" id="email" class="form-control"
               required placeholder="Contact Email">
    </div>

    {{--<div class="form-group">--}}
        {{--<label>Enquiry Type <span class="required">*</span></label>--}}
        {{--<select name="type" id="type" class="form-control">--}}
            {{--@foreach($options as $key => $option)--}}
                {{--@if (old('type') == $key)--}}
                    {{--<option value="{{$option['index']}}" selected>{{$option['topic']}}</option>--}}
                {{--@else--}}

                    {{--@if($key === 0)--}}
                        {{--<option value="{{$option['index']}}"--}}
                                {{--selected="">{{$option['topic']}}</option>--}}
                    {{--@else--}}
                        {{--<option value="{{$option['index']}}">{{$option['topic']}}</option>--}}
                    {{--@endif--}}
                {{--@endif--}}
            {{--@endforeach--}}

        {{--</select>--}}
    {{--</div>--}}

    <div class="form-group">
        <label>Phone Number (optional)</label>
        <input name="phone_number" value="{{old('phone_number')}}" type="text" id="phone_number"
               class="form-control" placeholder="Contact Number">
    </div>
    <div class="form-group">
        <label>Order Number (optional)</label>
        <input name="order_number" value="{{old('order_number')}}" type="text" id="order_number"
               class="form-control" placeholder="Order Number (If applicable)">
    </div>

    <div class="form-group">
        <label>Comment <span class="required">*</span></label>
        <textarea name="enquiry" cols="50" rows="15" wrap="soft" id="enquiry" class="form-control"
                  placeholder="Comments"
                  style="height: 200px;"
                  required
        >{{old('enquiry')}}</textarea>
    </div>
    <div class="form-group">
        {!! Recaptcha::render()!!}
        <div style="color:red;" id="captcha"></div>
    </div>
    <div class="form-group">
        <input class="button" type="submit" value="Submit" id="submitbutton">
    </div>
</form>
@push('rqjs_body')
    requirejs(['jQuery', 'jquery.validate'], function ($) {

        $('#contact-us-form').validate({
            rules: {
                email: {
                    email: true,
                    required: true
                },
                name: {
                    maxlength: 32,
                    required: true
                },
                phone_number: {
                    digits: true,
                    maxlength: 32
                },
                order_number: {
                    maxlength: 32
                },
            },
            submitHandler: function (form) {
                        @if(Recaptcha::isActive())
                var v = grecaptcha.getResponse();
                console.log("Resp" + v);
                if (v == '') {
                    document.getElementById('captcha').innerHTML = "You have to verify you are not a robot!";
                } else {
                    $("input[type=submit]").attr("disabled", "disabled");
                    form.submit();
                }
                @else
                $("input[type=submit]").attr("disabled", "disabled");
                form.submit();
                @endif
            },
        });

    });
@endpush


