<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;
class Task extends Model
{
    protected $fillable = [
        'title',
        'project_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'descriptions'
    ];
    //protected $fillable = ['client_id','name','start_date','end_date','budget','status','user_id'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    // 2) The client() relationship
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    // (Optional) If you also want user data:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
}
