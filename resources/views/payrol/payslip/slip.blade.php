<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Delivery Note</title>


    <style>
        /* Custom CSS styles go here */
# Query: Styling the table to have horizontal stripes and solid outer lines

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
table td:last-child {
 
}




        

body {
    font-size: 12px;
    margin: 0; /* Remove default margins to make contents cover the whole page */
    padding: 5px; /* Remove any padding to ensure full width */
    background-color: white;
}


        .float-right {
            float: right;
            width: wrap;
            height: wrap;
            margin-bottom: 20px;

        }

        .float-left {
            margin-top: 10px;
            width: 50%;
            float: left;

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

.bg1{
    background-color: #194176;
    color: white;
}

.bg2{
    background-color: rgba(169, 169, 169, 0.4);
    font-weight: bold;
    font-size: 13px;
}

.text-color{
    color: #194176;
}

    </style>


</head>

<body>
    
           <h2 class="text-color" style="text-align: center;">
               EMPLOYEE PAYSLIP
            </h2>
    

        <div class="float-left">

            
            <h2>
                PEJUNI RESOURCES
            </h2>
            MWANZA,TANZANIA<br>
            Telephone: +61470578151, +255759199623<br>
            E-mail: admin@pejuni.com<br><br>

        </div>

        <div class="float-right">

<img src="{{ $imagePath }}" alt="Logo" class="img-square" style="background-color: rgb(255, 255, 255); width: 250px; height: 150px;">
      </div>
 
        <h2 style="margin-top: 140px; color: #378640; margin-bottom: 10px; margin-left: 250px"></h2>


            <div class="card card1">
                <div class="card-header bg1">
                    <h3 class="card-title"> <b>Employee Details</b></h3>
                </div>

<div class="card-body" style="overflow: hidden;">
    <div style="float: left;">
         <b>Name:</b> {{ $employee->name }}  <br>
        <b> Phone:</b> {{ $employee->em_phone }} <br>
        <b>Address:</b> {{ $employee->em_address }} <br>
        <b> Email:</b> {{ $employee->email }}<br>
    </div>
    <div style="float: right;">
         <b>Employee Number:</b> {{ $employee->code }} <br>
        <b>Department:</b> {{ $employee->department->dep_name }}<br>
         <b>Title:</b> {{ $employee->designation->des_name }} <br>
    </div>
    <div style="clear: both;"></div>
</div>

            </div>

            <div class="card card2">
                <div class="card-header bg2">
                    <h3 class="card-title">Earnings</h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
 
                        <tbody>

                                <tr>
                                    <td>Basic Salary</td>
                                    <td>{{ number_format($basicSalary)}}</td>

                                </tr>
 
                                <tr>
                                    <td>Overtime</td>
                                    <td>{{  number_format($workOvertime) }}</td>
                                </tr>
                                @foreach($benefitsData as $benefit)
                                <tr>
                                    
                                    <td>{{ $benefit->name }}</td>
                                    <td>{{  number_format($benefit->amount) }}</td>

                                </tr>
                                  @endforeach
                                  
                                  <tr><td></td><td></td></tr>
                                  
                                <tr><td><b>Total Benefits:</b></td> <td><b>{{ number_format($totalBenefits)}}</b></td></tr>
                                <tr style="color: #194176;"><td><h3> Gross Pay: </h3></td><td> <h3><b>{{ number_format($totalBenefits + $workOvertime + $basicSalary)}}</b></h3></td></tr>

                        </tbody>
                    </table>
                   
                </div>
            </div>
            
            <div class="card card3">
                <div class="card-header bg2">
                    <h3 class="card-title">Deductions</h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
 
                        <tbody>

                                @foreach($deductionsData as $deduction) 
                                <tr>
                                    <td>{{ $deduction->name }}</td>
                                    <td>{{  number_format($deduction->amount) }}</td>
                                </tr>
                                 @endforeach
                                 <tr><td></td><td></td></tr>
                                    <tr><td><b>Total Deduction:</b></td>
                                    <td><b> {{ number_format($totalDeductions)}}</b></td>
                                 </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        



        <!--<div class="float-left-2">-->
        <!--    <div class="card card4">-->
        <!--        <div class="card-header header-bg">-->
        <!--            <h3 class="card-title">Banking Details</h3>-->
        <!--        </div>-->

        <!--        <div class="card-body">-->



        <!--            Bank:AZANIA BANK LIMITED<br>-->


        <!--            Account Type: Current Account<br>-->


        <!--            Account Number: 019000015009<br>-->


        <!--            Bank Code:AZANTZTZ<br>-->


        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->




<div style="margin-left: 450px; background-color: rgba(169, 169, 169, 0.3); padding: 10px; border-radius: 5px; text-align: center;">
    <h3 style="color: #194176;">NetPay: <b>{{ number_format($netSalary) }}</b></h3>
</div>




   <!-- Left Signature (Employee) -->
  <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 40px; float: left; text-align: center; margin-right: 20%; width: 40%;  font-weight: bold;">
    Employee Signature
  </div>

  <!-- Right Signature (Employer) -->
  <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 40px; float: right; margin-left: 20%; text-align: center; width: 40%;  font-weight: bold;">
    Employer Signature
  </div>
  
  <div style="margin-top: 90px; text-align: center;">
  <span>If you have any questions concerning this payslip, please contact us</span><br>
  
  </div>
  
    <div style="text-align: left;">
  <span class="text-primary">www.pejuni.com</span><br>
  </div>



</body>

</html>
