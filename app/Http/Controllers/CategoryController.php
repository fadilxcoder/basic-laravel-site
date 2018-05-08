<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data = DB::select('SELECT * FROM categories');
        return view('categories/category', ['data'=>$data]);
    }
    
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|unique:categories'
        ]);
        
        $category = new Category;
        $category->category = $request->input('category');
        $category->save();
        return redirect('/category')->with('response','Category Added successfully');
    }

    public function retrieveByCategory($catId)
    {
        $posts = DB::table('posts')->where('category_id', '=', $catId)->latest()->paginate(1);
        $categories = Category::all();
        return view('categories/category-posts', ['posts'=>$posts, 'categories'=>$categories]);
    }
}
