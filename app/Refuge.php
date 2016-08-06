<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class Refuge extends Model
{

    use SyncsWithFirebase;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'refuge';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['direccion', 'email', 'password', 'image'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
