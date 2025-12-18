<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class GithubUpdates extends Component
{
    public $commits = [];

    public function mount()
    {
        $this->loadCommits();
    }

    public function loadCommits()
    {
        $repoUser = config('services.github.user'); // exemplo: renato
        $repoName = config('services.github.repo'); // exemplo: noronhashop

        $response = Http::get("https://api.github.com/repos/{$repoUser}/{$repoName}/commits");
        
        if ($response->successful()) {
            $this->commits = array_slice($response->json(), 0, 5); // últimos 5 commits
        }
    }

    public function render()
    {
        return view('livewire.dashboard.github-updates');
    }
}
