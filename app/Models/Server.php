<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $table = 'tb_server';
    protected $primaryKey = 'id_server';

    function webhost()
    {
        return $this->belongsTo(Webhost::class, 'id_webhost', 'id_webhost');
    }
}
