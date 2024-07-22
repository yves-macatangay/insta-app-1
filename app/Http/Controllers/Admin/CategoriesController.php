<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post; 

class CategoriesController extends Controller
{
    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->orderBy('name')->paginate(10);

        //count uncategorized posts
        $all_posts = $this->post->all();
        $uncategorized = 0;
        foreach($all_posts as $post){
            if($post->categoryPosts->count() == 0){
                $uncategorized++; //add 1 to $uncategorized
            }
        }

        return view('admin.categories.index')
                            ->with('all_categories', $all_categories)
                            ->with('uncategorized_count', $uncategorized);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = $request->name;
        $this->category->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->category->destroy($id);

        return redirect()->back();
    }
    public function update(Request $request, $id){
        $request->validate([
            'categ_name'.$id => 'required|max:50|unique:categories,name,'.$id
        ],[
            'categ_name'.$id.'.required' => 'Name is required',
            'categ_name'.$id.'.max' => 'Maximum of 50 characters only',
            'categ_name'.$id.'.unique' => 'That name already exists'
        ]);

        $category = $this->category->findOrFail($id);
        $category->name = $request->input('categ_name'.$id);
        $category->save();

        return redirect()->back();
    }
}
