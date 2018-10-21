<form class="form-horizontal">
  @if ($customer->addresses ?? false)
  <div class="radio">
    <label>
      <input type="radio" name="shipping_address" value="existing" checked="checked" />
      {{ text_address_existing }}</label>
  </div>
  <div id="shipping-existing">
    <select name="address_id" class="form-control">
     @foreach ($customer->addresses as $address)
      @if ($address->address_id == $address_id)
      <option value="{{ $address->address_id }}" selected="selected">{{ $address->firstname }} {{ $address->lastname }}, {{ $address->address_1 }}, {{ $address->city }}, {{ $address->zone }}, {{ $address->country }}</option>
      @else
      <option value="{{ $address->address_id }}">{{ $address->firstname }} {{ $address->lastname }}, {{ $address->address_1 }}, {{ $address->city }}, {{ $address->zone }}, {{ $address->country }}</option>
      @endif
      @endforeach
    </select>
  </div>
  <div class="radio">
    <label>
      <input type="radio" name="shipping_address" value="new" />
      {{ 'text_address_new' }}</label>
  </div>
  @endif
  <br />
  <div id="shipping-new" style="display: @if ($addresses)none@elseblock@endif;">
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-firstname">{{ 'entry_firstname' }}</label>
      <div class="col-sm-10">
        <input type="text" name="firstname" value="" placeholder="{{ 'entry_firstname' }}" id="input-shipping-firstname" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-lastname">{{ 'entry_lastname' }}</label>
      <div class="col-sm-10">
        <input type="text" name="lastname" value="" placeholder="{{ 'entry_lastname' }}" id="input-shipping-lastname" class="form-control" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-shipping-company">{{ 'entry_company' }}</label>
      <div class="col-sm-10">
        <input type="text" name="company" value="" placeholder="{{ 'entry_company' }}" id="input-shipping-company" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-address-1">{{ 'entry_address_1' }}</label>
      <div class="col-sm-10">
        <input type="text" name="address_1" value="" placeholder="{{ entry_address_1 }}" id="input-shipping-address-1" class="form-control" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-shipping-address-2">{{ entry_address_2 }}</label>
      <div class="col-sm-10">
        <input type="text" name="address_2" value="" placeholder="{{ 'entry_address_2' }}" id="input-shipping-address-2" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-city">{{ entry_city }}</label>
      <div class="col-sm-10">
        <input type="text" name="city" value="" placeholder="{{ 'entry_city' }}" id="input-shipping-city" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-postcode">{{ entry_postcode }}</label>
      <div class="col-sm-10">
        <input type="text" name="postcode" value="{{ 'postcode' }}" placeholder="{{ 'entry_postcode' }}" id="input-shipping-postcode" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-country">{{ 'entry_country' }}</label>
      <div class="col-sm-10">
        <select name="country_id" id="input-shipping-country" class="form-control">
          <option value="">{{ text_select }}</option>
          @foreach ($country in countries)
          @if ($country->country_id == country_id)
          <option value="{{ $country->country_id }}" selected="selected">{{ $country->name }}</option>
          @else
          <option value="{{ $country->country_id }}">{{ $country->name }}</option>
           @endif
           @endforeach
        </select>
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-zone">{{ 'entry_zone' }}</label>
      <div class="col-sm-10">
        <select name="zone_id" id="input-shipping-zone" class="form-control">
        </select>
      </div>
    </div>
   @foreach ($custom_field in custom_fields)
    @if ($custom_field.type == 'select')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field{{ custom_field.custom_field_id }}">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <select name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" class="form-control">
          <option value="">{{ text_select }}</option>
          @foreach ($custom_field_value in custom_field.custom_field_value)
          <option value="{{ custom_field_value.custom_field_value_id }}">{{ custom_field_value.name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'radio')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <div id="input-shipping-custom-field{{ custom_field.custom_field_id }}">
          @foreach ($custom_field_value in custom_field.custom_field_value)
          <div class="radio">
            <label>
              <input type="radio" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" value="{{ custom_field_value.custom_field_value_id }}" />
              {{ custom_field_value.name }}</label>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'checkbox')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <div id="input-shipping-custom-field{{ custom_field.custom_field_id }}">
          @foreach ($custom_field_value in custom_field.custom_field_value)
          <div class="checkbox">
            <label>
              <input type="checkbox" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}][]" value="{{ custom_field_value.custom_field_value_id }}" />
              {{ custom_field_value.name }}</label>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'text')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field{{ custom_field.custom_field_id }}">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <input type="text" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" value="{{ custom_field.value }}" placeholder="{{ custom_field.name }}" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" class="form-control" />
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'textarea')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field{{ custom_field.custom_field_id }}">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <textarea name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" rows="5" placeholder="{{ custom_field.name }}" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" class="form-control">{{ custom_field.value }}</textarea>
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'file')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <button type="button" id="button-shipping-custom-field{{ custom_field.custom_field_id }}" data-loading-text="{{ text_loading }}" class="btn btn-default"><i class="fa fa-upload"></i> {{ button_upload }}</button>
        <input type="hidden" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" value="" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" />
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'date')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field{{ custom_field.custom_field_id }}">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <div class="input-group date">
          <input type="text" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" value="{{ custom_field.value }}" placeholder="{{ custom_field.name }}" data-date-format="YYYY-MM-DD" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'time')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field{{ custom_field.custom_field_id }}">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <div class="input-group time">
          <input type="text" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" value="{{ custom_field.value }}" placeholder="{{ custom_field.name }}" data-date-format="HH:mm" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
    </div>
    @endif
    @if ($custom_field.type == 'time')
    <div class="form-group@if ($custom_field.required) required @endif custom-field" data-sort="{{ custom_field.sort_order }}">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field{{ custom_field.custom_field_id }}">{{ custom_field.name }}</label>
      <div class="col-sm-10">
        <div class="input-group datetime">
          <input type="text" name="custom_field[{{ custom_field.location }}][{{ custom_field.custom_field_id }}]" value="{{ custom_field.value }}" placeholder="{{ custom_field.name }}" data-date-format="YYYY-MM-DD HH:mm" id="input-shipping-custom-field{{ custom_field.custom_field_id }}" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
    </div>
    @endif
    @endforeach
  </div>
  <div class="buttons clearfix">
    <div class="pull-right">
      <input type="button" value="{{ button_continue }}" id="button-shipping-address" data-loading-text="{{ text_loading }}" class="btn btn-primary" />
    </div>
  </div>
</form>
<script type="text/javascript"><!--
$('input[name=\'shipping_address\']').on('change', function() {
	if (this.value == 'new') {
		$('#shipping-existing').hide();
		$('#shipping-new').show();
	} else {
		$('#shipping-existing').show();
		$('#shipping-new').hide();
	}
});
//--></script>
<script type="text/javascript"><!--
$('#collapse-shipping-address .form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#collapse-shipping-address .form-group').length-2) {
		$('#collapse-shipping-address .form-group').eq(parseInt($(this).attr('data-sort'))+2).before(this);
	}

	if ($(this).attr('data-sort') > $('#collapse-shipping-address .form-group').length-2) {
		$('#collapse-shipping-address .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('#collapse-shipping-address .form-group').length-2) {
		$('#collapse-shipping-address .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#collapse-shipping-address .form-group').length-2) {
		$('#collapse-shipping-address .form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('#collapse-shipping-address button[id^=\'button-shipping-custom-field\']').on('click', function() {
	var element = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(element).button('loading');
				},
				complete: function() {
					$(element).button('reset');
				},
				success: function(json) {
					$(element).parent().find('.text-danger').remove();

					if (json['error']) {
						$(element).parent().find('input[name^=\'custom_field\']').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(element).parent().find('input[name^=\'custom_field\']').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	language: '{{ datepicker }}',
	pickTime: false
});

$('.time').datetimepicker({
	language: '{{ datepicker }}',
	pickDate: false
});

$('.datetime').datetimepicker({
	language: '{{ datepicker }}',
	pickDate: true,
	pickTime: true
});
//--></script>
<script type="text/javascript"><!--
$('#collapse-shipping-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#collapse-shipping-address select[name=\'country_id\']').prop('disabled', true);
		},
		complete: function() {
			$('#collapse-shipping-address select[name=\'country_id\']').prop('disabled', false);
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value="">{{ text_select }}</option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '{{ zone_id }}') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected">{{ text_none }}</option>';
			}

			$('#collapse-shipping-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#collapse-shipping-address select[name=\'country_id\']').trigger('change');
//--></script>