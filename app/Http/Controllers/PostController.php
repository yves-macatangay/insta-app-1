<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post; //$this->post = new Post;
    }

    public function create(){
        $all_categories = $this->category->all();

        return view('user.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){

        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'required|max:1048|mimes:jpg,jpeg,png,gif'
        ]);

        $this->post->description = $request->description;
        $this->post->user_id = Auth::user()->id;
        $this->post->image = 'data:image/'.$request->image->extension().
                            ';base64,'.base64_encode(file_get_contents($request->image));
        $this->post->save();
        
        //save categories
        $category_posts = [];
        foreach($request->categories as $category_id){
            $category_posts []= ['category_id' => $category_id];
        }

        // $category_posts = [
        //     [
        //         'category_id' => 1
        //         'post_id' => 1
        //     ],
        //     [
        //         'category_id' => 2
        //     ]
        // ]

        $this->post->categoryPosts()->createMany($category_posts);
        //$this->categoryPost->createMany($category_posts);

        return redirect()->route('home');
    }

    public function show($id){
        $post = $this->post->findOrFail($id);

        return view('user.posts.show')->with('post', $post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);

        if($post->user_id != Auth::user()->id){
            return redirect()->route('home');
        }

        $all_categories = $this->category->all();

        $selected_categories = [];
        foreach($post->categoryPosts as $category_post){
            $selected_categories []= $category_post->category_id;
        }

        return view('user.posts.edit')
        ->with('post', $post)
        ->with('all_categories', $all_categories)
        ->with('selected_categories', $selected_categories);
    }

    public function update($id, Request $request){
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpeg,jpg,png,gif'
        ]);

        $post = $this->post->findOrFail($id);

        $post->description = $request->description;
        if($request->image){
            $post->image = 'data:image/'.$request->image->extension().
                            ';base64,'.base64_encode(file_get_contents($request->image));
        }
        $post->save();

        //update categories
        $post->categoryPosts()->delete();

        $category_posts = [];
        foreach($request->categories as $category_id){
            $category_posts []= ['category_id' => $category_id];
        }

        $post->categoryPosts()->createMany($category_posts);

        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        //$this->post->destroy($id);

        //permanent delete
        $post = $this->post->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('home');
    }
}
