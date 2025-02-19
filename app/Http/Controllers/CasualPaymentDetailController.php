<?php

namespace App\Http\Controllers;
use App\Models\CasualDetails;
use App\Models\CasualPaymentDetails;
use App\Models\Material;
use App\Models\Product;
use App\Models\Casual;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CasualPaymentDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   $casualPayment= CasualPaymentDetails::all();
        return view('employee.casualWorkerDetails', compact('casualPayment'));
    }

    public function store(Request $request, CasualPaymentDetails $casualPayment)
    {
        $datePaid = $request->input('dateofPay');
        $amountPaid = $request->input('paid_amount'); 
        $description = $request->input('description'); 
       
        // Retrieve the agreed amount from Casuals table
        $casual = Casual::where('id', $request->input('casual_id'))->first();
     
        // create a new row in the casual_worker_hours table
        $casualPayment->create([
            'dateofPay' => $datePaid,
            'paid_amount' =>   $amountPaid ,
            'description'=>$description,
            'casual_id' => $casual->id,
        ]);
         $casual->total_due_amount -= $amountPaid;
        $casual->save();
            return redirect()->back();
    }
    
    
        public function edit($id) {
    $casual = CasualPaymentDetails::findOrFail($id);
    return view('employee.editCasualPayment', compact('casual'));
}




public function update(Request $request, $id) {
    $request->validate([
        'dateofPay' => 'required|date',
        'paid_amount' => 'required|numeric',
        'description' => 'required',
    ]);

    $casualPayment = CasualPaymentDetails::findOrFail($id);
    $casualPayment->dateofPay = request('dateofPay');
     $casualPayment->paid_amount = request('paid_amount');
     $casualPayment->description =  request('description');
       $casualPayment->save();

     Alert::success('Success!', 'Casual Worker Timesheet updated successfully!');
    return back();
}



    public function destroy($id)
    {
       $casualDetails= CasualPaymentDetails::findOrFail($id);
       $casualDetails->delete();
       Alert::success('Success!', 'Successfully deleted');
       return back();
    }
}
