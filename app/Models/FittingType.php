<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FittingType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'standard_time',
        'unit', 'description', 'is_active', 'sort_order'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class);
    }

    public function getFormattedTimeAttribute()
    {
        $hours = intdiv($this->standard_time, 60);
        $mins = $this->standard_time % 60;
        if($hours > 0) {
            return "{$hours}h {$mins}m";
        }
        return "{$mins} mins";
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}