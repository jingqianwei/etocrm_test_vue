<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class AdminUser extends Model
{
    use  HasApiTokens;
}
