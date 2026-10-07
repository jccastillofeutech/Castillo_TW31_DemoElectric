<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginUser extends Model
{
    protected $table = 'user_accounts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'username', 'password'];
}
