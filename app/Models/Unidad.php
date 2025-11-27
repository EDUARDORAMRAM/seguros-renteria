<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidads';
    protected $primaryKey = 'IdUnidad';

    protected $fillable = [
        'VIN',
        'TipoUnidad',
        'Marca',
        'Submarca',
        'Anio',
        'NoSerie',
        'Motor',
        'Placas',
        'Color',
        'Uso',
    ];

    protected $casts = [
        'Anio' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'IdUnidad', 'IdUnidad');
    }

    public function polizaActiva()
    {
        return $this->hasOne(Poliza::class, 'IdUnidad', 'IdUnidad')
            ->where('Estatus', 'Activa')
            ->latest('FechaInicio');
    }

    // Scopes
    public function scopeBuscar($query, $busqueda)
    {
        return $query->where(function($q) use ($busqueda) {
            $q->where('VIN', 'like', "%{$busqueda}%")
              ->orWhere('Marca', 'like', "%{$busqueda}%")
              ->orWhere('Submarca', 'like', "%{$busqueda}%")
              ->orWhere('Placas', 'like', "%{$busqueda}%")
              ->orWhere('NoSerie', 'like', "%{$busqueda}%");
        });
    }

    // Atributos
    public function getDescripcionCompletaAttribute()
    {
        return trim("{$this->Marca} {$this->Submarca} {$this->Anio}");
    }

    public function getTienePolizaVigenteAttribute()
    {
        return $this->polizaActiva()->exists();
    }
}