<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;use SoftDeletes;
    protected $table = "notes";
    protected $fillable =['id','category_id','title','description','created_at','updated_at','deleted_at'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
