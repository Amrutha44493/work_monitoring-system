<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'project_fitting_item_id',
        'employee_id',
        'team_leader_id',
        'fitting_type_id',
        'quantity',
        'standard_time',
        'assigned_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function teamLeader()
    {
        return $this->belongsTo(Employee::class, 'team_leader_id');
    }

    public function fittingType()
    {
        return $this->belongsTo(FittingType::class);
    }

    public function projectFittingItem()
    {
        return $this->belongsTo(ProjectFittingItem::class);
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
            'cancelled'   => 'red',
            default       => 'gray',
        };
    }

    public function getFormattedTimeAttribute()
    {
        $hours = intdiv($this->standard_time, 60);
        $mins  = $this->standard_time % 60;
        return $hours > 0
            ? "{$hours}h {$mins}m"
            : "{$mins} mins";
    }
}