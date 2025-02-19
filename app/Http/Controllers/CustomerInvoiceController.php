<?php

// Ensure to use the correct namespace declaration
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\PDF;
use Spatie\Pdf\Structure;
use Dompdf\Options;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderReportExport;
use Illuminate\Support\Facades\View;

class CustomerInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $invoices = Invoice::all();
        $invoiceDetails = InvoiceDetail::all();
        
        return view('invoice.show', compact('invoices', 'invoiceDetails'));
    }


 
  public function store(Request $request)
    {
        
            $validatedData = $request->validate([
                'customer_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'service.*' => 'required',
                'price.*' => 'required',
                'quantity.*' => 'required',
                'unit.*' => 'required',
                'date' => 'required',
                'purchaseOrderNumber' => 'required',
                'unit' => 'required',
                'currency' => 'required',
                'clientOrderNumber' => 'nullable',
                'discount' => 'nullable',

            ]);
        
        // Find the latest invoice number for the current date
    $latestInvoice = Invoice::whereDate('created_at', today())->latest('inv_number')->first();

    // If no invoice exists for today, start the counter from 1
    $counter = $latestInvoice ? (int)substr($latestInvoice->inv_number, -2) + 1 : 1;

    $invoiceNumber = date('ymd') . sprintf('%02d', $counter);

    // Increment the counter for the next iteration
    $counter++;

        $invoice = new Invoice();
        $invoice->customer_name = $request->input('customer_name');
        $invoice->email = $request->input('email');
        $invoice->phone = $request->input('phone');
        $invoice->address = $request->input('address');
        $invoice->date = $request->input('date');
        $invoice->purchaseOrderNumber = $request->input('purchaseOrderNumber');
        $invoice->clientOrderNumber = $request->input('clientOrderNumber');
        $invoice->unit = $request->input('unit');
        $invoice->currency = $request->input('currency');
        $invoice->discount = $request->input('discount');
        $invoice->inv_number = $invoiceNumber;
        $invoice->save();

        foreach ($request->input('service') as $key => $value) {
            $product = [
                'service' => $value,
                'tax' => $request->input('tax')[$key],
                'price' => $request->input('price')[$key],
                'quantity' => $request->input('quantity')[$key],
            ];

           
            $invoiceDetail = new InvoiceDetail();
            // Set the required properties
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->service = $product['service'];
            $invoiceDetail->tax = $product['tax'];
            $invoiceDetail->price = $product['price'];
            $invoiceDetail->quantity = $product['quantity'];
            $invoiceDetail->save();
        }
        Alert::success('Success!', 'Successfully Added');
        return back();
    }
    public function destroy($id)
    {
        $invoiceDetail = InvoiceDetail::where('invoice_id', $id)->get();
        foreach ($invoiceDetail as $invoiceDetails) {
            $invoiceDetails->delete();
        }

        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        Alert::success('Success!', 'Successfully Added');
        return back();
    }   
    
      public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
      return view('invoice.edit',compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::Findorfail($id);

        $validatedData = $request->validate([
            'customer_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'service.*' => 'required',
            'price.*' => 'required',
            'quantity.*' => 'required',
            'unit.*' => 'required',
            'date' => 'required',
            'unit' => 'required',
            'currency' => 'required',
            'purchaseOrderNumber' => 'required',
            'clientOrderNumber' => 'nullable',
            'discount' => 'nullable',
        ]);

        // Update the Order record
        $invoice->date = $validatedData['date'];
        $invoice->customer_name = $validatedData['customer_name'];
        $invoice->email = $validatedData['email'];
        $invoice->phone = $validatedData['phone'];
        $invoice->address = $validatedData['address'];
        $invoice->purchaseOrderNumber = $validatedData['purchaseOrderNumber'];
        $invoice->clientOrderNumber = $validatedData['clientOrderNumber'];
        $invoice->unit = $validatedData['unit'];
        $invoice->currency = $validatedData['currency'];
        $invoice->discount = $validatedData['discount'];
        $invoice->save();

        // Update the product_orders records
        foreach ($request->input('service') as $key => $value) {
            $invoiceDetail = InvoiceDetail::where('invoice_id', $invoice->id)
            ->where('id', $key)
            ->first();
                               
            if ($invoiceDetail) {
                $invoiceDetail->service = $value;
                $invoiceDetail->tax = $request->input('tax')[$key];
                $invoiceDetail->price = $request->input('price')[$key];
                $invoiceDetail->quantity = $request->input('quantity')[$key];
                $invoiceDetail->save();
            }
        }

        Alert::success('Success!', 'Successfully Updated');
        return redirect()->route('invoice.index');
    }
    
    public function invoice_generate($id)
{
    

    $manager = User::whereHas('roles', function ($query) {
    $query->where('name', 'manager');
})->first();


       $invoice = Invoice::findorFail($id);

       $invoiceDetail = InvoiceDetail::where('invoice_id', $invoice->id)->get();
       $invoiceTotal = DB::table('invoice_details')
       ->select(
           DB::raw('SUM(price * quantity ) as subTotal'),
           DB::raw('SUM(CASE WHEN tax = "yes" THEN price * quantity * 0.18 ELSE 0 END) as total_tax')
       )
       ->where('invoice_id', $invoice->id)
       ->first();
    
       
    
    
    
      $imagePath = public_path('/dist/img/pejunlogo2.png');

        // $fontPath = storage_path('fonts/Roboto-Regular.ttf');


        // Create an instance of the PDF class with the required arguments
        $pdf = new PDF(
            app('dompdf'), // You may need to adjust this if 'dompdf' is not the correct service name
            app('config'), // Create an instance of the config repository
            app('files'), // Create an instance of the filesystem
            app('view') // The name of your view
        );

        $pdf->loadView('invoice.index', compact('invoiceTotal','manager','invoice','invoiceDetail','imagePath'));
        // $pdf->getDomPDF()->getOptions()->setFontDir($fontPath);
        $pdf->getDomPDF()->getOptions()->setDefaultFont('Roboto-Regular');
        $pdf->setPaper('A4', 'portrait');
        $pdf->setWarnings(false);

        $options = new Options();
$options->set('isPhpEnabled', true); // Enable PHP processing in your HTML
$options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
$options->set('isRemoteEnabled', true); // Allow loading external stylesheets


        return $pdf->stream('invoice.pdf');
    
}

   public function paid(Request $request)
   {
       $status = Invoice::where('id', request('invoice_id'))->first();
       $status->status = 1;
       $status->pay_date = request('pay_date');
       $status->save();
       alert::success('Success!','Pay status Succesfully Updated');
       return back();
    }

}