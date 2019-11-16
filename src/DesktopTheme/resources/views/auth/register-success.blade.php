@extends('layouts.3columns')


{{--optional--}}
@section('title')
    <title>
        Alphazento | Sign up
    </title>
@endsection

@section('custom')



    <section>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">

                        <div>
                            <div>
                                <img src=@resource("/theme/images/Green_Tick.png")
                                     style="width:35px; float:left;margin-right: 10px;">
                                <h3> You account has been created!</h3>
                            </div>


                            <br>
                            <div>
                                <p>
                                    Redirecting to homepage after <strong><span id="countdown"
                                                                                class="text-primary"></span></strong>
                                    seconds
                                </p>
                            </div>
                            <div>
                                <p>
                                    Congratulations! Your new account has been successfully created! You can now take
                                    advantage of member privileges to enhance your online shopping experience with us.
                                </p>

                            </div>

                            <div>
                                <a class="btn btn-primary" href="{{ route('home') }}">
                                    Homepage <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>


@endsection

@push('footer')
    <script>
        // Total seconds to wait
        var seconds = 5;
        document.getElementById("countdown").innerHTML = seconds;

        function countdown() {
            seconds = seconds - 1;
            if (seconds < 0) {
                // Chnage your redirection link here
                window.location = '{{url('/')}}';
            } else {
                // Update remaining seconds
                document.getElementById("countdown").innerHTML = seconds;
                // Count down using javascript
                window.setTimeout("countdown()", 1000);
            }
        }

        countdown();
    </script>
@endpush
