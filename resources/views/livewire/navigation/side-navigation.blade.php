<aside class="main-sidebar sidebar-light-teal elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="">
        <img src="{{$config->getlogoadmin()}}" alt="{{$config->app_name}}"
            class="brand-image elevation-3">        
    </a>

    <div class="sidebar mt-3">
        {{-- Sidebar user panel (optional)  --}}
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/bms_logo.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>

            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin')}}" class="nav-link {{ Route::is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Painel de Controle</p>
                    </a>                    
                </li>

                <li class="nav-item">
                    <a href="{{route('settings')}}" class="nav-link {{ Route::is('settings') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i> 
                        <p> Configurações</p>
                    </a>
                </li>

                <li class="nav-item {{ Route::is('users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Usuários <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link {{ Route::is('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Clientes <span class="badge badge-info right">{{$clientCount}}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users.time')}}" class="nav-link {{ Route::is('users.time') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Time <span class="badge badge-info right">{{$timeCount}}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users.create')}}" class="nav-link {{ Route::is('users.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('properties.index')}}" class="nav-link {{ Route::is('properties.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Imóveis
                            <span class="badge badge-info right">{{$propertyCount}}</span>
                        </p>
                    </a>
                </li>     
                <li class="nav-item">
                    <a href="{{--route('companies.index')--}}" class="nav-link {{-- Route::is('companies.*') ? 'active' : '' --}}">
                        <i class="nav-icon fas fa-industry"></i>
                        <p>
                            Empresas
                            <span class="badge badge-info right">{{--$companyCount--}}</span>
                        </p>
                    </a>
                </li>     
                <li class="nav-item">
                    <a href="{{--route('trips.index')--}}" class="nav-link">
                        <i class="nav-icon fas fa-ship"></i>

                        <p>
                            Viagens
                            <span class="badge badge-info right">{{--$tripCount--}}</span>
                        </p>
                    </a>
                </li>     
                <li class="nav-item {{ Route::is('manifests.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('manifests.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Manifestos <i class="fas fa-angle-left right"></i></p>                        
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{--route('manifests.index')--}}" class="nav-link {{-- Route::is('manifests.index') ? 'active' : '' --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Na Conferência <span class="badge badge-info right">{{--$manifestCount--}}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{--route('manifests.comercial')--}}" class="nav-link {{-- Route::is('manifests.comercial') ? 'active' : '' --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>No Comercial <span class="badge badge-info right">{{--$manifestComercialCount--}}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{--route('manifests.finance')--}}" class="nav-link {{-- Route::is('manifests.finance') ? 'active' : '' --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>No Financeiro <span class="badge badge-info right">{{--$manifestFinanceCount--}}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Finalizados <span class="badge badge-info right">{{--$manifestFinishCount--}}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{--route('manifests.create')--}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>                    
                </li>     
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p> Relatórios <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Relatório de Viagens</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{--route('manifestReport.index')--}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Relatório de Manifestos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Relatório de Clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{--route('companyReport.index')--}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Relatório de Empresas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{-- Route::is('finances.*') ? 'menu-open' : '' --}}">
                    <a href="#" class="nav-link {{ Route::is('finances.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p> Financeiro <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{--route('finances.tableofvalue')--}}" class="nav-link {{-- Route::is('finances.tableofvalue') ? 'active' : '' --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tabela de valores</p>
                            </a>
                        </li>                        
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Faturas</p>
                            </a>
                        </li>                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p> Segurança <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.roles')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cargos</p>
                            </a>
                        </li>                        
                        <li class="nav-item">
                            <a href="{{route('admin.permissions')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissões</p>
                            </a>
                        </li>                        
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
