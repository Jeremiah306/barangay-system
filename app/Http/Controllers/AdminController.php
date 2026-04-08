<?php
namespace App\Http\Controllers;

use App\Models\Household;
use App\Models\Resident;
use App\Models\User;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        $totalHouseholds = Household::count();
        $totalResidents  = Resident::count();
        $totalUsers      = User::where('role', 'resident')->count();
        $puroks          = Household::select('purok')
                            ->distinct()->pluck('purok');

        return view('admin.dashboard', compact(
            'totalHouseholds', 'totalResidents', 'totalUsers', 'puroks'
        ));
    }
}