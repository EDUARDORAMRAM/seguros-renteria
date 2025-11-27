<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asegurado extends Model
{
    use HasFactory;

    protected $table = 'asegurados';
    protected $primaryKey = 'IdAsegurado';

    protected $fillable = [
        'Nombre',
        'ApellidoPaterno',
        'ApellidoMaterno',
        'Telefono',
        'Email',
        'RFC',
        'Referencia',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'IdAsegurado', 'IdAsegurado');
    }

    public function polizasActivas()
    {
        return $this->hasMany(Poliza::class, 'IdAsegurado', 'IdAsegurado')
            ->where('Estatus', 'Activa');
    }

    // Scopes
    public function scopeBuscar($query, $busqueda)
    {
        return $query->where(function($q) use ($busqueda) {
            $q->where('Nombre', 'like', "%{$busqueda}%")
              ->orWhere('ApellidoPaterno', 'like', "%{$busqueda}%")
              ->orWhere('ApellidoMaterno', 'like', "%{$busqueda}%")
              ->orWhere('RFC', 'like', "%{$busqueda}%")
              ->orWhere('Email', 'like', "%{$busqueda}%")
              ->orWhere('Telefono', 'like', "%{$busqueda}%");
        });
    }

    // Atributos
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->Nombre} {$this->ApellidoPaterno} {$this->ApellidoMaterno}");
    }
    public function getInicialesAttribute()
    {
        $nombre = substr($this->Nombre, 0, 1);
        $apellido = substr($this->ApellidoPaterno, 0, 1);
        return strtoupper($nombre . $apellido);
    }

    public function getTotalPolizasAttribute()
    {
        return $this->polizas()->count();
    }

    public function getTotalPolizasActivasAttribute()
    {
        return $this->polizasActivas()->count();
    }
}