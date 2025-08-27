<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    protected $fillable = ['project_id','labour_id','date','hours'];

    public function project(){ return $this->belongsTo(Project::class); }
    public function labour() { return $this->belongsTo(Labour::class); }
}
