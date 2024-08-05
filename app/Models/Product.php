<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price', 'product_code', 'description', 'quantity', 'category_id'];

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
