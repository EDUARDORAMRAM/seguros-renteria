<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'FechaCobranza',
        'Prima',
        'Estatus',
        'IdCompania',
        'IdUnidad',
        'IdAsegurado',
        'ArchivoPDF', // ← AGREGAR AQUÍ
    ];

    protected $casts = [
        'FechaInicio' => 'datetime',
        'FechaVencimiento' => 'datetime',
        'FechaCobranza' => 'datetime',
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

    // ═══════════════════════════════════════════════════════════
    // AGREGAR RELACIÓN ENDOSOS (para después)
    // ═══════════════════════════════════════════════════════════
    public function endosos()
    {
        return $this->hasMany(Endoso::class, 'IdPoliza', 'IdPoliza')
            ->orderBy('FechaEndoso', 'desc');
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
    public function scopeProximasCobranzas($query, $dias = 7)
    {
        return $query->where('Estatus', 'Activa')
            ->whereNotNull('FechaCobranza')
            ->whereDate('FechaCobranza', '>=', now())
            ->whereDate('FechaCobranza', '<=', now()->addDays($dias))
            ->orderBy('FechaCobranza', 'asc');
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
            return (int) now()->diffInDays($this->FechaVencimiento, false);
        }
        return null;
    }

    public function getDiasParaCobrarAttribute()
    {
        if ($this->FechaCobranza) {
            return (int) now()->diffInDays($this->FechaCobranza, false);
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

    // ═══════════════════════════════════════════════════════════
    // NUEVOS ACCESSORS PARA PDF
    // ═══════════════════════════════════════════════════════════
    public function getUrlPdfAttribute()
    {
        if ($this->ArchivoPDF && Storage::disk('public')->exists('polizas/' . $this->ArchivoPDF)) {
            return asset('storage/polizas/' . $this->ArchivoPDF);
        }
        return null;
    }

    public function getTienePdfAttribute()
    {
        return !empty($this->ArchivoPDF) && Storage::disk('public')->exists('polizas/' . $this->ArchivoPDF);
    }

    // Métodos auxiliares

     public function calcularFechaCobranza()
    {
        if (!$this->FechaInicio) {
            return null;
        }

        $fechaInicio = $this->FechaInicio;
        
        return match($this->FormaPago) {
            'Mensual' => $fechaInicio->copy()->addMonth(),
            'Trimestral' => $fechaInicio->copy()->addMonths(3),
            'Semestral' => $fechaInicio->copy()->addMonths(6),
            'Anual' => $fechaInicio->copy()->addYear(),
            default => null,
        };
    }
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
        
        return $this;
    }

    public function marcarComoVencida()
    {
        $this->Estatus = 'Vencida';
        $this->save();
        
        return $this;
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODO PARA ELIMINAR PDF ANTERIOR
    // ═══════════════════════════════════════════════════════════
    public function eliminarPdfAnterior()
    {
        if ($this->ArchivoPDF && Storage::disk('public')->exists('polizas/' . $this->ArchivoPDF)) {
            Storage::disk('public')->delete('polizas/' . $this->ArchivoPDF);
        }
    }
    // ═══════════════════════════════════════════════════════════
    // NUEVA RELACIÓN: Fechas de Cobranza
    // ═══════════════════════════════════════════════════════════
    public function fechasCobranza()
    {
        return $this->hasMany(FechaCobranza::class, 'IdPoliza', 'IdPoliza')
            ->orderBy('FechaCobranza', 'asc');
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODO CRÍTICO: Calcular fechas de cobranza
    // ═══════════════════════════════════════════════════════════
    public static function calcularFechasCobranza($fechaInicio, $fechaVencimiento, $formaPago)
    {
        $fechas = [];
        $fechaActual = \Carbon\Carbon::parse($fechaInicio);
        $fechaFin = \Carbon\Carbon::parse($fechaVencimiento);

        // Calcular intervalo según forma de pago
        $mesesIntervalo = match($formaPago) {
            'Mensual' => 1,
            'Trimestral' => 3,
            'Semestral' => 6,
            'Anual' => 12,
            default => 12,
        };

        // Generar fechas de cobranza
        while ($fechaActual->lte($fechaFin)) {
            $proximaFecha = $fechaActual->copy()->addMonths($mesesIntervalo);
            
            // Si la próxima fecha supera el vencimiento, usar fecha de vencimiento
            if ($proximaFecha->gt($fechaFin)) {
                $proximaFecha = $fechaFin->copy();
            }
            
            $fechas[] = $proximaFecha->format('Y-m-d');
            
            // Avanzar
            $fechaActual = $proximaFecha->copy();
            
            // Evitar loop infinito
            if ($fechaActual->gte($fechaFin)) {
                break;
            }
        }

        return $fechas;
    }

    // ═══════════════════════════════════════════════════════════
    // VALIDAR: Coherencia de fechas con forma de pago
    // ═══════════════════════════════════════════════════════════
    public static function validarCoherenciaFechas($fechaInicio, $fechaVencimiento, $formaPago)
    {
        $fechaInicioCarbon = \Carbon\Carbon::parse($fechaInicio);
        $fechaVencimientoCarbon = \Carbon\Carbon::parse($fechaVencimiento);
        
        $mesesDiferencia = $fechaInicioCarbon->diffInMonths($fechaVencimientoCarbon);
        
        $resultado = [
            'valido' => false,
            'mensaje' => '',
            'mesesDiferencia' => $mesesDiferencia,
            'numeroPagos' => 0,
        ];

        switch($formaPago) {
            case 'Mensual':
                $resultado['valido'] = true;
                $resultado['numeroPagos'] = $mesesDiferencia;
                $resultado['mensaje'] = "Se generarán {$mesesDiferencia} pagos mensuales";
                break;
                
            case 'Trimestral':
                if ($mesesDiferencia % 3 === 0) {
                    $resultado['valido'] = true;
                    $resultado['numeroPagos'] = $mesesDiferencia / 3;
                    $resultado['mensaje'] = "Se generarán {$resultado['numeroPagos']} pagos trimestrales";
                } else {
                    $resultado['mensaje'] = "Para pago trimestral, el periodo debe ser múltiplo de 3 meses. Actual: {$mesesDiferencia} meses";
                }
                break;
                
            case 'Semestral':
                if ($mesesDiferencia % 6 === 0) {
                    $resultado['valido'] = true;
                    $resultado['numeroPagos'] = $mesesDiferencia / 6;
                    $resultado['mensaje'] = "Se generarán {$resultado['numeroPagos']} pagos semestrales";
                } else {
                    $resultado['mensaje'] = "Para pago semestral, el periodo debe ser múltiplo de 6 meses. Actual: {$mesesDiferencia} meses";
                }
                break;
                
            case 'Anual':
                if ($mesesDiferencia % 12 === 0) {
                    $resultado['valido'] = true;
                    $resultado['numeroPagos'] = $mesesDiferencia / 12;
                    $resultado['mensaje'] = "Se generarán {$resultado['numeroPagos']} pagos anuales";
                } else {
                    $resultado['mensaje'] = "Para pago anual, el periodo debe ser múltiplo de 12 meses. Actual: {$mesesDiferencia} meses";
                }
                break;
        }

        return $resultado;
    }

    // ═══════════════════════════════════════════════════════════
    // GENERAR fechas de cobranza al crear póliza
    // ═══════════════════════════════════════════════════════════
    public function generarFechasCobranza()
    {
        // Eliminar fechas anteriores si existen
        $this->fechasCobranza()->delete();

        $fechas = self::calcularFechasCobranza(
            $this->FechaInicio,
            $this->FechaVencimiento,
            $this->FormaPago
        );

        // Calcular monto por cobro
        $montoPorCobro = count($fechas) > 0 ? $this->Prima / count($fechas) : $this->Prima;

        foreach ($fechas as $fecha) {
            FechaCobranza::create([
                'IdPoliza' => $this->IdPoliza,
                'FechaCobranza' => $fecha,
                'MontoCobro' => round($montoPorCobro, 2),
                'Estatus' => 'Pendiente',
            ]);
        }
    }

    // ═══════════════════════════════════════════════════════════
    // ACCESSOR: Próxima fecha de cobranza
    // ═══════════════════════════════════════════════════════════
    public function getProximaCobranzaAttribute()
    {
        return $this->fechasCobranza()
            ->where('Estatus', 'Pendiente')
            ->where('FechaCobranza', '>=', now())
            ->orderBy('FechaCobranza', 'asc')
            ->first();
    }

    public function getCobranzasVencidasAttribute()
    {
        return $this->fechasCobranza()
            ->where('Estatus', 'Pendiente')
            ->where('FechaCobranza', '<', now())
            ->count();
    }
}