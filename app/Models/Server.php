<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $table = 'tb_server';
    protected $primaryKey = 'id_server';

    function project()
    {
        return $this->belongsTo(MainProject::class, 'id_server');
    }
}
