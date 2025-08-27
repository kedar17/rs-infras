<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Category;
use App\Models\BillingType;
use App\Models\Client;
class Billing extends Model
{
    protected $fillable = [
        'project_id',
        'category_id',
        'type_id',
        'contact_id',
        'amount',
        'invoice_number',
        'amount',
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
    public function BillingType()
    {
        return $this->belongsTo(BillingType::class, 'type_id', 'id');
    }
    public function contact()
    {
        return $this->belongsTo(Client::class, 'contact_id', 'id');
    }
    
}