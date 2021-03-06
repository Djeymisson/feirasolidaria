<?php

namespace projetoGCA;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'telefone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function contato(){
        return $this->hasOne('projetoGCA\Contato');
    }

    public function consumidores(){
        return $this->hasMany(Consumidor::class, 'user_id', 'id');
    }
}
