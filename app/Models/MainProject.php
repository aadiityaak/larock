<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainProject extends Model
{
    use HasFactory;
    protected $table = 'tb_cs_main_project';

    public function webhost()
    {
        return $this->belongsTo(Webhost::class, 'id_webhost');
    }
}
