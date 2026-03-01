<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'quantity_unit',
        'featured',
        'available',
        'store_id',
        'category_id'
    ];

    protected $translatable = ['name', 'description', 'quantity_unit'];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'featured' => 'boolean',
        'available' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(512)
            ->height(512)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->width(128)
            ->height(128)
            ->sharpen(10);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class, setting('custom_field_models', []));
        if (!$hasCustomField) {
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields', 'custom_fields.id', '=', 'custom_field_values.custom_field_id')
            ->where('custom_fields.in_table', '=', $this->table)
            ->get()->toArray();

        return convertToAssoc($array, 'name');
    }

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(EProvider::class, 'store_id', 'id');
    }

    public function discountables()
    {
        return $this->morphMany('App\Models\Discountable', 'discountable');
    }

    public function hasDiscountPrice()
    {
        return $this->discount_price > 0;
    }

    public function getDiscountPriceAttribute($value)
    {
        return $value ?? 0;
    }

    public function scopeNear($query, $latitude, $longitude, $areaLimitInKm = 40)
    {
        return $query->whereHas('store', function ($q) use ($latitude, $longitude, $areaLimitInKm) {
            $q->near($latitude, $longitude, $areaLimitInKm);
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    public function scopePopular($query)
    {
        return $query->withCount('orders')
            ->orderBy('orders_count', 'desc');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\CartItem', 'product_id');
    }
}