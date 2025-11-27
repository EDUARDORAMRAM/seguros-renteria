<?php

namespace App\Livewire\Companias;

use App\Models\Compania;
use Livewire\Component;
use Livewire\WithPagination;

class CompaniasList extends Component
{
    use WithPagination;

    // Propiedades públicas
    public $busqueda = '';
    public $porPagina = 10;
    public $ordenarPor = 'Nombre';
    public $ordenDireccion = 'asc';

    // Protección contra query strings
    protected $queryString = [
        'busqueda' => ['except' => ''],
        'porPagina' => ['except' => 10],
    ];

    // Listeners
    protected $listeners = ['companiaEliminada' => '$refresh'];

    // Resetear paginación al buscar
    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    // Método para limpiar filtros
    public function limpiarFiltros()
    {
        $this->reset(['busqueda']);
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

    // Método para eliminar
    public function eliminar($companiaId)
    {
        $compania = Compania::find($companiaId);
        
        if ($compania) {
            // Verificar si tiene pólizas asociadas
            if ($compania->polizas()->count() > 0) {
                session()->flash('error', 'No se puede eliminar la compañía porque tiene pólizas asociadas.');
                return;
            }

            $compania->delete();
            
            session()->flash('message', 'Compañía eliminada exitosamente.');
            $this->dispatch('companiaEliminada');
        }
    }

    // Render
    public function render()
    {
        $query = Compania::withCount(['polizas', 'polizasActivas']);

        // Aplicar búsqueda
        if ($this->busqueda) {
            $query->buscar($this->busqueda);
        }

        // Aplicar ordenamiento
        $query->orderBy($this->ordenarPor, $this->ordenDireccion);

        // Paginar resultados
        $companias = $query->paginate($this->porPagina);

        return view('livewire.companias.companias-list', [
            'companias' => $companias,
        ]);
    }
}