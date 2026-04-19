<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista obecności: {{ $lesson->subject->name }} ({{ $lesson->classGroup->name }})
        </h2>
        <p class="text-sm text-gray-500">{{ $lesson->start }} - {{ $lesson->end }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('frekwencja.store', $lesson) }}" method="POST">
                    @csrf
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uczeń</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uwagi (opcjonalne)</th>
                                </tr>
                            </thead>
                            @if ($errors->any())
                            <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                                </ul>
                                </div>
                            @endif
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $student)
                                    @php
                                        $currentStatus = $frekwencje[$student->id]->status ?? 'obecny';
                                        $currentRemarks = $frekwencje[$student->id]->uwagi ?? '';
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
    <select name="frekwencja[{{ $student->id }}][status]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="obecny" {{ $currentStatus == 'obecny' ? 'selected' : '' }}>Obecny(a)</option>
        <option value="nieobecny" {{ $currentStatus == 'nieobecny' ? 'selected' : '' }}>Nieobecny(a)</option>
        <option value="spóźniony" {{ $currentStatus == 'spóźniony' ? 'selected' : '' }}>Spóźniony(a)</option>
        <option value="usprawiedliwienie" {{ $currentStatus == 'usprawiedliwienie' ? 'selected' : '' }}>Usprawiedliwiony(a)</option>
    </select>
</td>
<td class="px-6 py-4 whitespace-nowrap">
    <x-text-input type="text" name="frekwencja[{{ $student->id }}][uwagi]" value="{{ $currentRemarks }}" class="block w-full" placeholder="Np. spóźnienie na pociąg" />
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6 flex items-center justify-end">
                        <x-primary-button>
                            Zapisz listę obecności
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>