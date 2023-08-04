<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Post extends Model
{
    use HasFactory;

    // makes every fields fillable but the ones in the array
    protected $guarded = [];

    // Down the number of sql queries, eager loading by default
    protected $with = ['category', 'author'];

    // turn off mass assignement unless we have control over the array
    // protected $guarded = [];

    // makes sthe following fields fillable
    // protected $fillable = ['title'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        });
    
        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn ($query) => $query->where('slug', $category))
        );
        
    }
    


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        // Eloquent relationships: hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        // Eloquent relationships: hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(User::class, 'user_id');
    }
}
