@extends('layout')


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.css" />
@endsection


@section('content')
    <div class="row">


        <div class="col-md-10 col-sm-12 m-auto p-5">

            <h2 class="text-center  mb-5 mt-5 ">
                Historical quotes of {{ $formData['company'] }} ({{$formData['company_symbol']}}) for the period {{ $formData['start_date'] }} - {{ $formData['end_date'] }}
            </h2>


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
                            {{ $date= \App\Adapters\DateToTimeAdapter::toDate($row['date']) }}
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

            <h2 class="text-center m-5">
                Open and Close prices chart for the same period
            </h2>

            <div id="stock_div" class="w-100 mt-5" ></div><br>
            <div class="w-100 mb-5 text-center" >
                <button id="linear">Linear Scale</button>&nbsp;
                <button id="log" disabled="true">Log Scale</button>
            </div>


            <div class="text-left mb-5 text-center">
                <a href="{{ route('index') }}" class="btn btn-primary">Try again with different settings</a>
            </div>


        </div>

    </div>

@endsection



@section('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.js"></script>
    <script>
        $(document).ready(function() {

            //initialize datatable
            $('#results').DataTable({
                scrollX:true
            });


            //initialize stocks chart
            const graphData = <?php echo json_encode($openClosedPricesGraphData) ?>;
            const adjustedData = graphData.map(function(el){
                return [new Date(el[0]),el[1],el[2]]
            })
            const g = new Dygraph(document.getElementById("stock_div"), adjustedData,
                {
                    labels: [ "Day", "Open", "Close" ],
                    logscale: true,
                });

            const linear = document.getElementById("linear");
            const log = document.getElementById("log");
            const setLog = function(val) {
                g.updateOptions({ logscale: val });
                linear.disabled = !val;
                log.disabled = val;
            };
            linear.onclick = function() { setLog(false); };
            log.onclick = function() { setLog(true); };
        });
    </script>


@endsection
