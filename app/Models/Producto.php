<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Producto extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nombre',
        'idFamilia',
        'idElaboraciones',
        'idTipo',
        'imagen',
        'precio',
        'descripcion',
    ];


    /*public function personalTrabajando()
    {
        return $this->belongsTo(User::class, "personal_id", "id");
    }*/

}
