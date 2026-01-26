<?php

namespace App\Livewire\Unidades;

use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithPagination;

class UnidadesList extends Component
{
    use WithPagination;

    public $busqueda = '';
    public $filtroUso = '';
    public $porPagina = 10;
    public $ordenarPor = 'created_at';
    public $ordenDireccion = 'desc';

    protected $queryString = [
        'busqueda' => ['except' => ''],
        'filtroUso' => ['except' => ''],
        'porPagina' => ['except' => 10],
    ];

    protected $listeners = ['unidadEliminada' => '$refresh'];

    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function updatingFiltroUso()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['busqueda', 'filtroUso']);
    }

    public function ordenar($campo)
    {
        if ($this->ordenarPor === $campo) {
            $this->ordenDireccion = $this->ordenDireccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->ordenDireccion = 'asc';
        }
    }

    public function eliminar($unidadId)
    {
        $unidad = Unidad::find($unidadId);
        
        if ($unidad) {
            if ($unidad->polizas()->count() > 0) {
                session()->flash('error', 'No se puede eliminar la unidad porque tiene pólizas asociadas.');
                return;
            }

            $unidad->delete();
            
            session()->flash('message', 'Unidad eliminada exitosamente.');
            $this->dispatch('unidadEliminada');
        }
    }

    public function render()
    {
        $query = Unidad::withCount('polizas');

        if ($this->busqueda) {
            $query->buscar($this->busqueda);
        }

        if ($this->filtroUso) {
            $query->where('Uso', $this->filtroUso);
        }

        $query->orderBy($this->ordenarPor, $this->ordenDireccion);

        $unidades = $query->paginate($this->porPagina);

        return view('livewire.unidades.unidades-list', [
            'unidades' => $unidades,
        ]);
    }
}