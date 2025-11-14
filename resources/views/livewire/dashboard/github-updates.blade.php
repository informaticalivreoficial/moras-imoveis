<div class="col-lg-4">
    
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Últimas Atualizações do Sistema</h3>
            </div>

            <div class="card-body" style="overflow-y: auto;">
                @foreach($commits as $commit)
                    <div class="mb-3 border-bottom pb-2">
                        <strong>{{ $commit['commit']['message'] }}</strong>
                        <br>
                        <small>
                            Autor: {{ $commit['commit']['author']['email'] }} —
                            {{ \Carbon\Carbon::parse($commit['commit']['author']['date'])->diffForHumans() }}
                        </small>
                    </div>
                @endforeach
            </div>
            <div class="card-footer clearfix">
                <button wire:click="loadCommits" class="btn btn-sm btn-secondary float-right">Atualizar</button>
            </div>
        </div>
   
</div>
