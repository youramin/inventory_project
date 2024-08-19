<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
 
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price', 'product_code', 'description', 'quantity', 'category_id', 'image' ];

    protected $appends = ['latest_stock_update', 'current_stock'];

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

    public function getCurrentStockAttribute()
    {
        return ($this->stockEntries()->sum('quantity') ?? 0) - ($this->stockExits()->sum('quantity') ?? 0);
    }

    public function getLatestStockUpdateAttribute()
    {
        $latestEntry = $this->stockEntries()->orderBy('entry_date', 'desc')->first();
        $latestExit = $this->stockExits()->orderBy('exit_date', 'desc')->first();
        $latestDate = null;

        if ($latestEntry && $latestExit) {
            $latestDate = $latestEntry->entry_date > $latestExit->exit_date ? $latestEntry->entry_date : $latestExit->exit_date;
        } elseif ($latestEntry) {
            $latestDate = $latestEntry->entry_date;
        } elseif ($latestExit) {
            $latestDate = $latestExit->exit_date;
        }

        return $latestDate ? Carbon::parse($latestDate) : null;
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
