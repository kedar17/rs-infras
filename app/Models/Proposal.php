<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'date',
        'reference',
        'client_name',
        'client_address',
        'client_mobile',
        'subject',
        'body_intro',
        'items',
        'price_total',
        'price_gst_percent',
        'price_in_words',
        'scope_of_work',
        'warranty',
        'payment_schedule',
        'notes',
        'signatory_name',
        'signatory_role',
    ];

    protected $casts = [
        'items'             => 'array',
        'scope_of_work'     => 'array',
        'warranty'          => 'array',
        'payment_schedule'  => 'array',
        'notes'             => 'array',
    ];
}