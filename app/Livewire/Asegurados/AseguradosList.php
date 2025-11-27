<?php

namespace App\Livewire\Asegurados;

use App\Models\Asegurado;
use Livewire\Component;
use Livewire\WithPagination;

class AseguradosList extends Component
{
    use WithPagination;

    public $busqueda = '';
    public $porPagina = 10;
    public $ordenarPor = 'created_at';
    public $ordenDireccion = 'desc';

    protected $queryString = [
        'busqueda' => ['except' => ''],
        'porPagina' => ['except' => 10],
    ];

    protected $listeners = ['aseguradoEliminado' => '$refresh'];

    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['busqueda']);
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

    public function eliminar($aseguradoId)
    {
        $asegurado = Asegurado::find($aseguradoId);
        
        if ($asegurado) {
            // Verificar si tiene pólizas activas
            if ($asegurado->polizasActivas()->count() > 0) {
                session()->flash('error', 'No se puede eliminar el asegurado porque tiene pólizas activas.');
                return;
            }
            
            $asegurado->delete();
            session()->flash('message', 'Asegurado eliminado exitosamente.');
            $this->emit('aseguradoEliminado');
        }
    }

    public function render()
    {
        $query = Asegurado::withCount(['polizas', 'polizasActivas']);

        if ($this->busqueda) {
            $query->buscar($this->busqueda);
        }

        $query->orderBy($this->ordenarPor, $this->ordenDireccion);

        $asegurados = $query->paginate($this->porPagina);

        return view('livewire.asegurados.asegurados-list', [
            'asegurados' => $asegurados,
        ]);
    }
}