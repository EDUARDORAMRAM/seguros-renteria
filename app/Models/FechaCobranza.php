<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FechaCobranza extends Model
{
    protected $table = 'fechas_cobranza';
    protected $primaryKey = 'IdFechaCobranza';

    protected $fillable = [
        'IdPoliza',
        'FechaCobranza',
        'MontoCobro',
        'Estatus',
        'FechaPago',
        'Observaciones',
    ];

    protected $casts = [
        'FechaCobranza' => 'datetime',
        'FechaPago' => 'datetime',
        'MontoCobro' => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════════════
    // RELACIONES
    // ═══════════════════════════════════════════════════════════
    public function poliza()
    {
        return $this->belongsTo(Poliza::class, 'IdPoliza', 'IdPoliza');
    }

    // ═══════════════════════════════════════════════════════════
    // SCOPES
    // ═══════════════════════════════════════════════════════════
    public function scopePendientes($query)
    {
        return $query->where('Estatus', 'Pendiente');
    }

    public function scopeProximas($query, $dias = 7)
    {
        return $query->where('Estatus', 'Pendiente')
            ->whereDate('FechaCobranza', '>=', now())
            ->whereDate('FechaCobranza', '<=', now()->addDays($dias))
            ->orderBy('FechaCobranza', 'asc');
    }

    // ═══════════════════════════════════════════════════════════
    // ACCESSORS
    // ═══════════════════════════════════════════════════════════
    public function getDiasParaCobrarAttribute()
    {
        if ($this->FechaCobranza) {
            return (int) now()->diffInDays($this->FechaCobranza, false);
        }
        return null;
    }

    public function getEstaVencidaAttribute()
    {
        return $this->Estatus === 'Pendiente' && $this->FechaCobranza && $this->FechaCobranza->isPast();
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODOS
    // ═══════════════════════════════════════════════════════════
    public function marcarComoPagado($fechaPago = null, $observaciones = null)
    {
        $this->Estatus = 'Pagado';
        $this->FechaPago = $fechaPago ?? now();
        $this->Observaciones = $observaciones;
        $this->save();
    }
}