<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
    use HasFactory;

    protected $table = 'polizas';
    protected $primaryKey = 'IdPoliza';

    protected $fillable = [
        'NumPoliza',
        'FormaPago',
        'FechaInicio',
        'FechaVencimiento',
        'Prima',
        'Estatus',
        'IdCompania',
        'IdUnidad',
        'IdAsegurado',
    ];

    protected $casts = [
        'FechaInicio' => 'datetime',
        'FechaVencimiento' => 'datetime',
        'Prima' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function compania()
    {
        return $this->belongsTo(Compania::class, 'IdCompania', 'IdCompania');
    }

    public function asegurado()
    {
        return $this->belongsTo(Asegurado::class, 'IdAsegurado', 'IdAsegurado');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'IdUnidad', 'IdUnidad');
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('Estatus', 'Activa');
    }

    public function scopeVencidas($query)
    {
        return $query->where('Estatus', 'Vencida');
    }

    public function scopeProximasAVencer($query, $dias = 30)
    {
        return $query->where('Estatus', 'Activa')
            ->whereBetween('FechaVencimiento', [
                now(),
                now()->addDays($dias)
            ]);
    }

    public function scopeBuscar($query, $busqueda)
    {
        return $query->where(function($q) use ($busqueda) {
            $q->where('NumPoliza', 'like', "%{$busqueda}%")
              ->orWhereHas('asegurado', function($q) use ($busqueda) {
                  $q->where('Nombre', 'like', "%{$busqueda}%")
                    ->orWhere('ApellidoPaterno', 'like', "%{$busqueda}%");
              })
              ->orWhereHas('compania', function($q) use ($busqueda) {
                  $q->where('Nombre', 'like', "%{$busqueda}%");
              });
        });
    }

    // Atributos calculados
    public function getDiasParaVencerAttribute()
    {
        if ($this->FechaVencimiento) {
            return now()->diffInDays($this->FechaVencimiento, false);
        }
        return null;
    }

    public function getEstaVigenteAttribute()
    {
        return $this->Estatus === 'Activa' && 
               $this->FechaVencimiento >= now();
    }

    public function getNombreCompletoAseguradoAttribute()
    {
        if ($this->asegurado) {
            return trim("{$this->asegurado->Nombre} {$this->asegurado->ApellidoPaterno} {$this->asegurado->ApellidoMaterno}");
        }
        return 'N/A';
    }

    // Métodos auxiliares
    public function renovar($nuevaFechaVencimiento, $nuevaPrima = null)
    {
        $this->FechaInicio = now();
        $this->FechaVencimiento = $nuevaFechaVencimiento;
        
        if ($nuevaPrima) {
            $this->Prima = $nuevaPrima;
        }
        
        $this->Estatus = 'Activa';
        $this->save();
        
        return $this;
    }

    public function cancelar($motivo = null)
    {
        $this->Estatus = 'Cancelada';
        $this->save();
        
        // Aquí podrías registrar el motivo en una tabla de historial
        
        return $this;
    }

    public function marcarComoVencida()
    {
        $this->Estatus = 'Vencida';
        $this->save();
        
        return $this;
    }
}