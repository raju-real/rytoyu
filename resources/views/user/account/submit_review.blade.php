@extends('user.layouts.app')
@section('title','Submit Review')
@push('css')
    <style>
        .left {
            text-align: left;
        }

        .rating {
            /*display: flex; !* Position to right *!*/
            /*flex-direction: row-reverse; !* Puts 5-star on the right, 1-star on the left *!*/
            flex-direction: row; /* Arranges items from left to right (1, 2, 3, 4, 5) */
            /*justify-content: flex-end; !* Aligns stars to the right edge of the container *!*/
            /* Removed justify-content: left as it conflicts with row-reverse */
        }

        .rating > input {
            display: none; /* Hides the actual radio buttons */
        }

        .rating > label {
            position: relative;
            width: 1em;
            font-size: 35px;
            color: #FFD600; /* Star color when not selected */
            cursor: pointer;
            text-align: center; /* Center the star within its 1em width */
        }

        .rating > label::before {
            content: "\2605"; /* Unicode star character */
            position: absolute;
            opacity: 0; /* Hidden by default */
            left: 0; /* Align the star within the label's space */
            top: 0;
            width: 100%;
            height: 100%;
            display: flex; /* Use flex to center the star visually if needed */
            justify-content: center;
            align-items: center;
        }

        /* Hover effect: Show filled stars */
        .rating > label:hover:before,
        .rating > label:hover ~ label:before {
            opacity: 1 !important; /* Forces visibility on hover */
        }

        /* Checked state: Show filled stars from the checked one to the right */
        .rating > input:checked ~ label:before {
            opacity: 1;
        }

        /* Dim checked stars when hovering over other stars (e.g., changing mind) */
        .rating:hover > input:checked ~ label:before {
            opacity: 0.4;
        }

        /* --- Additional styling for demonstration --- */
        .review-form {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding in width */
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .selected-rating-display {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
    </style
@endpush

@section('content')
    <section class="page-section">
        <div class="wrap container">
            <div class="row">
                <!--start sidebar-->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="widget account-details">
                        <h2 class="widget-title">Account</h2>
                        @include('user.account.menus')
                    </div>
                </div>
                <!--end sidebar-->
                <!--start main contain of page-->
                <div class="col-lg-9 col-md-9 col-sm-8">
                    <div class="information-title">Submit Review</div>
                    <div class="details-wrap">
                        <div class="block-title alt"><i class="fa fa-angle-down"></i> Submit Review</div>
                        <div class="details-box">
                            @if(Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif
                            <form class="form-delivery" action="{{ route("store-review", $order_product->id) }}"
                                  method="POST">
                                @csrf
                                <div class="all-form">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-4">
                                            <div class="rating">
                                                @for($i = 5; $i >= 1; $i--)
                                                    {{-- Loop from 5 down to 1 --}}
                                                    <input type="radio" name="rating" value="{{ $i }}"
                                                           id="{{ $i }}" {{ $order_product?->review?->rating == $i ? 'checked' : '' }}>
                                                    <label for="{{ $i }}">☆</label>
                                                @endfor
                                            </div>

                                            @error('rating')
                                            {!! displayError($message) !!}
                                            @enderror

                                            <div id="selectedRatingDisplay" class="selected-rating-display">
                                                Selected Rating: None
                                            </div>
                                            <textarea class="form-control" name="comment"
                                                      placeholder="Comment">{{ $order_product->review->comment ?? '' }}</textarea>
                                            @error('comment')
                                            {!! displayError($message) !!}
                                            @enderror

                                        </div>
                                        <div class="col-md-12 col-sm-12 text-right">
                                            <button class="btn btn-theme btn-upa" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end main contain of page-->

            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ratingInputs = document.querySelectorAll('.rating input[name="rating"]');
            const reviewForm = document.getElementById('reviewForm');
            const selectedRatingDisplay = document.getElementById('selectedRatingDisplay');

            // Function to update the display when a rating is selected
            function updateSelectedRatingDisplay() {
                const checkedRating = document.querySelector('.rating input[name="rating"]:checked');
                if (checkedRating) {
                    selectedRatingDisplay.textContent = `Selected Rating: ${checkedRating.value} Star(s)`;
                } else {
                    selectedRatingDisplay.textContent = 'Selected Rating: None';
                }
            }

            // Add event listener to each radio input
            ratingInputs.forEach(input => {
                input.addEventListener('change', updateSelectedRatingDisplay);
            });

            // Initialize display on page load (in case a rating is pre-checked by PHP)
            updateSelectedRatingDisplay();
        });
    </script>
@endpush
