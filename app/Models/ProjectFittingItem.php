<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFittingItem extends Model
{
    protected $fillable = [
        'project_id',
        'fitting_type_id',
        'quantity',
        'standard_time',
        'actual_time',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fittingType()
    {
        return $this->belongsTo(FittingType::class);
    }

    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class);
    }

    public function getTotalStandardTimeAttribute()
    {
        return $this->standard_time * $this->quantity;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'     => 'yellow',
            'in_progress' => 'blue',
            'completed'   => 'green',
            default       => 'gray',
        };
    }
}