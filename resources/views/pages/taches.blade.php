<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(isset($projet))
            <div class="mb-6 pb-4 border-b">
                <h1 class="text-2xl font-bold">{{ $projet->title }}</h1>
                <p class="text-gray-600">Référence: {{ $projet->ref }}</p>
            </div>
        @endif

        <h2 class="text-xl font-bold mb-6">{{ $title }}</h2>

        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $error }}
            </div>
        @endif

        @if(!empty($data))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($data as $tache)
                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $tache->label ?? 'Sans titre' }}
                        </h3>
                        <div class="mt-2 space-y-2 text-gray-600">
                            <p class="flex items-start">
                                <span class="font-medium w-24">Référence:</span>
                                <span>{{ $tache->ref }}</span>
                            </p>
                            @if(isset($tache->date_start))
                                <p class="flex items-start">
                                    <span class="font-medium w-24">Début:</span>
                                    <span>{{ date('d/m/Y', strtotime($tache->date_start)) }}</span>
                                </p>
                            @endif
                            @if(isset($tache->date_end))
                                <p class="flex items-start">
                                    <span class="font-medium w-24">Fin:</span>
                                    <span>{{ date('d/m/Y', strtotime($tache->date_end)) }}</span>
                                </p>
                            @endif
                            @if(isset($tache->progress))
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                                Progression
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-semibold inline-block text-blue-600">
                                                {{ $tache->progress }}%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                                        <div style="width:{{ $tache->progress }}%"
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <p class="flex items-start">
                                <span class="font-medium w-24">Statut:</span>
                                <span class="px-2 py-1 rounded text-sm
                                    {{ $tache->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $tache->status == 1 ? 'En cours' : 'Terminée' }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-gray-500 text-sm">
                Total: {{ count($data) }} tâches trouvées
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">Aucune tâche trouvée.</p>
            </div>
        @endif

        @if(isset($projet))
            <div class="mt-6">
                <a href="/projets" class="text-blue-600 hover:underline">
                    ← Retour aux projets
                </a>
            </div>
        @endif
    </div>
</div>
