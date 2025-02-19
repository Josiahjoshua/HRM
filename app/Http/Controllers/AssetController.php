<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Assetlist;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {

    $asset = Asset::all();
    return view('asset.asset_category.index', compact('asset'));
  }

  public function store(Request $request)
  {

    $asset = new Asset();
    $asset->category_type = request('cattype');
    $asset->save();
    Alert::success('Success!', 'Successfully added');
    return back();
  }

  public function edit(Request $request, $id)
  {

    $asset = Asset::findOrFail($id);
    return view('asset.asset_category.edit', compact('asset'));
  }

  public function update(Request $request, $id)
  {

    $validatedData = $request->validate(['category_type' => 'required']);
    Asset::whereId($id)->update($validatedData);
    Alert::success('Success!', 'Successfully updated');
    return redirect()->route('asset.index');
  }

  public function destroy($id)
  {
    $asset = Asset::findorFail($id);
    $asset->delete();
    alert::success('Success', 'Category deleted succesfully');
    return back();
  }


  // Function to retrieve asset category details
 public function assetCategoryDetails($id)
{
    $ass = Asset::findOrFail($id);
    $assetlist = Assetlist::where('asset_id', $ass->id)->get();
    $employees = User::select('id', 'name')->orderBy('created_at', 'DESC')->get();

    $viewName = 'asset.asset_list.' . $ass->category_type;

    return view($viewName, ['assetlist' => $assetlist, 'ass' => $ass, 'employees' => $employees]);
}




}