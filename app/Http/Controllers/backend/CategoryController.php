<?php

namespace App\Http\Controllers\backend;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class CategoryController extends Controller
{
    public function index()
    {
        $categories=Category::get();
        $category = new Category();

        return view('backend.category.index',compact('categories','category'));
    }

    public function store(Request $request)
    {
        Category::create(
            $request->validate([
                'name' => 'required|unique:categories,name',
            ])
        );

        $notification= array(
            'message'       => 'Category Added successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }

    public function edit(Category $category)
    {
        $categories=Category::get();
        return view('backend.category.index',compact('categories','category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id,
        ]);
        $category = Category::find($category->id);
        $category->name = $request->name;
        $category->save();
        $notification= array(
            'message'       => 'Category Updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('service-inventory/category')->with($notification);
    }


    public function destroy($id)
    {

        $cat = Category::find($id);
        $cat->delete();
        $notification= array(
            'message'       => 'Category Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('category')->with($notification);
    }

}
