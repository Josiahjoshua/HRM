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

class CasualDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   $casual= Casual::all();

        return view('employee.casualWorkerDetails', compact('casual'));
    }

    public function store(Request $request)
    {
        $dateWorked = $request->input('date');
        $hoursWorked = $request->input('hours'); 
       
        // Retrieve the agreed amount from Casuals table
        $casual = Casual::where('id', $request->input('casual_id'))->first();
        $casualPayment = CasualPaymentDetails::where('id', $request->input('casual_id'))->first();
       
        $agreedAmount = $casual->amount;
    
        // Calculate the due amount
        $dueAmount = $agreedAmount * $hoursWorked;
        
        // dd($dueAmount);
    
    // create a new row in the casual_worker_hours table
    $casualDetails = new CasualDetails();
    $casualDetails->date = $dateWorked;
     $casualDetails->hours = $hoursWorked;
      $casualDetails->casual_id = request('casual_id');
      $casualDetails->due_amount = $dueAmount;
       $casualDetails->save();

        // Update the total due amount in the Casuals table
        $casual->total_due_amount += $dueAmount;
        $casual->save();
        return redirect()->back();
    }
    

    public function viewCasual($id)
    {
        $casual = DB::table('casuals')->find($id);
        if (!$casual) {
            abort(404);
        }

        $casualDetails = DB::table('casual_details')
        ->select('id','hours','date','due_amount')
        ->where('casual_id',$id)
        ->get();
        $casualPayment = DB::table('casual_payment_details')
        ->select('id','paid_amount','dateofPay','remaining_amount','description')
        ->where('casual_id',$id)
        ->get();
        
        $totalDueAmount = collect($casualDetails)->sum('due_amount') - collect($casualPayment)->sum('paid_amount');
      

        return view('employee.casualWorkerDetails', compact('casualDetails','casual','casualPayment','totalDueAmount'));
    }
    
    public function edit($id) {
    $casual = CasualDetails::findOrFail($id);
    return view('employee.editCasualHours', compact('casual'));
}




public function update(Request $request, $id) {
    $request->validate([
        'date' => 'required|date',
        'hours' => 'required|numeric',
    ]);

    $casualDetails = CasualDetails::findOrFail($id);
    $casual = Casual::findOrFail($casualDetails->casual_id);

    # Calculate the new due amount based on the updated hours
    $newDueAmount = $casual->amount * $request->input('hours');
    

    $casualDetails->date = request('date');
     $casualDetails->hours = request('hours');
     $casualDetails->due_amount = $newDueAmount;
       $casualDetails->save();

     Alert::success('Success!', 'Casual Worker Timesheet updated successfully!');
    return back();
}



# Query: Destroy method modification to update total_due_amount in casual table upon deletion

public function destroy($id)
{
    $casualDetails = CasualDetails::findOrFail($id);

    # Delete the CasualDetails record
    $casualDetails->delete();

    Alert::success('Success!', 'Successfully deleted');
    return back();
}

}
