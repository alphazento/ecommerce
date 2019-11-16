@php
    $message = session()->get('message') ?? ['type' => 'default', 'body' => ''];

    if (isset($errors) && $errors->any()) {
        $message['type'] = 'error';
        $message['body'] = array_filter(
            array_merge([$message['body']], $errors->all()),
            function($body) {
                return !empty($body);
            }
        );
    }
@endphp


<div class="container">
    <div class="row">
        <div class="col-md-12">
        @if(isset($message['type']))
            @if($message['type'] == 'success')

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>
                    <div>
                        <span class="fa fa-check-circle fa-lg" aria-hidden="true"></span>
                        <span class="sr-only">Success:</span>
                        {{ $message['body'] }}
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @elseif ($message['type'] == 'error')

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>
                    <div>
                        @if(is_array($message['body'] ))

                        <ul>
                            @foreach ($message['body'] as $error)

                            <li><span class="fa fa-times-circle" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{ $error }}
                            </li>

                            @endforeach
                        </ul>

                        @else
                        <span class="fa fa-times-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        {{ $message['body'] }}
                        @endif
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

        @endif
        </div>
    </div>
</div>
