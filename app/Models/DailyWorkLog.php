<?php
namespace App\Models;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DailyWorkLog extends Model
{
    protected $fillable = [
        'work_description',
        'project_id',
        'user_id',
        'weather',
        'daily_log_photos',
        'work_summary',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}