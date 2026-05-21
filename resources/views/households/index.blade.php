@extends('layouts.app')
@section('title', 'Households')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-800">
        {{ auth()->user()->isAdmin() ? 'All Households' : 'My Household' }}
    </h2>
    <a href="{{ route('households.create') }}"
       class="bg-blue-700 text-white px-4 py-2 rounded-xl hover:bg-blue-800 font-semibold">
        + Register Household
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-2xl shadow-md">
    <table class="w-full text-sm text-left">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">House No.</th>
                <th class="px-4 py-3">Street</th>
                <th class="px-4 py-3">Purok</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Residents</th>
                @if(auth()->user()->isAdmin())
                    <th class="px-4 py-3">Registered By</th>
                @endif
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($households as $index => $house)
            <tr class="border-b hover:bg-gray-50 transition-colors">
                {{-- Correct number even on page 2, 3, etc. --}}
                <td class="px-4 py-3 text-gray-500">
                    {{ ($households->currentPage() - 1) * $households->perPage() + $index + 1 }}
                </td>
                <td class="px-4 py-3 font-bold text-blue-800">{{ $house->house_number }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $house->street }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $house->purok }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ ($house->residency_type ?? 'Permanent') == 'Permanent'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $house->residency_type ?? 'Permanent' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $house->residents->count() }} resident(s)
                    </span>
                </td>
                @if(auth()->user()->isAdmin())
                    <td class="px-4 py-3 text-gray-600">{{ $house->user->name }}</td>
                @endif
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('households.show', $house) }}"
                           class="text-blue-600 hover:underline text-xs font-semibold">👁️ View</a>
                        <a href="{{ route('households.edit', $house) }}"
                           class="text-yellow-600 hover:underline text-xs font-semibold">✏️ Edit</a>
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('households.destroy', $house) }}"
                              onsubmit="return confirm('Delete this household?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:underline text-xs font-semibold">🗑️ Delete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}"
                    class="px-4 py-8 text-center text-gray-400">
                    <p class="text-3xl mb-2">🏚️</p>
                    <p>No households found.</p>
                    <a href="{{ route('households.create') }}"
                       class="text-blue-600 hover:underline text-sm">Register one now.</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination Links --}}
@if($households->hasPages())
<div class="mt-6 flex flex-col items-center gap-2">
    {{-- Info text --}}
    <p class="text-sm text-gray-500">
        Showing {{ $households->firstItem() }}–{{ $households->lastItem() }}
        of {{ $households->total() }} households
    </p>
    {{-- Page links --}}
    <div class="flex gap-2 flex-wrap justify-center">
        {{-- Previous --}}
        @if($households->onFirstPage())
            <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 text-sm cursor-not-allowed">
                ← Prev
            </span>
        @else
            <a href="{{ $households->previousPageUrl() }}"
               class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm hover:bg-blue-800 transition-colors">
                ← Prev
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach($households->getUrlRange(1, $households->lastPage()) as $page => $url)
            @if($page == $households->currentPage())
                <span class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm font-bold">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}"
                   class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 text-sm hover:bg-gray-200 transition-colors">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($households->hasMorePages())
            <a href="{{ $households->nextPageUrl() }}"
               class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm hover:bg-blue-800 transition-colors">
                Next →
            </a>
        @else
            <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 text-sm cursor-not-allowed">
                Next →
            </span>
        @endif
    </div>
</div>
@endif

@endsection