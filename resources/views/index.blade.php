@extends('layout')


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"/>
@endsection



@section('content')
    <div class="flex-center position-ref full-height">
        <div class="row">

            <h2 class="text-center w-100 mb-5">
                XM DEMO
            </h2>



            <div class="col-sm-10 m-auto">

                <h3 class="mb-3">
                    Check the historical quotes of a Company over a specified period of time
                </h3>

                <form action="{{ route('store') }}" method="POST" class="form_validate" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">

                            <label for="company_symbol">Company Symbol</label>
                            <select name="company_symbol"
                                    class="form-control select2 @error('company_symbol') is-invalid @enderror" required
                                    id="company_symbol">
                                <option selected disabled value="">Choose one of the Symbols</option>
                                @foreach($companySymbols as $symbol)
                                    <option @if(old('company_symbol')===$symbol) selected @endif value="{{ $symbol }}">{{$symbol}}</option>
                                @endforeach
                            </select>
                            <x-errors type="company_symbol"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" id="inputEmail4" required>
                            <x-errors type="email"/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}"
                                   class="form-control datepicker @error('start_date') is-invalid @enderror" required
                                   id="start_date">
                            <x-errors type="start_date"/>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="text" name="end_date" value="{{ old('end_date') }}"
                                   class="form-control datepicker @error('end_date') is-invalid @enderror" required
                                   id="end_date">
                            <x-errors type="end_date"/>
                        </div>
                    </div>


                    <button type="submit" value="Submit" class="btn btn-primary float-right">Submit</button>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>

        $(document).ready(function () {

            //Initialize select2 element
            $('.select2').select2();


            //Initialize datepicker elements
            $('.datepicker').datepicker({
                endDate: '+0d',
                todayHighlight: true,
                orientation: 'bottom',
                format: 'yyyy-mm-dd',
            });

            //Datepicker front end validation functionality
            $('#start_date').on('changeDate', (selected) => {
                const currentDate = new Date(selected.date.valueOf());
                const endDateInput = $('#end_date');
                if (endDateInput.val()) {
                    const eDate = new Date(endDateInput.val());
                    if (eDate.getTime() < currentDate.getTime()) {
                        endDateInput.datepicker("update", currentDate);
                    }
                }
                endDateInput.datepicker('setStartDate', currentDate);
            });


            //Form validation
            $('.form_validate').validate({
                rules: {
                    start_date: {
                        required: true,
                        date: true
                    },
                    end_date: {
                        required: true,
                        date: true
                    }
                },
                errorPlacement: function (error, element) {
                    element.closest('.form-group').append(error)
                }
            });
        });

    </script>
@endsection


