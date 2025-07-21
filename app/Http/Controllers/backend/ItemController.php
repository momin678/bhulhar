<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Item;
use App\Unit;
use App\Zisprink;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items=Item::get();
        $units=Unit::get();
        return view('backend.items.index', compact('items','units'));
    }

    public function store(Request $request)
    {
        Item::create([
            'name' => $request->item_name,
            // 'unit_id' => $request->unit
        ]);
        return back()->with('success','Item Successfully Added');
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        $notification = array(
            'message'       => 'Item Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('item')->with($notification);
    }

   
}
