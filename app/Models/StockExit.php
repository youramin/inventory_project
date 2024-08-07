<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockExit extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'notes',
        'category_id',
        'exit_date',
        'user_id',
        'person_taking_stock'
    ];

    protected $table = 'stock_exits';
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
