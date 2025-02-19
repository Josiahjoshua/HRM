<?php

namespace App\Http\Controllers;

use App\Models\Assetlist;
use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeAsset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeAssetController extends Controller
{
    public function index($asset_id)
    {
        $asset_list = Assetlist::where('id', $asset_id)->first();
        if ($asset_list) {
            $employees = User::select('id', 'name')->orderBy('created_at', 'DESC')->get();
            return view('asset.asset_list.asset-assigning', compact('asset_list', 'employees'));
        }
        Alert::danger('danger!', 'Data not found!');
        return redirect()->back();
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',

        ]);
        $asset_id = $request->input('asset_id');
        // dd($asset_id);
        $assetlist = Assetlist::where('id', $asset_id)->first();
        
              if ($assetlist) {

                if ($assetlist->assetAssign == 1) {
                    Alert::info('Info!', 'Asset already assigned to employee!');
                    return redirect()->back();
                } else {
                         $assetlist->statusAssign = 1;
                         $assetlist->employee_id = $request->input('employee_id');
                         $assetlist->assign_date = $request->input('assign_date');
                          $assetlist->save();
                          
                    Alert::success('success!', 'Asset Assigned');
                    return redirect()->back();
                }

        }

        Alert::error('error!', 'Data not found');
        return redirect()->back();
        
    }
    
     public function assetReturn(Request $request)
    {
        
        $asset_id = $request->input('asset_id');
        $assetlist = Assetlist::where('id', $asset_id)->first();
        
                      if ($assetlist) {
                         $assetlist->statusAssign = 2;
                         $assetlist->return_date = $request->input('return_date');
                          $assetlist->save();
                          
                    Alert::success('success!', 'Asset Returned');
                    return redirect()->back();
                }

        

        Alert::error('error!', 'Data not found');
        return redirect()->back();

    }
    
         public function assetRetain(Request $request)
    {
        
        $asset_id = $request->input('asset_id');
        
        $assetlist = Assetlist::where('id', $asset_id)->first();
        
                      if ($assetlist) {
                         $assetlist->statusSale = 2;
                         $assetlist->sale_date = $request->input('sale_date');
                          $assetlist->save();
                          
                    Alert::success('success!', 'Asset Retained');
                    return redirect()->back();
                }

        

        Alert::error('error!', 'Data not found');
        return redirect()->back();

    }
    
             public function assetSale(Request $request)
    {
        
        $asset_id = $request->input('asset_id');
        $assetlist = Assetlist::where('id', $asset_id)->first();
         
                      if ($assetlist) {
                         $assetlist->statusSale = 1;
                         $assetlist->sale_date = $request->input('sale_date');
                         $assetlist->sale_price = $request->input('sale_price');
                          $assetlist->save();
                          
                    Alert::success('success!', 'Asset Sold');
                    return redirect()->back();
                }

        

        Alert::error('error!', 'Data not found');
        return redirect()->back();

    }
    
    
    public function edit($asset_id, $employee_asset_id)
    {
    }
    public function show($asset_id, $employee_asset_id)
    {
    }
    public function update(Request $request, $asset_id, $employee_asset_id)
    {
    }
    public function returned($asset_id, $employee_asset_id)
    {
        $employee_asset = EmployeeAsset::where('id', $employee_asset_id)->whereHas("assetlist", function ($q) use ($asset_id) {
            return $q->where('assetlist_id', $asset_id);
        })->where('status', '!=', 'returned')->first();

        if ($employee_asset) {
            DB::beginTransaction();
            $updated =  $employee_asset->update([
                'status' => 'returned',
                'return_date' => Carbon::now()->format('Y-m-d')
            ]);

            DB::commit();
            Alert::success('success!', 'Asset Returned');
            return redirect()->back();
        }
        Alert::error('error!', 'Data not found');
        return redirect()->back();

    }
}
