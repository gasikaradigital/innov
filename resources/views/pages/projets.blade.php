<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>

        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $error }}
            </div>
        @endif

        @if(!empty($data))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($data as $projet)
                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ $projet->title ?? $projet->ref ?? 'Sans titre' }}
                        </h2>
                        <div class="mt-2 space-y-2 text-gray-600">
                            <p class="flex items-start">
                                <span class="font-medium w-24">Référence:</span>
                                <span>{{ $projet->ref }}</span>
                            </p>
                            @if(isset($projet->date_start))
                                <p class="flex items-start">
                                    <span class="font-medium w-24">Début:</span>
                                    <span>{{ date('d/m/Y', strtotime($projet->date_start)) }}</span>
                                </p>
                            @endif
                            @if(isset($projet->date_end))
                                <p class="flex items-start">
                                    <span class="font-medium w-24">Fin:</span>
                                    <span>{{ date('d/m/Y', strtotime($projet->date_end)) }}</span>
                                </p>
                            @endif
                            <p class="flex items-start">
                                <span class="font-medium w-24">Statut:</span>
                                <span class="px-2 py-1 rounded text-sm
                                    {{ $projet->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $projet->status == 1 ? 'En cours' : 'Terminé' }}
                                </span>
                            </p>
                            <div class="mt-4">
                                <a href="/projets/{{ $projet->id }}/taches"
                                   class="text-blue-600 hover:underline">
                                    Voir les tâches →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-gray-500 text-sm">
                Total: {{ count($data) }} projets trouvés
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">Aucun projet trouvé.</p>
            </div>
        @endif
    </div>
</div>
