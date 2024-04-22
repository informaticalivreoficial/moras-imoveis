@extends('adminlte::page')

@section('title', "Cargos do usuário {$user->name}")

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Cargos do usuário {{$user->name}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.team')}}">Time</a></li>
            <li class="breadcrumb-item active">Cargos do usuário {{$user->name}}</li>
        </ol>
    </div>
</div>
@stop

@section('content')
    <div class="card">
        <div class="card-header text-right">
            <a href="{{route('users.roles.create',['idUser' => $user->id])}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Vincular Cargo</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            @if(!empty($roles) && $roles->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Cargo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($roles as $role)                        
                        <tr>                       
                            <td>{{$role->name}}</td>
                            <td>
                                <a href="{{route('users.roles.desvincular',['idUser' => $user->id, 'idRole' => $role->id])}}" class="btn btn-xs btn-danger text-white"><i class="fas fa-trash"></i></a>                                
                            </td>
                        </tr>                            
                        @endforeach
                    </tbody>                
                </table>
            @else
                <div class="row mb-4">
                    <div class="col-12">                                                        
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>                                                        
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer paginacao">  
            {{ $roles->links() }}
        </div>
    </div> 

@endsection