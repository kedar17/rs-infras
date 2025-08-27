<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Task;
class Materials extends Model
{
    protected $fillable = [
        'project_id',
        'task_id',
        'name',
        'quantity',
        'unit',
        'unit_cost',
        'vendor',
        'request_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    // 2) The project() relationship
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    
}
