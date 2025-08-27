<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Category;
class Budget extends Model
{
    protected $fillable = [
        'project_id',
        'category_id',
        'est_cost',
        'date',
        'remarks',
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
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
}