<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FundRequest;
use App\Models\FundRequestDetails;
use App\Notifications\FundRequestApproved;
use App\Notifications\FundRequestRejected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\NewFundRequestApplicationNotification; 
use Illuminate\Support\Facades\Notification;

class FundRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('director')) {
            // If the logged-in user has the 'director' role, get all fund requests
            $fundRequest = FundRequest::all();
            $employee = auth()->user();
        } else {
            // If the user doesn't have the 'director' role, get their own fund request
            $employee_id = auth()->user()->id;
            $fundRequest = FundRequest::where('employee_id', $employee_id)->get();
            $employee = auth()->user();
        }

        
    
        return view('fundRequest.index', compact('fundRequest','employee'));
    }
    
    public function show($id)
    {
        $fundRequestDetail = FundRequestDetails::where('fundrequest_id',$id)->get();
        return view('fundRequest.show', compact('fundRequestDetail'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reason' => 'required',
            'amount' => 'required|numeric',
            'price.*' => 'required|numeric',
            'quantity.*' => 'required|numeric|min:1',
            'product_name.*' => 'required',
 
    ]);

    $employee_id=auth()->user()->id;
    
        $fundRequest = new FundRequest();
        $fundRequest->date = $validatedData['date'];
        $fundRequest->reason = $validatedData['reason'];
        $fundRequest->amount = $validatedData['amount'];
        $fundRequest->employee_id = $employee_id;
        $fundRequest->save();



foreach ($request->input('product_name') as $key => $value) {
    $cattle = [
        'product_name' => $value,
        'quantity' => $request->input('quantity')[$key],
        'price' => $request->input('price')[$key],
    ];

    // Create a new CattleAdded instance
    $fundRequestDetails = new FundRequestDetails();
    // Set the required properties
    $fundRequestDetails->fundrequest_id = $fundRequest->id;
    $fundRequestDetails->product_name = $cattle['product_name'];
    $fundRequestDetails->quantity = $cattle['quantity'];
    $fundRequestDetails->price = $cattle['price'];
       $fundRequestDetails->save();
}



    // Notify users with the role "Stock Controller" that the order has been confirmed
    $director = User::whereHas('roles', function ($query) {
        $query->where('name', 'director');
    })->get();

    Notification::send($director, new NewFundRequestApplicationNotification($fundRequest, Auth::User()->name));



        Alert::success('Success!', 'Successfully Added');
        return back();
    }


    public function edit($id)
    {
        $item = FundRequest::findOrFail($id);
        $users = User::select('id', 'name')->get();
        return view('fundRequest.edit', [
            'item' => $item,
            'users' => $users,
            $id,
        ]);
    }
    public function update(Request $request,$id) {
        $fundRequest = FundRequest::Findorfail($id);
        
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reason' => 'required',
            'amount' => 'required|numeric',
            'price.*' => 'required|numeric',
            'quantity.*' => 'required|numeric|min:1',
            'product_name.*' => 'required',
 
    ]);
        
      $employee_id=auth()->user()->id;

        $fundRequest->date = $validatedData['date'];
        $fundRequest->reason = $validatedData['reason'];
        $fundRequest->amount = $validatedData['amount'];
        $fundRequest->employee_id = $employee_id;
        $fundRequest->save();

        // Update the cattle_added records
        foreach ($request->input('product_name') as $key => $value) {
            $fundRequestDetails = FundRequestDetails::where(
                'fundrequest_id',
                $fundRequest->id
            )
                ->where('id', $key)
                ->first();
            if ($fundRequestDetails) {
                $fundRequestDetails->product_name = $value;
                $fundRequestDetails->quantity = $request->input('quantity')[$key];
                $fundRequestDetails->price =  $request->input('price')[$key];
                $fundRequestDetails->save();
            }
        }

    Alert::success('Success!', 'Successfully Updated');
    return redirect()->route('fundRequest.index');
    }


public function destroy($id)
{
    // Find the cattlefromsuppliers record
    $data = FundRequest::findOrFail($id);

    // Delete the associated records in cattle_added
    FundRequestDetails::where('fundrequest_id', $data->id)->delete();

    // Delete the cattlefromsuppliers record
    $data->delete();

    Alert::success('Success!', 'Successfully deleted');
    return redirect()->route('fundRequest.index');
}

public function destroyFundRequestItem($id)
{
    $data = FundRequestDetails::findOrFail($id);
    $data->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
}


    public function hrView()
    {

            $fundRequest = FundRequest::all();

        return view('fundRequestApprove.hrApprove', compact('fundRequest'));
    }



public function approve($id)
{
  $data = FundRequest::findOrFail($id);
  $data->status = 1; //Approved
  $data->approverName  = Auth::user()->name;
  $data->save();
  $data->user->notify(new FundRequestApproved($data, Auth::user()->name));
  Alert::success('Approved!', 'Fund request approved');
  return back(); //Redirect user somewhere
}

public function decline(Request $request)
{  
    $fundRquestId = $request->input('fund_request_id'); 
  $data = FundRequest::findOrFail($fundRquestId);
  $data->status = 0; //Declined
  $data->approverName  = Auth::user()->name;
  $data->rejection_reason = $request->input('rejection_reason');
  $approverEmail = Auth::user()->email;
  $rejectionReason = $request->input('rejection_reason'); 
  $data->save();
  $data->user->notify(new FundRequestRejected($data, Auth::user()->name, $rejectionReason, $approverEmail));
  Alert::info('Rejected!', 'application successful rejected');
  return redirect()->back(); 

}

   public function managerView()
  {
    $employeeId = auth()->user()->id;
   

    $fundrequest = FundRequest::query()
        ->select('fund_request.*')
        ->join('users', 'users.id', '=', 'fund_request.employee_id')
        // ->where('perdeim.role', '!=', 'Hod')
        // ->where('perdeim.role', '!=', 'director')
        // ->whereNotIn('employee_id', [$employeeId])
        ->get();

    $employee = User::select('id', 'name')->get();
    // $leave_type = Leave_type::select('id', 'leavename')->get();
      return view('fundRequestApprove.managerApprove', compact('fundrequest','employee'));
  }

  public function managerApprove($id)
  {
    
    $fundrequest = FundRequest::findOrFail($id);
    $fundrequest->statusManager = 1; //Approved
    $fundrequest->managerApprover = Auth::user()->name;
    $fundrequest->save();
    $approverEmail = Auth::user()->email;
    $fundrequest->user->notify(new FundRequestApproved($fundrequest, Auth::user()->name));
    Alert::success('Approved!', 'Fund request approved');
    return redirect()->back(); //Redirect user somewhere
  }

  public function managerDecline(Request $request)
  {

    $fundRequestId = $request->input('fund_request_id'); 
    $data = FundRequest::findOrFail($fundRequestId);
    $data->statusManager = 0; //Declined
    $data->managerApprover  = Auth::user()->name;
    $data->rejection_reason = $request->input('rejection_reason');
    $approverEmail = Auth::user()->email;
    $rejectionReason = $request->input('rejection_reason'); 
    $data->save();
    $data->user->notify(new FundRequestRejected($data, Auth::user()->name, $rejectionReason, $approverEmail));
    Alert::success('Rejected!', 'application successful rejected');
    return redirect()->back();

  }
  

  
    public function drView()
  {
    
      $fundrequest = FundRequest::all();
      
      $employee= User::select('id', 'name')->get();
      return view('fundRequestApprove.drApprove', compact('fundrequest','employee'));
  }

  public function drApprove($id)
  {
 
    $fundrequest = FundRequest::findOrFail($id);
    $fundrequest->statusDr = 1; //Approved
     $fundrequest->drApprover = Auth::user()->name;
    $fundrequest->save();
    $approverEmail = Auth::user()->email;
    $fundrequest->user->notify(new FundRequestApproved($fundrequest, Auth::user()->name));
    Alert::success('Approved!', 'Fund Request request approved');
    return redirect()->back(); //Redirect user somewhere
  }

  public function drDecline(Request $request)
  {
 
    $fundRequestId = $request->input('fund_request_id'); 
    $data = FundRequest::findOrFail($fundRequestId);
    $data->statusDr = 0; //Declined
    $data->drApprover  = Auth::user()->name;
    $data->rejection_reason = $request->input('rejection_reason');
    $approverEmail = Auth::user()->email;
    $rejectionReason = $request->input('rejection_reason'); 
    $data->save();
    $data->user->notify(new FundRequestRejected($data, Auth::user()->name, $rejectionReason, $approverEmail));
    Alert::success('Rejected!', 'application successful rejected');
    return redirect()->back();

  }


}
