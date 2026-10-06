<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const ADMIN = 1;
    public const ADMINROLE = 'admin';
    public const USER = 2;
    public const USERROLE = 'user';

    protected $gaurded = [];

    public function user(){
        return $this->hasOne(User::class);
    }
}
