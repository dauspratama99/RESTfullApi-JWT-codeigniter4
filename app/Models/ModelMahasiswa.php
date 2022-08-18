<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model
{
   
    protected $table            = 'tb_mahasiswa';
    protected $primaryKey       = 'mhsnobp';
    protected $allowedFields    = [
        'mhsnobp','mhsnama','mhsalamat','prodinama','mhstgllhr'
    ];

}
