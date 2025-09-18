<div>   

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Painel de Controle</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Início</a></li>
                        <li class="breadcrumb-item active">Painel de Controle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><a href="{{-- route('trips.index') --}}" title="Viagens"><i class="fa far fa-ship"></i></a></span>
            
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Viagens</b></span>
                            <span class="info-box-text">{{-- now()->year --}}: {{-- $tripYearCount --}}</span>
                            <span class="info-box-text">Total: {{-- $tripCount --}}</span>
                        </div>            
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal"><a href="{{-- route('manifests.index') --}}" title="Manifestos"><i class="fa far fa-file-alt"></i></a></span>
            
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Manifestos</b></span>
                            <span class="info-box-text">{{-- now()->year --}}: {{-- $manifestYearCount --}}</span>
                            <span class="info-box-text">Total: {{-- $manifestCount --}}</span>
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@if(session()->has('toastr'))
    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                toastr["{{ session('toastr.type') }}"](
                    "{{ session('toastr.message') }}",
                    "{{ session('toastr.title') }}"
                );
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                };
            });
        </script>
    @endpush
@endif