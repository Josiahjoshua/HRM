<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Customer Invoice</title>


    <style>
        /* Custom CSS styles go here */

        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');

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
            border: 1px solid black;
        }

        .tdstyle {
        border: 1px solid black; /* Add borders to all sides of the table cells with class tdstyle */
        padding: 8px; /* Add padding to the table cells */
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
            font-size: 14px;
            margin: 0;
            padding: 0;
            background-color: white;

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
            margin-top: 450px;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 30px;

        }

        .center2 {

            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;

        }

        .float-left-2 {
            margin-top: 10px;
            width: 70%;
            float: left;


        }

        .float-right-2 {
            float: right;
            width: 30%;
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
            max-width: 370px;
            margin-bottom: 10px;
        }

        .bg1 {
            background-color: #f3ff6e;
           
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
            background-color: #f3ff6e;
            font-weight: bold;
            font-size: 13px;
            text-align: left;
          
        }

        .text-color {
            color: #f3ff6e;
        }

        .tdstyle {
            font-weight: bold;
        }
    </style>


</head>

<body>

    <div
        style="margin-bottom: 20px; height: 100px; background-color: rgb(243, 255, 110); padding: 2px; border-radius: 1px;">
        <img src="{{ $imagePath }}" alt="Logo"
            style="width: 150px; height: 80px; float: left; margin-right: 20px;">
        <h1 style="margin-top: 30px;float: left;">PEJUNI RESOURCES</h1>
        <h1 style="margin-top: 30px;float: right; font-size: 35px; margin-right: 10px;">INVOICE</h1>
    </div>





    <div class="floatLeft">

        <div>
            TFN: 125 697 216 <br>
            P.O. Box 958225  Mlimani tower, 5th Floor, Mwenge, Dar es salaam <br>
            Email: juma.mgumbwa@pejuni.com<br>
        </div>

        <div
            style="font-size: 14px; font-weight: bold; background-color: #f3ff6e; padding: 5px; border-radius: 1px;  text-align: left; margin-top: 20px">
            Bill to</div>

         {{ $invoice->customer_name }} <br>
        {{ $invoice->address }} <br>
         {{ $invoice->email }}<br>
         {{ $invoice->phone }} <br>

    </div>


    <div class="floatRight">

        <h4 style=" margin-top: 5px;">Invoice Details</h4>
        <!--<table>-->
        <!--    <tbody>-->
        <!--        <tr>-->
        <!--            <td class="tdstyle">Date</td>-->
        <!--            <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}</td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td class="tdstyle">Invoice #</td>-->
        <!--            <td>{{ $invoice->inv_number }}</td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td class="tdstyle">Client order #</td>-->
        <!--            <td>{{ $invoice->clientOrderNumber }}</td>-->
        <!--        </tr>-->
        <!--        <tr style="background-color: rgb(243, 255, 110, 0.3)">-->
        <!--            <td class="tdstyle">Due date</td>-->
        <!--            <td>{{ \Carbon\Carbon::parse($invoice->date)->addDays(30)->format('d M Y') }}</td>-->
        <!--        </tr>-->
        <!--    </tbody>-->
        <!--</table>-->

<span style="margin-left: 10px; margin-right: 70px; display: inline-block; vertical-align: middle;">Date</span>
<span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px; text-align: center; display: inline-block; width: 110px; height: 15px; vertical-align: middle;">{{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}</span> <br>
<span style="margin-left: 10px; margin-right: 45px; display: inline-block; vertical-align: middle;">Invoice #</span>
<span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px; text-align: center; display: inline-block; width: 110px; height: 15px; vertical-align: middle;">{{ $invoice->inv_number }}</span> <br>
<span style="margin-left: 10px; margin-right: 20px; display: inline-block; vertical-align: middle;">Client order #</span>
<span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px; text-align: center; display: inline-block; width: 110px; height: 15px; vertical-align: middle;">{{ $invoice->clientOrderNumber }}</span> <br>
<span style="margin-left: 10px; margin-right: 48px;  display: inline-block; vertical-align: middle;">Due date</span>
<span style=" background-color: #f3ff6e; border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px; text-align: center; display: inline-block; width: 110px; height: 15px; vertical-align: middle;">{{ \Carbon\Carbon::parse($invoice->date)->addDays(30)->format('d M Y') }}</span> <br>

    
        <span style=" margin-left: 10px; margin-right: 2px;margin-top: 40px; display: inline-block; vertical-align: middle;">Purchase Order #</span>
<span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 40px; text-align: center; display: inline-block; width: 110px; height: 15px; vertical-align: middle;">{{ $invoice->purchaseOrderNumber}}</span> <br>

    </div>


    <div style="margin-top: 250px;">
        <div class="card card2">


            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

                    <tbody>

                        <tr style="background-color: #f3ff6e">
                            <th>DESCRIPTION</th>
                            <th>UNIT PRICE({{ $invoice->currency }})</th>
                            <th>QTY({{ $invoice->unit }})</th>
                            <th>TAXED</th>
                            <th>AMOUNT({{$invoice->currency}} )</th>

                        </tr>
                       


                        @foreach ($invoiceDetail as $service)
                            <tr>

                                <td>{{ $service->service }}</td>
                                <td>{{ number_format($service->price) }}</td>
                                <td>{{ $service->quantity }} </td>
                                <td> </td>
                                <td>
                
                                    {{ number_format($service->price * $service->quantity,2)   }}

                                    
                                </td>

                            </tr>

                        @endforeach

                   


                        <tr style="font-weight: bolder">
                            <td>Total Tax(18%)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                @if ( $invoiceTotal->total_tax)
                                {{ number_format($invoiceTotal->total_tax, 2) }}  
                                @endif
                            </td>
                          
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>



    <div class="float-left-2">
        <div class="card card4">
            <div class="card-header bg2">
                <h2 class="card-title">Other Comments</h2>
            </div>

            <div class="card-body">

            1. Full payment due prior to the date of Training or an approved <br>
            2. Please include the invoice number, if paying by check <br>
            3. Payments Should be Made to:<br><br>

            <div style="margin-left: 10px; font-weight: bolder">

           Account Name:  PEJUNI RESOURCES LIMITED <br>
          Account Number: 0250211507400 US$ <br>
           Bank Name:  CRDB Bank PLC, Azikiwe Premier <br>
            P.o.Box 9531, Dar Es Salaam, Tanzania <br>
        </div>
        
            </div>
        </div>
    </div>



  <div class="float-right-2">
        <!--<span style="margin-left: 0px; margin-right: 50px;">Subtotal</span><span>-->
        <!--    {{ number_format($invoiceTotal->subTotal) }}</span><br>-->
            <span style=" margin-left: 0px; margin-right: 30px; display: inline-block; vertical-align: middle;">Subtotal</span>
            <span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px; text-align: center; display: inline-block; width: 80px; height: 15px; vertical-align: middle;">{{  number_format($invoiceTotal->subTotal, 2) }}</span> <br>
            <span style="margin-left: 0px; margin-right: 32px; display: inline-block; vertical-align: middle;">Taxable</span>
                                <span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px;  text-align: center; display: inline-block; width: 80px; height: 15px; vertical-align: middle;"></span> <br>

           
                        <span style="margin-left: 0px; margin-right: 31px; display: inline-block; vertical-align: middle;">Tax rate</span>
                                    <span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px; text-align: center; display: inline-block; width: 80px; height: 15px; vertical-align: middle;"></span> <br>

        <span style="margin-left: 0px; margin-right: 32px; display: inline-block; vertical-align: middle;">Tax due</span>
                    <span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px;  text-align: center; display: inline-block; width: 80px; height: 15px; vertical-align: middle;">{{ number_format($invoiceTotal->total_tax, 2) }}</span> <br>

       
       
                    <span style=" margin-left: 0px; margin-right: 48px; display: inline-block; vertical-align: middle;">Disc.</span>
            <span style="border: 1px solid black; padding: 5px 10px; border-radius: 1px; margin-top: 1px;  text-align: center; display: inline-block; width: 80px; height: 15px; vertical-align: middle;">{{  number_format(($invoiceTotal->subTotal + $invoiceTotal->total_tax) * $invoice->discount/100, 2) }}</span> <br>


        <!-- Adding two lines after Subtotal and Tax due -->
        <div style="border-top: 1px solid #000; padding-top: 2px; width: 100%;  margin-right: 50px;">
        </div>
        <div style="border-top: 1px solid #000; padding-top: 2px; width: 100%;  margin-right: 50px;">
        </div>

        <!-- Displaying the Total -->
        <span style="margin-bottom: 20px margin-left: 0px; margin-right: 40px;font-weight: bold; font-size: 14px color: display: inline-block; vertical-align: middle;">Total</span>
     <span style=" font-weight: bold; font-size: 14px; background-color: #f3ff6e; padding: 5px 5px; border-radius: 1px; margin-top: 1px; text-align: left; display: inline-block; width: 120px; height: 15px; vertical-align: middle;">{{ number_format($invoiceTotal->subTotal + $invoiceTotal->total_tax - (($invoiceTotal->subTotal + $invoiceTotal->total_tax) * $invoice->discount/100),2) }} {{$invoice->currency}}</span>

            
             </div>
 



<div style="margin-top: 150px;"> Make all checks payable to <br> PEJUNI RESOURCES LIMITED</div>


    <!-- Left Signature (Employee) -->
    <!--<div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 40px; float: left; text-align: center; margin-right: 20%; width: 40%;  font-weight: bold;">-->
    <!--  Employee Signature-->
    <!--</div>-->

    <!-- Right Signature (Employer) -->
    <!--<div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 40px; float: right; margin-left: 20%; text-align: center; width: 40%;  font-weight: bold;">-->
    <!--  Employer Signature-->
    <!--</div>-->

    <div style="margin-top: 90px; text-align: center;">
        <span>If you have any questions about this invoice, please contact</span><br>
        <span>[Juma Mgumbwa, Contacts in the address line above]</span>
        <h2>Thank you for your Business</h2>
    </div>

    <div style="text-align: left;">
        <span class="text-primary">www.pejuni.com</span><br>
    </div>



</body>

</html>
