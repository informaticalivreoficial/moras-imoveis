<?php

namespace App\Livewire\Dashboard\Trips;

use App\Http\Requests\Admin\StoreUpdateTripRequest;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TripForm extends Component
{
    public ?Trip $trip = null;

    public ?string $name;
    public string $start = '';
    public ?string $stop = null;
    public ?string $ship = null;
    public ?string $information = null;

    public function mount()
    {
        if ($this->trip) {
            $this->name = $this->trip->name;
            $this->start = $this->trip->start;
            $this->stop = $this->trip->stop;
            $this->ship = $this->trip->ship;
            $this->information = $this->trip->information;
        }
    }

    public function save()
    {
        $validated = Validator::make([
            'name' => $this->name,
            'start' => $this->start,
            'stop' => $this->stop,
            'ship' => $this->ship,
            'information' => $this->information,
        ], (new StoreUpdateTripRequest())->rules())->validate();
        
        // $data = [
        //     'name' => $validated['name'],
        //     'start' => $validated['start'],
        //     'stop' => $validated['stop'] ? $validated['stop'] : null,
        //     'ship' => $validated['ship'],
        //     'information' => $validated['information'],
        // ];

        if(!$this->trip){
            $startDate = Carbon::createFromFormat('d/m/Y', $this->start)->startOfDay();

            $exists = Trip::whereDate('start', $startDate)->where('ship', $validated['ship'])->exists();

            if ($exists) {
                $this->addError('start', 'Já existe uma viagem cadastrada para essa data e navio.');
                return;
            }

            $tripCreate = Trip::create($validated);            
            $this->dispatch(['cadastrado']);
            $this->trip = $tripCreate;
        }else{
            $this->trip->update($validated);
            $this->dispatch(['atualizado']);
        }
        
        // if ($this->trip) {
        //     $this->trip->update($data);
        //     $this->dispatch(['atualizado']);
        // } else {

        //     $startDate = Carbon::createFromFormat('d/m/Y', $this->start)->startOfDay();

        //     $query = Trip::whereDate('start', $startDate)->where('ship', $this->ship);

        //     if ($this->trip) {
        //         $query->where('id', '!=', $this->trip->id);
        //     }

        //     if ($query->exists()) {
        //         $this->addError('start', 'Já existe uma viagem cadastrada para essa data e navio.');
        //         return;
        //     }

        //     $tripCreate = Trip::create($data);            
        //     $this->dispatch(['cadastrado']);
        //     $this->trip = $tripCreate;
        // }
    }

    public function render()
    {
        $title = $this->trip ? 'Editar Viagem' : 'Cadastrar Viagem';
        return view('livewire.dashboard.trips.trip-form')->with('title', $title);
    }    
}
