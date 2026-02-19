<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'image_url',
        'category_id',
        'file',
    ];

    protected $hidden = [
        'file',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'product_attributes');
    }

    public function getPriceAttribute($value)
    {
        return str_replace('.00','',$value);
    }
    public function getImageUrlAttribute($value)
    {
        return 'https://adlaw.info/storage/' . $value;
    }
}
