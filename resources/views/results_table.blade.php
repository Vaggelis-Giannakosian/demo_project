@extends('layout')


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@endsection


@section('content')
    <div class="row">

        <h2 class="text-center w-100 mb-5 mt-5">
            Historical quotes for Symbol {{$formData['company_symbol']}} for the period {{ $formData['start_date'] }} - {{ $formData['end_date'] }}
        </h2>

        <div class="col-sm-8 m-auto">

            <div class="text-left mb-5">
                <a href="{{ route('index') }}" class="btn btn-primary">Try again with different settings</a>
            </div>

            <table id="results" class="table table-striped table-bordered w-100">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Open</th>
                    <th>High</th>
                    <th>Low</th>
                    <th>Close</th>
                    <th>Volume</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tableData as $row)
                    @if( isset($row['type']) )
                        @continue
                    @endif
                    <tr>
                        <td>
                            {{ \App\Adapters\DateToTimeAdapter::toDate($row['date']) }}
                        </td>
                        <td>
                            {{ $row['open'] }}
                        </td>
                        <td>
                            {{ $row['high'] }}
                        </td>
                        <td>
                            {{ $row['low'] }}
                        </td>
                        <td>
                            {{ $row['close'] }}
                        </td>
                        <td>
                            {{ $row['volume']  }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Date</th>
                    <th>Open</th>
                    <th>High</th>
                    <th>Low</th>
                    <th>Close</th>
                    <th>Volume</th>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>

@endsection



@section('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#results').DataTable();
        } );
    </script>
@endsection
