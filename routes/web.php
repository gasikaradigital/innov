<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Caprel\Dolibarr\Models\DolibarrInvoices;
use Caprel\Dolibarr\Models\DolibarrProposals;
use Caprel\Dolibarr\Models\DolibarrThirdparties;

Route::get('/', function () {
    return view('pages.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/tiers', function () {
    try {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . '/api/index.php/thirdparties');

        if (!$response->successful()) {
            throw new Exception('Erreur API: ' . $response->status());
        }

        $data = $response->json();

        // Transformons les données en objets pour maintenir la compatibilité
        $data = array_map(function($item) {
            return (object) $item;
        }, $data);

        return view('pages/tiers', [
            'data' => $data,
            'title' => 'Liste des tiers'
        ]);
    } catch (\Exception $e) {
        return view('pages/tiers', [
            'data' => [],
            'error' => $e->getMessage(),
            'title' => 'Liste des tiers'
        ]);
    }
});


// Route pour les factures
Route::get('/factures', function () {
    try {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . '/api/index.php/invoices');

        if (!$response->successful()) {
            throw new Exception('Erreur API: ' . $response->status());
        }

        $data = $response->json();

        // Transformation en objets
        $data = array_map(function($item) {
            return (object) $item;
        }, $data);

        return view('pages/factures', [
            'data' => $data,
            'title' => 'Liste des factures',
            'error' => null
        ]);
    } catch (\Exception $e) {
        return view('pages/factures', [
            'data' => [],
            'title' => 'Liste des factures',
            'error' => $e->getMessage()
        ]);
    }
});

// Route pour les devis
Route::get('/devis', function () {
    try {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . '/api/index.php/proposals');

        if (!$response->successful()) {
            throw new Exception('Erreur API: ' . $response->status());
        }

        $data = $response->json();

        // Transformation en objets
        $data = array_map(function($item) {
            return (object) $item;
        }, $data);

        return view('pages/devis', [
            'data' => $data,
            'title' => 'Liste des devis',
            'error' => null
        ]);
    } catch (\Exception $e) {
        return view('pages/devis', [
            'data' => [],
            'title' => 'Liste des devis',
            'error' => $e->getMessage()
        ]);
    }
});


// Route pour les projets
Route::get('/projets', function () {
    try {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . '/api/index.php/projects', [
                'limit' => 100,
                'sortfield' => 't.dateo',
                'sortorder' => 'DESC'
            ]);

        if (!$response->successful()) {
            throw new Exception('Erreur API: ' . $response->status());
        }

        $data = array_map(function($item) {
            return (object) $item;
        }, $response->json());

        return view('pages/projets', [
            'data' => $data,
            'title' => 'Liste des Projets'
        ]);
    } catch (\Exception $e) {
        return view('pages/projets', [
            'data' => [],
            'title' => 'Liste des Projets',
            'error' => $e->getMessage()
        ]);
    }
});

// Route pour les tâches d'un projet spécifique
Route::get('/projets/{id}/taches', function ($id) {
    try {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . "/api/index.php/projects/{$id}/tasks");

        if (!$response->successful()) {
            throw new Exception('Erreur API: ' . $response->status());
        }

        $data = array_map(function($item) {
            return (object) $item;
        }, $response->json());

        // Récupérer les détails du projet
        $projetResponse = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . "/api/index.php/projects/{$id}");

        $projet = (object) $projetResponse->json();

        return view('pages/taches', [
            'data' => $data,
            'projet' => $projet,
            'title' => "Tâches du projet : {$projet->title}"
        ]);
    } catch (\Exception $e) {
        return view('pages/taches', [
            'data' => [],
            'projet' => null,
            'title' => 'Liste des Tâches',
            'error' => $e->getMessage()
        ]);
    }
});

// Route pour toutes les tâches
Route::get('/taches', function () {
    try {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'DOLAPIKEY' => env('DOLIBARR_API_KEY')
            ])
            ->get(env('DOLIBARR_SERVER_URI') . '/api/index.php/tasks', [
                'limit' => 100,
                'sortfield' => 't.dateo',
                'sortorder' => 'DESC'
            ]);

        if (!$response->successful()) {
            throw new Exception('Erreur API: ' . $response->status());
        }

        $data = array_map(function($item) {
            return (object) $item;
        }, $response->json());

        return view('pages/taches', [
            'data' => $data,
            'title' => 'Toutes les Tâches'
        ]);
    } catch (\Exception $e) {
        return view('pages/taches', [
            'data' => [],
            'title' => 'Toutes les Tâches',
            'error' => $e->getMessage()
        ]);
    }
});
