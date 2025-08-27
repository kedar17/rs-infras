<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingType extends Model
{
    protected $fillable = [
        'type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    
}