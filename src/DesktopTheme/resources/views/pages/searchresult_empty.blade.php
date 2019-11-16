@extends('layouts.3columns')

@section('custom')
    <div class="pagecontent">
        <div class="container">
            <h1>
                No search results found for "{{ $keywords }}"
            </h1>
            <div>
                <p>You may have typed your word incorrectly, check your spelling and try again.</p>
            </div>
        </div>
    </div>
@endsection
