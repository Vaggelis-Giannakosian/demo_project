<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>XS Demo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="row">

        <h2 class="text-center w-100 mb-5">
            XS DEMO
        </h2>

            <div class="col-sm-12">
                <form action="{{ route('store') }}" method="POST" class="form_validate">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">

                            <label for="company_symbol">Company Symbol</label>
                            <select name="company_symbol"  class="form-control select2 @error('company_symbol') is-invalid @enderror" required id="company_symbol">
                                <option selected disabled value="">Choose one of the Symbols</option>
                                @foreach($companySymbols as $symbol)
                                    <option value="{{ $symbol }}">{{$symbol}}</option>
                                @endforeach
                            </select>
                            <x-errors type="company_symbol"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="inputEmail4" required placeholder="Email">
                            <x-errors type="email"/>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="s_date">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}" class="form-control datepicker @error('start_date') is-invalid @enderror" required id="s_date" >
                            <x-errors type="start_date"/>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="e_date">End Date</label>
                            <input type="text" name="end_date" value="{{ old('end_date') }}"  class="form-control datepicker @error('end_date') is-invalid @enderror" required id="e_date" >
                            <x-errors type="end_date"/>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary float-right">Sumbit</button>
                </form>

            </div>
    </div>
</div>
<script  src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script>

$(document).ready(function () {
    $('.datepicker').datepicker({
        startDate: '0d',
        todayHighlight:true,
        orientation: 'bottom',
        format:'yyyy-mm-dd',
    });
    $('.select2').select2();

    $('.form_validate').validate({
        debug: true,
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            element.closest('.form-group').append(error)
            // error.insertAfter();
        }
    });
});

</script>
</body>
</html>
