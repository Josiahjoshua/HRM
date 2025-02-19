<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceSheetItem;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BalanceSheetItemController extends Controller
{
  public function index()
  {

    return view('balanceSheet.index');
  }



  public function store(Request $request)
  {
    $request->validate([
      
      'amount' => 'required',
      'item' => 'required',
      'category_id' => 'required'
    ]);

    $item = new BalanceSheetItem();
    $item->category_id = request('category_id');
    $item->amount = request('amount');
     $item->item = request('item');
    $item->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function destroy($id)
  {

    $item = BalanceSheetItem::findOrFail($id);
    $item->delete();
    Alert::success('Success!', 'Successfully deleted');
    return back();
  }

  public function edit($id)
  {

    $item = BalanceSheetItem::findOrFail($id);
   
    return view('balanceSheet.edit', compact('item'));
  }

public function update(Request $request, $id)
{
    $item = BalanceSheetItem::find($id);
    
    // Validate the request data
    $request->validate([
      
      'amount' => 'required',
      'item' => 'required',
    ]);

    $item->amount = request('amount');
     $item->item = request('item');
    $item->save();
    Alert::success('Success!', 'Successfully updated');
    return back();
  }

 
}
