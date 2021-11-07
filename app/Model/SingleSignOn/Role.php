<?php

namespace App\Model\SingleSignOn;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tb_role';

    protected $primaryKey = 'id_role';

    protected $fillable = ['role','id_user'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id_user');
    }
}
