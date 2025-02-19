<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Profit Loss Report</title>


    <style>
        /* Custom CSS styles go here */

        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
            border-radius: 5px;
        }

        table,
        th,
        td {

            padding: 5px;
        }

        table tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        /* Apply solid border to the outer edges of the table */
        table th:first-child,
        table td:first-child,
        table th:last-child,
        table td:last-child {}


        body {
            font-size: 12px;
            margin: 0;
            padding: 5px;
            background-color: white;
            display: flex;
        }


        .floatRight {
            float: right;
            width: wrap;
            height: wrap;
            margin-bottom: 30px;

        }

        .floatLeft {
            margin-bottom: 30px;
            width: wrap;
            height: wrap;
            float: left;
            margin-top: 0px;

        }

        .center1 {
            width: 100%;
            margin-bottom: 30px;
            text-align: center;
            /* Center text horizontally */
        }

        .center1 img {
            display: block;
            margin: 0 auto;
            /* Center image horizontally */
            width: 250px;
            height: 150px;
        }

        .center1 h3,
        .center1 p,
        .center1 h2,
        .center1 span {
            margin: 0;
            /* Remove default margin for better centering */
        }


        .center2 {

            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;

        }

        .float-left-2 {
            margin-top: 10px;
            width: 50%;
            float: left;


        }

        .float-right-2 {
            float: right;
            width: 50%;
            margin-top: 10px;


        }

        .card1 {
            white-space: normal;
            max-height: 200px;
            margin-bottom: 10px;
            margin-top: 150px;
            width: 50%;

        }

        .card2 {

            word-wrap: break-word;
            white-space: normal;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .card3 {

            word-wrap: break-word;
            white-space: normal;
            margin-top: 10px;
            max-height: 200px;
            margin-bottom: 14px;
        }

        .card4 {

            word-wrap: break-word;
            white-space: normal;
            max-width: 200px;
            margin-bottom: 10px;
        }

        .bg1 {
            background-color: #194176;
            color: white;
            overflow: hidden;
            text-align: left;


        }

        .card-header.bg1 {
            height: auto;
            /* Allowing the card header to adjust its height based on content */
            white-space: normal;
            /* Allowing content to wrap within the card header */
        }

        .card-header.bg1 h3 {
            margin: 0;
            /* Removing margin for the card title */
            padding: 5px;
            /* Adding padding for better visibility */
        }

        .bg2 {
            background-color: #194176;
            font-weight: bold;
            font-size: 13px;
            text-align: left;
            color: white;
        }

        .text-color {
            color: #194176;
        }

        .tdstyle {
            font-weight: bold;
        }
    </style>


</head>

<body>


    <div class="center1">

        <img src="{{ $imagePath }}" alt="Logo" style="width: 250px; height: 150px;">
        <h3>PEJUNI RESOURCES</h3>
        Telephone: +61470578151, +255759199623<br>
        E-mail: admin@pejuni.com</p><br><br>

        <h2>Profit Loss Report</h2>
        <span>From {{$startDate}} to {{$endDate}}</span>
    </div>


    <div style="margin-top: 20px;">
        <div class="card card2">
            <div class="card-header">
                <h3 class="card-title">Income Details</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">


                    <thead>
                        <th>Date</th>
                        <th>From</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach($incomes as $income)
                        <tr>
                            <td>{{$income->date}}</td>
                            <td>{{$income->from}}</td>
                            <td>{{number_format($income->amount)}}</td>
                        </tr>

                        @endforeach

                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Total Income</b></td>
                            <td><b>{{number_format($totalIncome)}}</b></td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="card card2">
        <div class="card-header">
            <h3 class="card-title">Expenditure Details</h3>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">


                <thead>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    @foreach($expenditures as $expenditure)
                    <tr>
                        <td>{{$expenditure->date}}</td>
                        <td>{{$expenditure->for}}</td>
                        <td>{{number_format($expenditure->amount)}}</td>
                    </tr>

                    @endforeach

                    @foreach($perdeims as $perdeim)
                  <tr>
                      <td>{{ $perdeim->date }}</td>
                      <td>{{ $perdeim->reason }}</td>
                      <td>{{ number_format($perdeim->amount) }}</td>
                  </tr>
                  @endforeach

                  @foreach($fundRequests as $fundRequest)
                  <tr>
                      <td>{{ $fundRequest->date }}</td>
                      <td>{{ $fundRequest->reason }}</td>
                      <td>{{ number_format($fundRequest->amount )}}</td>
                  </tr>
                  @endforeach

                  <tr>
                      <td></td>
                      <td>Total Net salary</td>
                      <td>{{number_format($netSalary)}}</td>
                  </tr>


                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Total Expenditure</b></td>
                        <td><b>{{number_format($totalExpenditure)}}</b></td>
                    </tr>


                </tbody>
            </table>

        </div>
    </div>




    <h2 class="text-color" style="margin-top: 30px;">Profit/Loss: {{number_format($profitLoss)}}</h2>



</body>

</html>