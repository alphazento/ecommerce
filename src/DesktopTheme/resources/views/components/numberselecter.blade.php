@push('styles')
    .searched-products__select{
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        appearance: none;
        background: #fff url(@asset("/tonercitytheme/assets/img/select-bg.svg")) no-repeat 100% 45%;
        background-size: 30px 60px;
        border: 1px solid #ccc;
        height: 35px;
        padding: 5px 20px;
        text-indent: .01em;
        text-overflow: '';
        font: 14px/18px "Open Sans",Arial,Helvetica,sans-serif;
        border-radius: 2px;
        width: 68px;
        display: inline-block;
    }
@endpush
<select class="searched-products__select"
@foreach($properties as $name=>$v)
{{ $name }} = "{{ $v }}"
@endforeach
>
    @if(isset($default))
    <option disabled selected value>{{$default}}</option>
    @endif
    @for ($i = $from; $i <= $to; $i++)
        <option value="{{ $i }}" {{ isset($selected) && $selected == $i ? 'selected' : '' }}>{{ $i }}</option>
    @endfor
    @if (isset($selected) && $selected > $to)
        <option value="{{ $selected }}" selected>{{ $selected }}</option>
    @endif
</select>
