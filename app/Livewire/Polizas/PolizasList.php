<?php

namespace App\Livewire\Polizas;

use App\Models\Poliza;
use App\Models\Compania;
use Livewire\Component;
use Livewire\WithPagination;

class PolizasList extends Component
{
    use WithPagination;

    // Propiedades públicas
    public $busqueda = '';
    public $filtroEstatus = '';
    public $filtroCompania = '';
    public $porPagina = 10;
    public $ordenarPor = 'created_at';
    public $ordenDireccion = 'desc';

    // Protección contra query strings
    protected $queryString = [
        'busqueda' => ['except' => ''],
        'filtroEstatus' => ['except' => ''],
        'filtroCompania' => ['except' => ''],
        'porPagina' => ['except' => 10],
    ];

    // Listeners
    protected $listeners = ['polizaEliminada' => '$refresh'];

    // Resetear paginación al buscar
    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstatus()
    {
        $this->resetPage();
    }

    public function updatingFiltroCompania()
    {
        $this->resetPage();
    }

    // Método para limpiar filtros
    public function limpiarFiltros()
    {
        $this->reset(['busqueda', 'filtroEstatus', 'filtroCompania']);
    }

    // Método para ordenar
    public function ordenar($campo)
    {
        if ($this->ordenarPor === $campo) {
            $this->ordenDireccion = $this->ordenDireccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->ordenDireccion = 'asc';
        }
    }

    // Método para eliminar (solo pólizas canceladas)
    public function eliminar($polizaId)
    {
        $poliza = Poliza::find($polizaId);

        if (!$poliza) {
            session()->flash('error', 'Póliza no encontrada.');
            return;
        }

        // Solo permitir eliminar pólizas canceladas
        if ($poliza->Estatus !== 'Cancelada') {
            session()->flash('error', 'Solo se pueden eliminar pólizas con estatus "Cancelada".');
            return;
        }

        $poliza->delete();

        session()->flash('message', 'Póliza eliminada exitosamente.');
        $this->dispatch('polizaEliminada');
    }

    // Render
    public function render()
    {
        $query = Poliza::with(['asegurado', 'compania', 'unidad']);

        // Aplicar búsqueda
        if ($this->busqueda) {
            $query->buscar($this->busqueda);
        }

        // Aplicar filtro de estatus
        if ($this->filtroEstatus) {
            $query->where('Estatus', $this->filtroEstatus);
        }

        // Aplicar filtro de compañía
        if ($this->filtroCompania) {
            $query->where('IdCompania', $this->filtroCompania);
        }

        // Aplicar ordenamiento
        $query->orderBy($this->ordenarPor, $this->ordenDireccion);

        // Paginar resultados
        $polizas = $query->paginate($this->porPagina);

        // Obtener compañías para el filtro
        $companias = Compania::orderBy('Nombre')->get();

        return view('livewire.polizas.polizas-list', [
            'polizas' => $polizas,
            'companias' => $companias,
        ]);
    }
}