<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\User;
use App\Models\Contact;
class Settlement extends Model
{
    protected $fillable = [
        'project_id',
        'contact_id',
        'settled_by',
        'amount',
        'mode',
        'reference_no',
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
    public function user()
    {
        return $this->belongsTo(User::class, 'settled_by', 'id');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    
}