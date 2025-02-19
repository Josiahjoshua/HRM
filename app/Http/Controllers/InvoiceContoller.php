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

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $invoice = Invoice::all();
        $invoiceDetail = InvoiceDetail::all();
        
        return view('invoice.index', compact('invoice', 'invoiceDetail'));
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
            'date' => 'required',
            'due_date' => 'required',
            'purchaseOrderNumber' => 'required',
        ]);

        $invoice = new Invoice();
        $invoice->customer_name = $request->input('customer_name');
        $invoice->email = $request->input('email');
        $invoice->phone = $request->input('phone');
        $invoice->address = $request->input('address');
        $invoice->date = $request->input('date');
        $invoice->due_date = $request->input('due_date');
        $invoice->purchaseOrderNumber = $request->input('purchaseOrderNumber');
        $invoice->clientOrderNumber = $request->input('clientOrderNumber');
        $invoice->inv_number = date('ymd') . sprintf('%02d', $counter);
        $invoice->save();

        foreach ($request->input('service') as $key => $value) {
            $product = [
                'service' => $value,
                'tax' => $request->input('tax')[$key],
                'price' => $request->input('price')[$key],
            ];

           
            $invoiceDetail = new InvoiceDetail();
            // Set the required properties
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->service = $product['service'];
            $invoiceDetail->tax = $product['tax'];
            $invoiceDetail->price = $product['price'];

            
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
            'date' => 'required',
            'due_date' => 'required',
            'purchaseOrderNumber' => 'required',
        ]);

        // Update the Order record
        $invoice->date = $validatedData['date'];
        $invoice->customer_name = $validatedData['customer_name'];
        $invoice->email = $validatedData['email'];
        $invoice->phone = $validatedData['phone'];
        $invoice->address = $validatedData['address'];
        $invoice->save();

        // Update the product_orders records
        foreach ($request->input('service') as $key => $value) {
            $invoiceDetail = InvoiceDetail::where('invoice_id', $invoice->id)
                                ->first();
            if ($invoiceDetail) {
                $invoiceDetail->service = $value;
                $invoiceDetail->tax = $request->input('tax')[$key];
                $invoiceDetail->price = $request->input('price')[$key];
                $invoiceDetail->save();
            }
        }

        Alert::success('Success!', 'Successfully Updated');
        return back();
    }
    
public function invoice_generate($id) {

    $manager = User::whereHas('roles', function ($query) {
        $query->where('name', 'manager');
    })->first();

    $invoice = Invoice::with('invoiceDetail')->findOrFail($id);

    $subTotal = $invoice->invoiceDetail->sum('amount');
    $total_tax = $invoice->invoiceDetail->sum(function($detail) {
        return $detail->tax * $detail->amount;
    });

    $imagePath = public_path('/dist/img/pejunlogo2.png');
    $fontPath = storage_path('fonts/Roboto-Regular.ttf');

    $pdf = new PDF(
        app('dompdf'),
        app('config'),
        app('files'),
        app('view')
    );

    $pdf->loadView('invoice.index', compact('manager','invoice','invoiceDetail','imagePath','subTotal', 'total_tax'));
    $pdf->getDomPDF()->getOptions()->setFontDir($fontPath);
    $pdf->getDomPDF()->getOptions()->setDefaultFont('Roboto-Regular');
    $pdf->setPaper('A4', 'portrait');
    $pdf->setWarnings(false);

    $options = new Options();
    $options->set('isPhpEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    return $pdf->stream('invoice.pdf');

}

}