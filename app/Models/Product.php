<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price', 'product_code', 'description', 'quantity', 'category_id', 'image', 'latest_stock_update', 'current_stock' ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    public function stockExits()
    {
        return $this->hasMany(StockExit::class);
    }

    public function getLatestStockUpdateAttribute()
    {
        // Implement logic to return latest stock update date
        return $this->attributes['latest_stock_update'] ?? null;
    }

    public function getCurrentStockAttribute()
    {
        // Calculate current stock
        return ($this->stock_entries_sum_quantity ?? 0) - ($this->stock_exits_sum_quantity ?? 0);
    }

   
    // Accessor for total_entries
    public function getTotalEntriesAttribute()
    {
        return $this->stockEntries()->sum('quantity');
    }

    // Accessor for total_exits
    public function getTotalExitsAttribute()
    {
        return $this->stockExits()->sum('quantity');
    }

    // Accessor for total_stock
    public function getTotalStockAttribute()
    {
        return $this->total_entries - $this->total_exits;
    }


}
