<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Assetlist;
use App\Models\Depreciation;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetListController extends Controller
{
    public function index()
    {

        $assetlist = Assetlist::with('asset')->get();
        $ass = Asset::select('id', 'category_type')->get();
                    $employees = User::select('id', 'name')->orderBy('created_at', 'DESC')->get();
        return view('asset.asset_list.index',  ['assetlist' => $assetlist, 'ass' => $ass, 'employees' => $employees]);
    }

    public function store(Request $request)
    {

        $asset_list = new Assetlist();
        $asset_list->asset_name = request('asset_name');
        $asset_list->asset_id = request('asset_id');
        if( $request->input('asset_brand') ){ $asset_list->asset_brand = request('brand');}
        if( $request->input('asset_model') ){ $asset_list->asset_model = request('model');}
        $asset_list->asset_code = request('code');
        if( $request->input('config') ){ $asset_list->configuration = request('config');}
        $asset_list->purchase_date = request('purchase');
        $asset_list->price = request('price');
        $asset_list->depr_rate = request('depr_rate');
        $asset_list->depr_interval = request('depr_interval');
        $asset_list->save();
        Alert::success('Success!', 'Successfully added');
        return back();
    }

    public function edit($id)
    {

        $assetlist = Assetlist::findOrFail($id);
        $asset = Asset::select('id', 'category_type')->get();
        return view('asset.asset_list.edit', ['assetlist' => $assetlist, 'asset' => $asset]);
    }

    public function update(Request $request, Assetlist $assetlist)
    {


        $request->validate([
            'asset_name' => 'required',
            'category_type' => 'required',
            'asset_brand' => 'nullable',
            'asset_model' => 'nullable',
            'asset_code' => 'required',
            'config' => 'nullable',
            'purchase_date' => 'required',
            'price' => 'required',
            'depr_rate' => 'nullable',
            'depr_interval' => 'nullable',
        ]);

            $assetlist->update($request->all());
            Alert::success('Success!', 'Successfully updated');
            return back();

    }
    public function viewDepreciation($asset_id)
    {
        $asset_list = Assetlist::where('id', $asset_id)->first();
        if ($asset_list) {
            return view('asset.asset_list.depreciation-list', compact('asset_list'));
        }
        Alert::warning('Warning!', 'Data not found!');

        return redirect()->back();
    }
    public function addDepreciation($asset_id)
    {
        // Step 1: Retrieve necessary information from the assetlist table
        $asset = DB::table('assetlist')->where('id', $asset_id)->first();
        $purchase_price = $asset->price;
        $depr_rate = $asset->depr_rate;
        $purchase_date = $asset->purchase_date;

        // Step 2: Get the current date
        $currentDate = date('Y-m-d');

        // Step 3: Check if a depreciation entry already exists for the asset on the current date
        $existingEntry = DB::table('depreciations')
            ->where('assetlist_id', $asset_id)
            ->where('date', $currentDate)
            ->first();

        if ($existingEntry) {
            // An entry already exists for the asset on the current date, do not add a new entry
            return redirect()->back()->with('error', 'Depreciation for this asset on the current date already exists.');
        }

        // Step 4: Calculate the number of days since the purchase date
        $daysSincePurchase = floor((strtotime($currentDate) - strtotime($purchase_date)) / (60 * 60 * 24));

        // Step 5: Calculate the depreciated value based on the number of days since purchase
        $depreciatedValue = 0;

        // Subsequent depreciation, based on previous depreciated value
        $previousDepreciation = DB::table('depreciations')
            ->where('assetlist_id', $asset_id)
            ->orderBy('date', 'desc')
            ->first();

        if ($previousDepreciation) {
            $previousDepreciatedValue = $previousDepreciation->depreciated_value;
            $depreciatedValue = $previousDepreciatedValue * ($depr_rate / 36500) * $daysSincePurchase;
        } else {
            $depreciatedValue = $purchase_price * ($depr_rate / 36500) * $daysSincePurchase;
        }


        // Step 6: Store the depreciated value and date in the depreciations table
        DB::table('depreciations')->insert([
            'assetlist_id' => $asset_id,
            'depreciated_value' => $depreciatedValue,
            'date' => $currentDate
        ]);

        return redirect()->back()->with('success', 'Depreciation added successfully.');
    }
    
    public function destroy($id)
    {
        $asset = Assetlist::findorFail($id);
        $asset->delete();
        alert::success('Success','Asset deleted succesfully' );
        return back();
    }
}
