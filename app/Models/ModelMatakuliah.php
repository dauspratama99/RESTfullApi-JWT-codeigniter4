<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMatakuliah extends Model
{
    protected $table            = 'tb_matakuliah_2110062';
    protected $primaryKey       = 'kodemtk_2110062';
    protected $allowedFields    = [
        'kodemtk_2110062','namamtk_2110062','sksmtk_2110062'
    ];


}
