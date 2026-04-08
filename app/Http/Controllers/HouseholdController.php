<?php
namespace App\Http\Controllers;

use App\Models\Household;
use Illuminate\Http\Request;

class HouseholdController extends Controller
{
    

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $households = Household::with(['residents', 'user'])->get();
        } else {
            $households = Household::with('residents')
                ->where('user_id', auth()->id())->get();
        }
        return view('households.index', compact('households'));
    }

    public function create()
    {
        return view('households.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'house_number' => 'required|string|max:50',
            'street' => 'required|string|max:100',
            'purok' => 'required|string|max:50',
        ]);

        Household::create([
            'house_number' => $request->house_number,
            'street' => $request->street,
            'purok' => $request->purok,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('households.index')
            ->with('success', 'Household registered successfully!');
    }

    public function show(Household $household)
    {
        $this->authorizeAccess($household);
        $household->load('residents');
        return view('households.show', compact('household'));
    }

    public function edit(Household $household)
    {
        $this->authorizeAccess($household);
        return view('households.edit', compact('household'));
    }

    public function update(Request $request, Household $household)
    {
        $this->authorizeAccess($household);
        $request->validate([
            'house_number' => 'required|string|max:50',
            'street' => 'required|string|max:100',
            'purok' => 'required|string|max:50',
        ]);

        $household->update($request->only(['house_number', 'street', 'purok']));

        return redirect()->route('households.index')
            ->with('success', 'Household updated successfully!');
    }

    public function destroy(Household $household)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $household->delete();
        return redirect()->route('households.index')
            ->with('success', 'Household deleted successfully!');
    }

    private function authorizeAccess(Household $household)
    {
        if (!auth()->user()->isAdmin() && $household->user_id !== auth()->id()) {
            abort(403);
        }
    }
}