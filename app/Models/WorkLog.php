<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkLog extends Model
{
    protected $fillable = [
        'work_assignment_id', 'employee_id',
        'project_id', 'fitting_type_id',
        'start_time', 'end_time',
        'actual_time', 'standard_time',
        'variance', 'efficiency', 'notes', 'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fittingType()
    {
        return $this->belongsTo(FittingType::class);
    }

    public function workAssignment()
    {
        return $this->belongsTo(WorkAssignment::class);
    }

    public function calculateActualTime()
    {
        if($this->start_time && $this->end_time) {
            $this->actual_time = $this->end_time
                ->diffInMinutes($this->start_time);
            $this->variance = $this->actual_time
                - $this->standard_time;
            $this->efficiency = $this->actual_time > 0
                ? round(($this->standard_time
                    / $this->actual_time) * 100, 2)
                : 0;
            $this->save();
        }
    }

    public function getFormattedActualTimeAttribute()
    {
        if(!$this->actual_time) return 'In Progress';
        $hours = intdiv($this->actual_time, 60);
        $mins  = $this->actual_time % 60;
        return $hours > 0 ? "{$hours}h {$mins}m" : "{$mins}m";
    }
}