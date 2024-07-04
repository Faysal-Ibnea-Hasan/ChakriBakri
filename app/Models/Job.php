<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'tbl_jobs';

    public function jobType(){
        return $this->belongsTo(JobType::class);
    }
    public function catagory(){
        return $this->belongsTo(Catagory::class);
    }

}
