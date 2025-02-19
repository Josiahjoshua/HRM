<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Balance Sheet</title>


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
            max-height: 250px;
            margin-bottom: 10px;
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


    <div class="floatRight">

        <img src="{{ $imagePath }}" alt="Logo" style="width: 250px; height: 150px;">
        

    </div>

    <div class="floatLeft">
        <h3>PEJUNI RESOURCES</h3>
        Telephone: +61470578151, +255759199623<br>
        E-mail: admin@pejuni.com</p><br><br>
        <h1 style="color: #194176">Balance Sheet</h1>
        <span style="font-size: 14px; color: #2E8B57">As on: {{ date('Y-m-d') }}</span>

    </div>


   
    @if ($types)
    <div style="margin-top: 180px;">
        @foreach ($types as $type)
            <div style="background-color: rgba(25, 65, 118); padding: 7px; border-radius: 1px; text-align: left; font-weight: bolder; font-size: 20px; color: white; margin-bottom: 10px;">{{ $type['type'] }}</div>
            <div>
               
                {{-- Check if categories exist and is an array --}}
                {{-- @if (isset($type['categories']) && is_array($type['categories'])) --}}
                    @foreach ($type['categories'] as $category)
                    <div style="background-color: rgba(25, 65, 118, 0.2); padding: 2px; border-radius: 1px; text-align: left; font-weight: bolder;"><i>{{ $category['category_name'] }}</i></div>
               
                                        <div style="padding-left: 20px;">
                            <table style="border-collapse: collapse;">
                                @foreach ($category['items'] as $item)
                                    <tr style="background-color: white">
                                        <td style="padding: 3px; width: 200px;">{{ $item['item'] }}</td>
                                        <td style="padding: 3px; width: 100px; margin-right: 20px;">{{ number_format($item['amount']) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="font-weight: bold; background-color: white">
                                    <td style="padding: 3px;  font-style: italic;">Total {{$category['category_name']}}</td>
                                    <td style="padding: 3px; margin-right: 20px;">{{ number_format($category['totalPerCategory']) }}</td>
                                </tr>
                            </table>
                        </div>
                      
                    @endforeach
                    <div style="margin-bottom: 30px; font-size: 16px; color: #194176;">
                        <hr style="border: none; border-top: 1px solid black; margin: 5px 0;">
                        <div style="font-weight: bold; display: inline-block; width: 150px;">Total {{ $type['type'] }}</div>
                        <div style="display: inline-block; width: 100px; margin-left: 300px;; font-weight: bolder;">{{ number_format($type['totalPerType']) }}</div>
                        <hr style="border: none; border-top: 1px solid black; margin: 5px 0;">
                    </div>
                {{-- @endif --}}
            </div>
        @endforeach
    </div>
@endif





    



</body>

</html>