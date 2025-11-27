<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    use HasFactory;

    protected $table = 'companias';
    protected $primaryKey = 'IdCompania';

    protected $fillable = [
        'Nombre',
        'Cobertura',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'IdCompania', 'IdCompania');
    }

    public function polizasActivas()
    {
        return $this->hasMany(Poliza::class, 'IdCompania', 'IdCompania')
            ->where('Estatus', 'Activa');
    }

    // Scopes
    public function scopeBuscar($query, $busqueda)
    {
        return $query->where(function($q) use ($busqueda) {
            $q->where('Nombre', 'like', "%{$busqueda}%")
              ->orWhere('Cobertura', 'like', "%{$busqueda}%");
        });
    }

    // Atributos
    public function getTotalPolizasAttribute()
    {
        return $this->polizas()->count();
    }

    public function getTotalPolizasActivasAttribute()
    {
        return $this->polizasActivas()->count();
    }

    public function getPrimasTotalesAttribute()
    {
        return $this->polizasActivas()->sum('Prima');
    }
}