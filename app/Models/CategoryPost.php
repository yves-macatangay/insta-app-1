<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table = 'category_post'; //for non-plural form table names
    public $timestamps = false; // do not save timestamps
    protected $fillable = ['category_id', 'post_id']; //for use of create() / createMany()

    //category_post belongs to category
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
