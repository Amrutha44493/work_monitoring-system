<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_code', 'name', 'phone', 'email',
        'user_id', 'team_leader_id', 'role',
        'is_active', 'joining_date'
    ];

    protected $casts = [
        'joining_date' => 'date',
        'is_active'    => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function teamLeader()
{
    return $this->belongsTo(Employee::class, 'team_leader_id')
        ->select(['id', 'name', 'employee_code']);
}

    public function teamMembers()
    {
        return $this->hasMany(Employee::class, 'team_leader_id');
    }

    public function workAssignments()
    {
        return $this->hasMany(WorkAssignment::class);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTeamLeaders($query)
    {
        return $query->where('role', 'team_leader');
    }

    public function scopeEmployees($query)
    {
        return $query->where('role', 'employee');
    }

    public static function generateCode()
    {
        $last = self::withTrashed()->latest()->first();
        $number = $last
            ? intval(substr($last->employee_code, -3)) + 1
            : 1;
        return 'EMP-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}