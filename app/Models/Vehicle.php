<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'brand',
        'model',
        'year',
        'mileage',
        'fuel_type',
        'transmission',
        'color',
        'price',
        'state',
        'city',
        'images',
        'is_featured',
        'is_highlighted',
        'highlight_color',
        'featured_until',
        'is_active',
        'view_count'
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_highlighted' => 'boolean',
        'is_active' => 'boolean',
        'featured_until' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where(function($q) {
                        $q->whereNull('featured_until')
                          ->orWhere('featured_until', '>', now());
                    });
    }

    public function scopeSearch($query, $filters)
    {
        return $query->when(isset($filters['brand']), function($q) use ($filters) {
                $q->where('brand', 'like', '%' . $filters['brand'] . '%');
            })
            ->when(isset($filters['model']), function($q) use ($filters) {
                $q->where('model', 'like', '%' . $filters['model'] . '%');
            })
            ->when(isset($filters['min_price']), function($q) use ($filters) {
                $q->where('price', '>=', $filters['min_price']);
            })
            ->when(isset($filters['max_price']), function($q) use ($filters) {
                $q->where('price', '<=', $filters['max_price']);
            })
            ->when(isset($filters['min_year']), function($q) use ($filters) {
                $q->where('year', '>=', $filters['min_year']);
            })
            ->when(isset($filters['max_year']), function($q) use ($filters) {
                $q->where('year', '<=', $filters['max_year']);
            })
            ->when(isset($filters['state']), function($q) use ($filters) {
                $q->where('state', $filters['state']);
            })
            ->when(isset($filters['fuel_type']), function($q) use ($filters) {
                $q->where('fuel_type', $filters['fuel_type']);
            })
            ->when(isset($filters['transmission']), function($q) use ($filters) {
                $q->where('transmission', $filters['transmission']);
            });
    }

    public function incrementViews()
    {
        $this->view_count++;
        $this->save();
    }
}