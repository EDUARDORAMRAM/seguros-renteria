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

    // Mutator para RFC - siempre en mayúsculas
    protected function setRfcAttribute($value)
    {
        $this->attributes['RFC'] = strtoupper(trim($value));
    }

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

    // Scope para búsqueda
    public function scopeBuscar($query, $busqueda)
    {
        return $query->where(function($q) use ($busqueda) {
            $q->where('Nombre', 'like', "%{$busqueda}%")
              ->orWhere('ApellidoPaterno', 'like', "%{$busqueda}%")
              ->orWhere('ApellidoMaterno', 'like', "%{$busqueda}%")
              ->orWhere('Email', 'like', "%{$busqueda}%")
              ->orWhere('RFC', 'like', "%{$busqueda}%")
              ->orWhere('Telefono', 'like', "%{$busqueda}%")
              ->orWhere('Referencia', 'like', "%{$busqueda}%");
        });
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->Nombre} {$this->ApellidoPaterno} {$this->ApellidoMaterno}");
    }
}
