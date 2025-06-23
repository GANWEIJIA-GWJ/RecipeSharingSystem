<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'description', 
        'category_id','
        ingredients', 
        'steps', 
        'photo_url', 
        'prep_time'];
        
    public function category(){
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
        'prep_time' => 'integer', // Cast prep_time to integer
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
