<?php
namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Household;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function create(Household $household)
    {
        return view('residents.create', compact('household'));
    }

    public function store(Request $request, Household $household)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'birthdate'      => 'required|date',
            'gender'         => 'required|in:Male,Female',
            'relationship'   => 'required|string|max:50',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $household->residents()->create($request->all());

        ActivityLog::log(
            'Added',
            'Resident',
            "Added resident {$request->first_name} {$request->last_name} to house #{$household->house_number}"
        );

        return redirect()->route('households.show', $household)
            ->with('success', 'Resident added successfully!');
    }

    public function edit(Resident $resident)
    {
        return view('residents.edit', compact('resident'));
    }

    public function update(Request $request, Resident $resident)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'birthdate'      => 'required|date',
            'gender'         => 'required|in:Male,Female',
            'relationship'   => 'required|string|max:50',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $resident->update($request->all());

        ActivityLog::log(
            'Updated',
            'Resident',
            "Updated resident {$resident->first_name} {$resident->last_name}"
        );

        return redirect()->route('households.show', $resident->household_id)
            ->with('success', 'Resident updated successfully!');
    }

    public function destroy(Resident $resident)
    {
        $householdId = $resident->household_id;

        ActivityLog::log(
            'Deleted',
            'Resident',
            "Deleted resident {$resident->first_name} {$resident->last_name}"
        );

        $resident->delete();

        return redirect()->route('households.show', $householdId)
            ->with('success', 'Resident removed successfully!');
    }
}