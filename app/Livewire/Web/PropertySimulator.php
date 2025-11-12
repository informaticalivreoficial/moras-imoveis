<?php

namespace App\Livewire\Web;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Attributes\On;

class PropertySimulator extends Component
{
    public $nome;
    public $tempo;
    public $tipo_financiamento;
    public $valor;
    public $valor_entrada;
    public $renda;
    public $natureza = 'Indiferente';
    public $tipoimovel = 'Residencial';
    public $bairro;
    public $email;
    public $telefone;    
    public $oqueprecisa = 'Pré aprovar meu crédito';
    public $valorcarta;
    public $prazocarta;

    public $estado = '';
    public $cidade = ''; 
    public $estados = [];

    public $success = false;

    public function rules()
    {
        $rules = [
            'nome' => 'required|string|min:3',
            'tempo' => 'required|string',
            'tipo_financiamento' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
            'estado' => 'required|string',
            'cidade' => 'required|string',
        ];
        
        if ($this->tipo_financiamento === 'Consórcio') {
            $rules['valorcarta'] = 'required';
            $rules['prazocarta'] = 'required|string';
        }

        if ($this->tipo_financiamento === 'Financiamento') {
            $rules['valor'] = 'required';
            $rules['valor_entrada'] = 'required';
            $rules['renda'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'valorcarta.required' => 'Informe o valor da carta de crédito.',
            'prazocarta.required' => 'Informe o prazo da carta de crédito.',
        ];
    }

    public function render()
    {
        return view('livewire.web.property-simulator');
    }

    public function mount()
    {
        $this->loadEstados();
    }

    public function loadEstados()
    {
        try {
            $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');
            $this->estados = $response->json() ?? [];
        } catch (\Throwable $e) {
            $this->estados = [];
            logger()->error('Erro ao carregar estados IBGE: ' . $e->getMessage());
        }
    }

    public function submit()
    {        
        $this->validate();
        
        $data = $this->only([
            'nome', 'tempo', 'tipo_financiamento', 'valor', 'valor_entrada', 
            'renda', 'natureza', 'tipoimovel', 'email', 'telefone', 
            'oqueprecisa', 'valorcarta', 'prazocarta', 'estado', 'cidade'
        ]);        

        $this->reset();        
        $this->success = true;
    }
}
