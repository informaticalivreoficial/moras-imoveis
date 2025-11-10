<?php

namespace App\Livewire\Web;

use Livewire\Component;

class PropertySimulator extends Component
{
    public $nome;
    public $nasc;
    public $tempo;
    public $tipo_financiamento;
    public $valor;
    public $valor_entrada;
    public $natureza = 'Indiferente';
    public $tipoimovel = 'Residencial';
    public $uf;
    public $cidade;
    public $bairro;
    public $email;
    public $celular;
    public $renda;
    public $oqueprecisa = 'Pré aprovar meu crédito';
    public $valorcarta;
    public $prazocarta;

    public function rules()
    {
        return [
            'nome' => 'required|string|min:3',
            'nasc' => 'required|string',
            'tempo' => 'required|string',
            'tipo_financiamento' => 'required|string',
            'email' => 'required|email',
            'celular' => 'required|string',
            'uf' => 'required|string',
            'cidade' => 'required|string',
            'bairro' => 'required|string',
        ];
    }

    public function render()
    {
        return view('livewire.web.property-simulator');
    }

    public $estados = [];
    public $cidades = [];

    public function mount()
    {
        $this->loadEstados();
    }

    public function loadEstados()
    {
        $json = file_get_contents('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        $this->estados = collect(json_decode($json))->sortBy('nome')->pluck('nome', 'sigla')->toArray();
    }

    public function updatedEstado($sigla)
    {
        $json = file_get_contents("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$sigla}/municipios");
        $this->cidades = collect(json_decode($json))->pluck('nome')->toArray();
        $this->cidade = '';
    }

    public function submit()
    {
        $this->validate();
        dd($this->validate());
        // Mail::send('emails.simulador', ['data' => $this->all()], function ($message) {
        //     $message->to(config('mail.from.address'))
        //             ->subject('Novo Simulador de Financiamento');
        // });

        $this->reset();
        session()->flash('success', 'Formulário enviado com sucesso! Em breve entraremos em contato.');
    }
}
