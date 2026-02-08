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

        // El primer pago es el mismo día del inicio de la póliza
        return $this->FechaInicio->copy();
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
        $fechaFin = \Carbon\Carbon::parse($fechaVencimiento);

        // Calcular intervalo según forma de pago
        $mesesIntervalo = match($formaPago) {
            'Mensual' => 1,
            'Trimestral' => 3,
            'Semestral' => 6,
            'Anual' => 12,
            default => 12,
        };

        // Primera fecha de cobranza: mismo día del inicio de la póliza
        // Las siguientes fechas usan el intervalo normal de la forma de pago
        $fechaActual = \Carbon\Carbon::parse($fechaInicio);

        // Generar fechas de cobranza
        while ($fechaActual->lt($fechaFin)) {
            $fechas[] = $fechaActual->format('Y-m-d');
            $fechaActual = $fechaActual->copy()->addMonths($mesesIntervalo);
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
    // $marcarPasadasComoPagadas: true para importaciones (fechas pasadas = Pagado)
    // $calcularMontos: true para dividir la prima entre los pagos
    // ═══════════════════════════════════════════════════════════
    public function generarFechasCobranza($marcarPasadasComoPagadas = false, $calcularMontos = false)
    {
        // Eliminar fechas anteriores si existen
        $this->fechasCobranza()->delete();

        $fechas = self::calcularFechasCobranza(
            $this->FechaInicio,
            $this->FechaVencimiento,
            $this->FormaPago
        );

        $hoy = now()->startOfDay();
        $numPagos = count($fechas);

        // Calcular monto por pago si se solicita y hay prima
        $montoPorPago = 0;
        if ($calcularMontos && $this->Prima > 0 && $numPagos > 0) {
            $montoPorPago = round($this->Prima / $numPagos, 2);
        }

        foreach ($fechas as $fecha) {
            $fechaCobranza = \Carbon\Carbon::parse($fecha);

            // Determinar estatus según si la fecha ya pasó
            $estatus = 'Pendiente';
            $fechaPago = null;
            $observaciones = null;

            if ($marcarPasadasComoPagadas && $fechaCobranza->lt($hoy)) {
                $estatus = 'Pagado';
                $fechaPago = $fechaCobranza;
                $observaciones = 'Pago anterior (importación)';
            }

            FechaCobranza::create([
                'IdPoliza' => $this->IdPoliza,
                'FechaCobranza' => $fecha,
                'MontoCobro' => $montoPorPago,
                'Estatus' => $estatus,
                'FechaPago' => $fechaPago,
                'Observaciones' => $observaciones,
            ]);
        }
    }

    // ═══════════════════════════════════════════════════════════
    // ACTUALIZAR montos de cobranza (primer pago, segundo pago, resto)
    // ═══════════════════════════════════════════════════════════
    public function actualizarMontosCobranza($montoPrimerPago, $montoSegundoPago)
    {
        $fechas = $this->fechasCobranza()->orderBy('FechaCobranza', 'asc')->get();

        foreach ($fechas as $index => $fecha) {
            if ($index === 0) {
                // Primer pago
                $fecha->MontoCobro = $montoPrimerPago;
            } else {
                // Segundo pago y todos los siguientes
                $fecha->MontoCobro = $montoSegundoPago;
            }
            $fecha->save();
        }

        // Recalcular y actualizar la prima total
        $this->Prima = $this->fechasCobranza()->sum('MontoCobro');
        $this->save();

        return $this->Prima;
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

    // ═══════════════════════════════════════════════════════════
    // CORREGIR: Marcar fechas de cobranza pasadas como Pagadas
    // ═══════════════════════════════════════════════════════════
    public static function corregirCobranzasPasadas()
    {
        $hoy = now()->startOfDay();

        $actualizados = FechaCobranza::where('Estatus', 'Pendiente')
            ->whereDate('FechaCobranza', '<', $hoy)
            ->update([
                'Estatus' => 'Pagado',
                'FechaPago' => \DB::raw('FechaCobranza'),
                'Observaciones' => 'Pago anterior (corrección automática)',
            ]);

        return $actualizados;
    }
}