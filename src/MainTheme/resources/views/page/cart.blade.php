@extends(config('home.layout', 'layout.default'))

@section('content')

  <h1>{{ $heading_title ?? '' }}
    @if ($weight ?? false)
    &nbsp;({{ $weight }})
    @endif </h1>
  <form action="/" method="post" enctype="multipart/form-data">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-center">{{ __('column_image') }}</td>
            <td class="text-left">{{ __('column_name') }}</td>
            <td class="text-left">{{ __('column_model') }}</td>
            <td class="text-left">{{ __('column_quantity') }}</td>
            <td class="text-right">{{ __('column_price') }}</td>
            <td class="text-right">{{ __('column_total') }}</td>
          </tr>
        </thead>
        <tbody>
        
        @foreach($cart->items as $product)
        <tr>
          <td class="text-center">
            @if ($product->thumb ) 
              <a href="{{ $product->url }}">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-thumbnail" />
              </a> 
            @endif
          </td>
          <td class="text-left">
            <a href="{{ $product->url }}">{{ $product->name }}</a> 
            @if (! $product->stock ) 
            <span class="text-danger">***</span> 
            @endif
            @if ($product->option )
            @foreach($product->option ?? [] as $option) <br />
              <small>{{ $option->name }}: {{ $option->value }}</small> 
            @endforeach
            @endif
            @if ($product->reward ) <br />
            <small>{{ $product->reward }}</small> @endif
            @if ($product->recurring ) <br />
            <span class="label label-info">{{ __('text_recurring_item') }}</span> <small>{{ $product->recurring }}</small> 
            @endif</td>
          <td class="text-left">{{ $product->model }}</td>
          <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
              <input type="text" name="quantity[{{ $product->cart_id }}]" value="{{ $product->quantity }}" size="1" class="form-control" />
              <span class="input-group-btn">
              <button type="submit" data-toggle="tooltip" title="{{ __('button_update') }}" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
              <button type="button" data-toggle="tooltip" title="{{ __('button_remove') }}" class="btn btn-danger" onclick="cart.remove('{{ $product->cart_id }}');">
                <i class="fa fa-times-circle"></i>
              </button>
              </span></div></td>
          <td class="text-right">{{ $product->price }}</td>
          <td class="text-right">{{ $product->total }}</td>
        </tr>
        @endforeach
        @foreach($vouchers ?? [] as $voucher )
        <tr>
          <td></td>
          <td class="text-left">{{ @$voucher->description }}</td>
          <td class="text-left"></td>
          <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
              <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control" />
              <span class="input-group-btn">
              <button type="button" data-toggle="tooltip" title="{{ $button_remove }}" class="btn btn-danger" onclick="voucher.remove('{{ $voucher->key }}');">
                <i class="fa fa-times-circle"></i>
              </button>
              </span></div></td>
          <td class="text-right">{{ $voucher->amount }}</td>
          <td class="text-right">{{ $voucher->amount }}</td>
        </tr>
        @endforeach
          </tbody>
        
      </table>
    </div>
  </form>
  @if ($modules ?? false)
  <h2>{{ $text_next }}</h2>
  <p>{{ $text_next_choice }}</p>
  <div class="panel-group" id="accordion">
    @foreach($modules as $module)
      {!! $module !!}
    @endforeach </div>
  @endif 
  <br />
  <div class="row">
    <div class="col-sm-4 col-sm-offset-8">
      <table class="table table-bordered">
        @if ($totals ?? false)
        @foreach($totals as $total)
        <tr>
          <td class="text-right"><strong>{{ $total->title }}:</strong></td>
          <td class="text-right">{{ $total->text }}</td>
        </tr>
        @endforeach
        @endif 
      </table>
    </div>
  </div>
  <div class="buttons clearfix">
    <div class="pull-left"><a href="{{ __('continue') }}" class="btn btn-default">{{ __('button_continue') }}</a></div>
    <div class="pull-right"><a href="{{ __('checkout') }}" class="btn btn-primary">{{ __('button_continue') }}</a></div>
  </div>
@endsection