@extends('layouts.3columns')

@section('custom')

    <section>
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <h2>You are now securely logged out.</h2>
                    <br>
                    <div>
                        <p>
                            Redirecting to homepage after <strong><span id="countdown"
                                                                        class="text-primary"></span></strong> seconds
                        </p>

                        <p>
                            You have been logged off your account. It is now safe to leave the computer.
                        </p>

                        <p> Your shopping cart has been saved, the items inside it will be restored whenever you log
                            back into your
                            account.
                        </p>
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

        // Run countdown function
        countdown();
    </script>
@endpush
