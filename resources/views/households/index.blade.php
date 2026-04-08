@extends('layouts.app')
@section('title', 'Households')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-blue-800">
        {{ auth()->user()->isAdmin() ? 'All Households' : 'My Household' }}
    </h2>
    <a href="{{ route('households.create') }}"
       class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
        + Register Household
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="w-full text-sm text-left">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">House No.</th>
                <th class="px-4 py-3">Street</th>
                <th class="px-4 py-3">Purok</th>
                <th class="px-4 py-3">Residents</th>
                @if(auth()->user()->isAdmin())
                    <th class="px-4 py-3">Registered By</th>
                @endif
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($households as $house)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                <td class="px-4 py-3">{{ $house->house_number }}</td>
                <td class="px-4 py-3">{{ $house->street }}</td>
                <td class="px-4 py-3">{{ $house->purok }}</td>
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                        {{ $house->residents->count() }} resident(s)
                    </span>
                </td>
                @if(auth()->user()->isAdmin())
                    <td class="px-4 py-3">{{ $house->user->name }}</td>
                @endif
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('households.show', $house) }}"
                       class="text-blue-600 hover:underline">View</a>
                    <a href="{{ route('households.edit', $house) }}"
                       class="text-yellow-600 hover:underline">Edit</a>
                    @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('households.destroy', $house) }}"
                          onsubmit="return confirm('Delete this household?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                    No households found. <a href="{{ route('households.create') }}" class="text-blue-600">Register one now.</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection