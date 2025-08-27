<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Client;
class Project extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'start_date',
        'end_date',
        'budget',
        'status',
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
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    // (Optional) If you also want user data:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
