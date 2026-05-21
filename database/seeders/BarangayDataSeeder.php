<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Household;
use App\Models\Resident;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BarangayDataSeeder extends Seeder
{
    public function run(): void
    {
        // Sample data arrays
        $firstNames = [
            'Juan', 'Maria', 'Jose', 'Ana', 'Pedro', 'Rosa', 'Carlos', 'Elena',
            'Roberto', 'Luz', 'Eduardo', 'Carmen', 'Ricardo', 'Gloria', 'Fernando',
            'Teresa', 'Manuel', 'Cristina', 'Antonio', 'Patricia', 'Miguel', 'Sandra',
            'Francisco', 'Maricel', 'Alejandro', 'Rowena', 'Danilo', 'Maribel',
            'Romeo', 'Lourdes', 'Ernesto', 'Jocelyn', 'Reynaldo', 'Melinda',
            'Wilfredo', 'Florencia', 'Alfredo', 'Vivian', 'Rodolfo', 'Esperanza'
        ];

        $lastNames = [
            'Santos', 'Reyes', 'Cruz', 'Bautista', 'Ocampo', 'Garcia', 'Mendoza',
            'Torres', 'Castillo', 'Flores', 'Ramos', 'Aquino', 'Villanueva',
            'Fernandez', 'Lopez', 'Martinez', 'Gonzales', 'Perez', 'Rivera',
            'Dela Cruz', 'Diaz', 'Morales', 'Ramirez', 'Navarro', 'Pascual',
            'Valdez', 'Domingo', 'Bernardo', 'Soriano', 'Aguilar'
        ];

        $streets = [
            'Mabini Street, Barangay Bucana, Davao City',
            'Rizal Avenue, Barangay Poblacion, Davao City',
            'Bonifacio Street, Barangay Toril, Davao City',
            'Quezon Boulevard, Barangay Agdao, Davao City',
            'Magsaysay Avenue, Barangay Buhangin, Davao City',
            'Luna Street, Barangay Panacan, Davao City',
            'Del Pilar Street, Barangay Tibungco, Davao City',
            'Osmena Street, Barangay Lasang, Davao City',
        ];

        $puroks = ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5'];

        $residencyTypes = ['Permanent', 'Permanent', 'Permanent', 'Temporary'];

        $relationships = ['Head', 'Spouse', 'Child', 'Child', 'Parent', 'Sibling'];

        $genders = ['Male', 'Female'];

        // Create 20 resident users with households and members
        for ($i = 1; $i <= 20; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName  = $lastNames[array_rand($lastNames)];
            $email     = strtolower($firstName . $i . '@barangay.com');

            // Create user
            $user = User::create([
                'name'     => $firstName . ' ' . $lastName,
                'email'    => $email,
                'password' => Hash::make('password123'),
                'role'     => 'resident',
            ]);

            // Create household for user
            $household = Household::create([
                'user_id'        => $user->id,
                'house_number'   => rand(1, 200) . '-' . chr(rand(65, 90)),
                'street'         => $streets[array_rand($streets)],
                'purok'          => $puroks[array_rand($puroks)],
                'residency_type' => $residencyTypes[array_rand($residencyTypes)],
            ]);

            // Add 3-6 residents per household
            $residentCount = rand(3, 6);
            for ($j = 0; $j < $residentCount; $j++) {
                $resFirstName = $firstNames[array_rand($firstNames)];
                $resLastName  = $lastName; // same family name
                $gender       = $genders[array_rand($genders)];
                $relationship = $j === 0 ? 'Head' : $relationships[array_rand($relationships)];

                // Random birthdate between 1950 and 2010
                $year  = rand(1950, 2010);
                $month = rand(1, 12);
                $day   = rand(1, 28);

                Resident::create([
                    'household_id'   => $household->id,
                    'first_name'     => $resFirstName,
                    'last_name'      => $resLastName,
                    'birthdate'      => "$year-$month-$day",
                    'gender'         => $gender,
                    'relationship'   => $relationship,
                    'contact_number' => '09' . rand(100000000, 999999999),
                    'residency_type' => 'Permanent',
                ]);
            }
        }

        $this->command->info('✅ Successfully seeded 20 users with households and 100+ residents!');
    }
}