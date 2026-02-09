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
        'TipoPersona',
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

    // Mutators para guardar en mayúsculas
    protected function setRfcAttribute($value)
    {
        $this->attributes['RFC'] = strtoupper(trim($value));
    }

    protected function setNombreAttribute($value)
    {
        $this->attributes['Nombre'] = mb_strtoupper(trim($value));
    }

    protected function setApellidoPaternoAttribute($value)
    {
        $this->attributes['ApellidoPaterno'] = mb_strtoupper(trim($value));
    }

    protected function setApellidoMaternoAttribute($value)
    {
        $this->attributes['ApellidoMaterno'] = mb_strtoupper(trim($value));
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

    // Accessor para iniciales
    public function getInicialesAttribute()
    {
        $iniciales = '';
        if ($this->Nombre) {
            $iniciales .= mb_substr($this->Nombre, 0, 1);
        }
        if ($this->ApellidoPaterno) {
            $iniciales .= mb_substr($this->ApellidoPaterno, 0, 1);
        }
        return mb_strtoupper($iniciales);
    }

    // Accessor para contar pólizas totales
    public function getPolizasCountAttribute()
    {
        return $this->polizas()->count();
    }

    // Accessor para contar pólizas activas
    public function getPolizasActivasCountAttribute()
    {
        return $this->polizasActivas()->count();
    }
}
