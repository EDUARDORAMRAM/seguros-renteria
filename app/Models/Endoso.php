<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Endoso extends Model
{
    use HasFactory;

    protected $table = 'endosos';
    protected $primaryKey = 'IdEndoso';

    protected $fillable = [
        'IdPoliza',
        'NumEndoso',
        'FechaEndoso',
        'TipoEndoso',
        'Descripcion',
        'MontoAfectado',
        'ArchivoAdjunto',
        'user_id',
    ];

    protected $casts = [
        'FechaEndoso' => 'datetime',
        'MontoAfectado' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ═══════════════════════════════════════════════════════════
    // RELACIONES
    // ═══════════════════════════════════════════════════════════
    public function poliza()
    {
        return $this->belongsTo(Poliza::class, 'IdPoliza', 'IdPoliza');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ═══════════════════════════════════════════════════════════
    // ACCESSORS
    // ═══════════════════════════════════════════════════════════
    public function getUrlArchivoAttribute()
    {
        if ($this->ArchivoAdjunto && Storage::disk('public')->exists('endosos/' . $this->ArchivoAdjunto)) {
            return asset('storage/endosos/' . $this->ArchivoAdjunto);
        }
        return null;
    }

    public function getTieneArchivoAttribute()
    {
        return !empty($this->ArchivoAdjunto) && Storage::disk('public')->exists('endosos/' . $this->ArchivoAdjunto);
    }

    public function getNombreUsuarioAttribute()
    {
        return $this->usuario ? $this->usuario->name : 'Sistema';
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODOS ESTÁTICOS
    // ═══════════════════════════════════════════════════════════
    public static function generarNumero()
    {
        $year = date('Y');
        
        // Buscar el último endoso del año
        $ultimo = self::whereYear('created_at', $year)
            ->orderBy('IdEndoso', 'desc')
            ->first();
        
        // Incrementar el número
        if ($ultimo) {
            // Extraer el número del formato END-2024-001
            $partes = explode('-', $ultimo->NumEndoso);
            $numero = (int)end($partes) + 1;
        } else {
            $numero = 1;
        }
        
        // Formato: END-2024-001
        return 'END-' . $year . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }

    // ═══════════════════════════════════════════════════════════
    // MÉTODOS DE INSTANCIA
    // ═══════════════════════════════════════════════════════════
    public function eliminarArchivoAnterior()
    {
        if ($this->ArchivoAdjunto && Storage::disk('public')->exists('endosos/' . $this->ArchivoAdjunto)) {
            Storage::disk('public')->delete('endosos/' . $this->ArchivoAdjunto);
        }
    }
}