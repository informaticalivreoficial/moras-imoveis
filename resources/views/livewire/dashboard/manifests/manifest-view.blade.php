<div>
    @section('title', $title)
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manifesto de Carga</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item">
                            <a 
                                wire:navigate 
                                href="{{
                                            route(
                                                $manifest && $manifest->section == 'comercial' ? 'manifests.comercial' :
                                                ($manifest && $manifest->section == 'financeiro' ? 'manifests.finance' :
                                                ($manifest && $manifest->section == 'finalizado' ? 'manifests.finished' : 'manifests.index'))
                                            )
                                        }}">Manifestos</a>
                        </li>
                        <li class="breadcrumb-item active">Manifesto de Carga</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content __web-inspector-hide-shortcut__">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info no-print">
                        <h5><i class="fas fa-info"></i> Notas:</h5>
                        Este manifesto de carga foi criado por {{ $manifest->created }}
                    </div>    
    
                    <div class="invoice p-3 mb-4 mt-4">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img width="220" src="{{$configuracoes->getlogo()}}" alt="{{$configuracoes->alias_name}}">
                                    <small class="float-right">Data: {{$manifest->created_at}}</small>
                                </h4>
                            </div>                            
                        </div>
                        
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <address>
                                <strong>{{$configuracoes->alias_name}}</strong><br>
                                {{$configuracoes->street}}, {{$configuracoes->number}}<br>
                                {{$configuracoes->neighborhood}}, {{$configuracoes->city}} - {{$configuracoes->zipcode}}<br>
                                Fone: {{$configuracoes->cell_phone}}<br>
                                {{$configuracoes->email}}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <address>
                                @if ($manifest->userObject && $manifest->companyObject == null)
                                    <strong>Cliente: </strong>{{$manifest->userObject->name}}
                                    {!! ($manifest->userObject->cpf ? '<br><strong>CPF:</strong> '. $manifest->userObject->cpf : '') !!}
                                    {!! ($manifest->userObject->email ? '<br><strong>Email:</strong> '. $manifest->userObject->email : '' ) !!}
                                @elseif ($manifest->companyObject && $manifest->userObject == null)
                                    <strong>Empresa: </strong>{{$manifest->companyObject->alias_name}}
                                    {!! ($manifest->companyObject->document_company ? '<br><strong>CNPJ:</strong> '. $manifest->companyObject->document_company : '') !!}
                                    {!! ($manifest->companyObject->email ? '<br><strong>Email:</strong> '. $manifest->companyObject->email : '' ) !!}
                                @else
                                    <strong>Cliente Não informado</strong>
                                @endif                        
                                {!! ($manifest->street ? '<br>'. $manifest->street : '') !!}
                                {!! ($manifest->number ? ', '. $manifest->number : '') !!}
                                {!! ($manifest->neighborhood ? ', '. $manifest->neighborhood : '') !!}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Manifesto de {{$manifest->object}} #{{$manifest->id}}</b>
                                <br>
                                <b>Viagem:</b> {{$manifest->trip}}<br>
                                <b>Início:</b> {{$manifest->tripObject->start}}<br>
                                <b>Término:</b> {{$manifest->tripObject->stop}}<br>
                                @php
                                    $statusClass = match($manifest->status) {
                                        \App\Enums\StatusOfManifestEnum::Recebido => 'bg-gray-100 text-gray-800',
                                        \App\Enums\StatusOfManifestEnum::Transito => 'bg-yellow-100 text-yellow-800',
                                        \App\Enums\StatusOfManifestEnum::Entregue => 'bg-green-100 text-green-800',
                                        default => 'bg-blue-100 text-blue-800',
                                    };
                                @endphp
                                <b>Status:</b> 
                                <span class="inline-block px-2 py-1 text-sm font-semibold rounded {{ $statusClass }}">
                                    {{ $manifest->status->label() }}
                                </span>
                            </div>
                        </div>
        
                        <div class="row mt-4">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Unid.</th>
                                            <th>Descrição</th>
                                            <th>Horti-Fruti</th>
                                            <th>Peso Seco</th>
                                            <th>Seguro</th>
                                            <th>Embalagem</th>
                                            <th>Congelados</th>
                                            <th>Taxas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $index => $item)
                                            <tr>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>{{ $item['unit'] }}</td>
                                                <td>{{ $item['description'] }}</td>
                                                <td>R${{ number_format($item['horti_fruit'], 2) }}</td>
                                                <td>R${{ number_format($item['dry_weight'], 2) }}</td>
                                                <td>R${{ number_format($item['secure'], 2) }}</td>
                                                <td>R${{ number_format($item['package'], 2) }}</td>
                                                <td>R${{ number_format($item['glace'], 2) }}</td>
                                                <td>R${{ number_format($item['tax'], 2) }}</td>
                                            </tr>
                                        @endforeach                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
        
                        <div class="row mt-4">                    
                            <div class="col-6"> 
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{$manifest->information}}
                                </p>
                            </div>
                        
                            <div class="col-6">
                                <p class="lead">Valor em {{now()->format('d/m/Y')}}</p>    
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>
                                                    @if ($manifest->items && $manifest->items->count() > 0)
                                                    R$ {{
                                                            number_format(
                                                                $manifest->items->sum('horti-fruit') + 
                                                                $manifest->items->sum('cubage') +
                                                                $manifest->items->sum('secure') +
                                                                $manifest->items->sum('dry_weight') +
                                                                $manifest->items->sum('package') +
                                                                $manifest->items->sum('glace'),
                                                                2,
                                                                ',',
                                                                '.'
                                                            )
                                                        }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Taxas</th>
                                                <td>
                                                    @if ($manifest->items && $manifest->items->count() > 0)
                                                    R$ {{
                                                            number_format(
                                                                $manifest->items->sum('tax'),
                                                                2,
                                                                ',',
                                                                '.'
                                                            )
                                                        }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>
                                                    @if ($manifest->items && $manifest->items->count() > 0)
                                                    R$ {{
                                                            number_format(
                                                                $manifest->items->sum('horti-fruit') + 
                                                                $manifest->items->sum('cubage') +
                                                                $manifest->items->sum('secure') +
                                                                $manifest->items->sum('dry_weight') +
                                                                $manifest->items->sum('package') +
                                                                $manifest->items->sum('glace') +
                                                                $manifest->items->sum('tax'),
                                                                2,
                                                                ',',
                                                                '.'
                                                            )
                                                        }}
                                                    @endif
                                                </td>   
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                    
                        </div>    
                        
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</a>
                                
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Gerar PDF
                                </button>
                                <button type="button" onclick="window.history.back()" class="btn btn-lg btn-default float-right" style="margin-right: 5px;">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </button>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </section>
</div>
