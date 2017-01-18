<?php
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $primaryKey = 'user_id';

    protected $table = 'users';

    protected $fillable = ['user_id', 'user_name', 'user_pswd', 'register_time', 'last_login_time'];
}