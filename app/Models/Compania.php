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

    // ═══════════════════════════════════════════════════════════
    // RELACIONES
    // ═══════════════════════════════════════════════════════════
    public function polizas()
    {
        return $this->hasMany(Poliza::class, 'IdCompania', 'IdCompania');
    }

    public function polizasActivas()
    {
        return $this->hasMany(Poliza::class, 'IdCompania', 'IdCompania')
            ->where('Estatus', 'Activa');
    }

    // ═══════════════════════════════════════════════════════════
    // SCOPES
    // ═══════════════════════════════════════════════════════════
    public function scopeBuscar($query, $busqueda)
    {
        return $query->where(function($q) use ($busqueda) {
            $q->where('Nombre', 'like', "%{$busqueda}%")
              ->orWhere('Cobertura', 'like', "%{$busqueda}%");
        });
    }

    public function scopePorNombre($query, $nombre)
    {
        return $query->where('Nombre', 'like', "%{$nombre}%");
    }

    public function scopeConPolizasActivas($query)
    {
        return $query->has('polizasActivas');
    }

    // ═══════════════════════════════════════════════════════════
    // ACCESSORS - Atributos calculados
    // ═══════════════════════════════════════════════════════════
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

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Nombre completo (para mostrar en selects)
    // ═══════════════════════════════════════════════════════════
    public function getNombreCompletoAttribute()
    {
        return "{$this->Nombre} - {$this->Cobertura}";
    }

    // ═══════════════════════════════════════════════════════════
    // NUEVO: Identificador único de la combinación
    // ═══════════════════════════════════════════════════════════
    public function getIdentificadorUnicoAttribute()
    {
        return strtolower(trim($this->Nombre)) . '|' . strtolower(trim($this->Cobertura));
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODOS ESTÁTICOS DE VALIDACIÓN
    // ═══════════════════════════════════════════════════════════
    
    /**
     * Verifica si ya existe una compañía con el mismo Nombre y Cobertura
     * 
     * @param string $nombre
     * @param string $cobertura
     * @param int|null $idExcluir ID a excluir (útil para edición)
     * @return bool
     */
    public static function existeCombinacion($nombre, $cobertura, $idExcluir = null)
    {
        $query = self::where('Nombre', $nombre)
            ->where('Cobertura', $cobertura);
        
        if ($idExcluir) {
            $query->where('IdCompania', '!=', $idExcluir);
        }
        
        return $query->exists();
    }

    /**
     * Obtiene todas las coberturas disponibles para un nombre de compañía
     * 
     * @param string $nombre
     * @return \Illuminate\Support\Collection
     */
    public static function coberturasDisponiblesPorNombre($nombre)
    {
        return self::where('Nombre', $nombre)
            ->pluck('Cobertura')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Obtiene todos los nombres únicos de compañías
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function nombresUnicos()
    {
        return self::distinct('Nombre')
            ->orderBy('Nombre')
            ->pluck('Nombre');
    }

    /**
     * Obtiene la compañía por nombre y cobertura
     * 
     * @param string $nombre
     * @param string $cobertura
     * @return Compania|null
     */
    public static function buscarPorCombinacion($nombre, $cobertura)
    {
        return self::where('Nombre', $nombre)
            ->where('Cobertura', $cobertura)
            ->first();
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODOS DE INSTANCIA
    // ═══════════════════════════════════════════════════════════
    
    /**
     * Verifica si esta compañía puede ser eliminada
     * 
     * @return array ['puede_eliminar' => bool, 'mensaje' => string]
     */
    public function puedeEliminar()
    {
        $totalPolizas = $this->total_polizas;
        $totalActivas = $this->total_polizas_activas;

        if ($totalActivas > 0) {
            return [
                'puede_eliminar' => false,
                'mensaje' => "No se puede eliminar. Tiene {$totalActivas} póliza(s) activa(s).",
            ];
        }

        if ($totalPolizas > 0) {
            return [
                'puede_eliminar' => false,
                'mensaje' => "No se puede eliminar. Tiene {$totalPolizas} póliza(s) asociada(s) (históricas).",
            ];
        }

        return [
            'puede_eliminar' => true,
            'mensaje' => 'La compañía puede ser eliminada.',
        ];
    }

    /**
     * Obtiene un resumen de estadísticas
     * 
     * @return array
     */
    public function obtenerEstadisticas()
    {
        return [
            'total_polizas' => $this->total_polizas,
            'polizas_activas' => $this->total_polizas_activas,
            'primas_totales' => $this->primas_totales,
            'nombre_completo' => $this->nombre_completo,
        ];
    }
}