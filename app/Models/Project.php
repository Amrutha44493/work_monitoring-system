<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_code', 'customer_id','team_leader_id', 'name',
        'site_address', 'site_city', 'start_date',
        'expected_end_date', 'actual_end_date',
        'status', 'notes'
    ];

    protected $casts = [
        'start_date'        => 'date',
        'expected_end_date' => 'date',
        'actual_end_date'   => 'date',
    ];
public function teamLeader()
{
    return $this->belongsTo(
        Employee::class, 'team_leader_id'
    );
}
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function fittingItems()
    {
        return $this->hasMany(ProjectFittingItem::class);
    }

    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'     => 'yellow',
            'in_progress' => 'blue',
            'completed'   => 'green',
            'on_hold'     => 'orange',
            'cancelled'   => 'red',
            default       => 'gray',
        };
    }

    public static function generateCode()
    {
        $prefix = 'PRJ-' . date('Y') . '-';
        $last = self::withTrashed()->latest()->first();
        $number = $last
            ? intval(substr($last->project_code, -4)) + 1
            : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalStandardTimeAttribute()
    {
        return $this->fittingItems->sum('standard_time');
    }

    public function getTotalActualTimeAttribute()
    {
        return $this->workLogs->sum('actual_time');
    }
}