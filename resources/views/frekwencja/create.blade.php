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
                <form action="{{ route('attendance.store', $lesson) }}" method="POST">
                    @csrf
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uczeń</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uwagi (opcjonalnie)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $student)
                                    @php
                                        $currentStatus = $attendances[$student->id]->status ?? 'present';
                                        $currentRemarks = $attendances[$student->id]->remarks ?? '';
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select name="attendance[{{ $student->id }}][status]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="present" {{ $currentStatus == 'present' ? 'selected' : '' }}>Obecny(a)</option>
                                                <option value="absent" {{ $currentStatus == 'absent' ? 'selected' : '' }}>Nieobecny(a)</option>
                                                <option value="late" {{ $currentStatus == 'late' ? 'selected' : '' }}>Spóźniony(a)</option>
                                                <option value="excused" {{ $currentStatus == 'excused' ? 'selected' : '' }}>Usprawiedliwiony(a)</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-text-input type="text" name="attendance[{{ $student->id }}][remarks]" value="{{ $currentRemarks }}" class="block w-full" placeholder="Np. spóźnienie na pociąg" />
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