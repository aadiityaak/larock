<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhost extends Model
{
    use HasFactory;
    protected $table = 'tb_webhost';
    protected $primaryKey = 'id_webhost'; // Tentukan kunci utama tabel

    function mainproject()
    {
        return $this->belongsTo(MainProject::class, 'id_webhost');
    }

    function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    function server()
    {
        return $this->belongsTo(Server::class, 'id_server');
    }
}
