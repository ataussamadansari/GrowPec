<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateCitySeeder extends Seeder
{
    public function run(): void
    {
        /*
        |----------------------------------------------------------------------
        | All 28 Indian states + 8 UTs, with major cities.
        | Popular cities are strictly limited to the top 6 requested metros:
        | 1. New Delhi
        | 2. Bangalore
        | 3. Hyderabad
        | 4. Mumbai
        | 5. Kolkata
        | 6. Lucknow
        | All other cities have is_popular = false.
        |----------------------------------------------------------------------
        */
        $data = [
            'Andhra Pradesh' => [
                'popular' => [],
                'others' => ['Visakhapatnam', 'Vijayawada', 'Tirupati', 'Guntur', 'Nellore', 'Kurnool', 'Rajahmundry', 'Kakinada'],
            ],
            'Arunachal Pradesh' => [
                'popular' => [],
                'others' => ['Itanagar', 'Naharlagun', 'Pasighat'],
            ],
            'Assam' => [
                'popular' => [],
                'others' => ['Guwahati', 'Dibrugarh', 'Silchar', 'Jorhat', 'Nagaon', 'Tinsukia'],
            ],
            'Bihar' => [
                'popular' => [],
                'others' => ['Patna', 'Gaya', 'Muzaffarpur', 'Bhagalpur', 'Darbhanga', 'Purnia', 'Ara'],
            ],
            'Chhattisgarh' => [
                'popular' => [],
                'others' => ['Raipur', 'Bilaspur', 'Durg', 'Bhilai', 'Korba', 'Rajnandgaon'],
            ],
            'Goa' => [
                'popular' => [],
                'others' => ['Panaji', 'Margao', 'Vasco da Gama', 'Mapusa'],
            ],
            'Gujarat' => [
                'popular' => [],
                'others' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Gandhinagar', 'Anand', 'Nadiad'],
            ],
            'Haryana' => [
                'popular' => [],
                'others' => ['Gurugram', 'Faridabad', 'Chandigarh', 'Ambala', 'Sonipat', 'Rohtak', 'Hisar', 'Panipat', 'Karnal'],
            ],
            'Himachal Pradesh' => [
                'popular' => [],
                'others' => ['Shimla', 'Dharamsala', 'Manali', 'Solan', 'Kullu', 'Mandi'],
            ],
            'Jharkhand' => [
                'popular' => [],
                'others' => ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Hazaribagh', 'Deoghar'],
            ],
            'Karnataka' => [
                'popular' => ['Bangalore'],
                'others' => ['Bengaluru', 'Mysuru', 'Mangaluru', 'Hubli', 'Belagavi', 'Kalaburagi', 'Davanagere', 'Udupi', 'Shivamogga'],
            ],
            'Kerala' => [
                'popular' => [],
                'others' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Kannur', 'Palakkad', 'Malappuram'],
            ],
            'Madhya Pradesh' => [
                'popular' => [],
                'others' => ['Bhopal', 'Indore', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar', 'Satna', 'Rewa', 'Dewas'],
            ],
            'Maharashtra' => [
                'popular' => ['Mumbai'],
                'others' => ['Pune', 'Nagpur', 'Nashik', 'Aurangabad', 'Solapur', 'Kolhapur', 'Amravati', 'Thane', 'Navi Mumbai'],
            ],
            'Manipur' => [
                'popular' => [],
                'others' => ['Imphal', 'Thoubal', 'Bishnupur'],
            ],
            'Meghalaya' => [
                'popular' => [],
                'others' => ['Shillong', 'Tura', 'Jowai'],
            ],
            'Mizoram' => [
                'popular' => [],
                'others' => ['Aizawl', 'Lunglei'],
            ],
            'Nagaland' => [
                'popular' => [],
                'others' => ['Kohima', 'Dimapur', 'Mokokchung'],
            ],
            'Odisha' => [
                'popular' => [],
                'others' => ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur', 'Puri', 'Balasore'],
            ],
            'Punjab' => [
                'popular' => [],
                'others' => ['Chandigarh', 'Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali', 'Phagwara', 'Hoshiarpur'],
            ],
            'Rajasthan' => [
                'popular' => [],
                'others' => ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota', 'Ajmer', 'Bikaner', 'Alwar', 'Bhilwara', 'Sikar', 'Neemrana'],
            ],
            'Sikkim' => [
                'popular' => [],
                'others' => ['Gangtok', 'Namchi', 'Gyalshing'],
            ],
            'Tamil Nadu' => [
                'popular' => [],
                'others' => ['Chennai', 'Coimbatore', 'Madurai', 'Salem', 'Trichy', 'Tirunelveli', 'Vellore', 'Erode', 'Tiruppur'],
            ],
            'Telangana' => [
                'popular' => ['Hyderabad'],
                'others' => ['Warangal', 'Nizamabad', 'Khammam', 'Karimnagar', 'Ramagundam', 'Secunderabad'],
            ],
            'Tripura' => [
                'popular' => [],
                'others' => ['Agartala', 'Udaipur', 'Dharmanagar'],
            ],
            'Uttar Pradesh' => [
                'popular' => ['Lucknow'],
                'others' => ['Noida', 'Greater Noida', 'Meerut', 'Kanpur', 'Agra', 'Varanasi', 'Prayagraj', 'Ghaziabad', 'Bareilly', 'Aligarh', 'Moradabad', 'Gorakhpur', 'Mathura', 'Jhansi', 'Gajraula'],
            ],
            'Uttarakhand' => [
                'popular' => [],
                'others' => ['Dehradun', 'Haridwar', 'Roorkee', 'Nainital', 'Haldwani', 'Rishikesh', 'Kotdwar', 'Almora', 'Srinagar', 'Pauri Garhwal'],
            ],
            'West Bengal' => [
                'popular' => ['Kolkata'],
                'others' => ['Howrah', 'Durgapur', 'Siliguri', 'Asansol', 'Bardhaman', 'Malda', 'Jalpaiguri'],
            ],
            // Union Territories
            'Delhi' => [
                'popular' => ['New Delhi'],
                'others' => ['Delhi', 'Dwarka', 'Rohini', 'Janakpuri', 'Laxmi Nagar'],
            ],
            'Jammu & Kashmir' => [
                'popular' => [],
                'others' => ['Srinagar', 'Jammu', 'Anantnag', 'Baramulla', 'Sopore'],
            ],
            'Ladakh' => [
                'popular' => [],
                'others' => ['Leh', 'Kargil'],
            ],
            'Puducherry' => [
                'popular' => [],
                'others' => ['Puducherry', 'Karaikal', 'Mahe'],
            ],
            'Andaman & Nicobar Islands' => [
                'popular' => [],
                'others' => ['Port Blair'],
            ],
            'Chandigarh' => [
                'popular' => [],
                'others' => ['Chandigarh'],
            ],
            'Dadra & Nagar Haveli and Daman & Diu' => [
                'popular' => [],
                'others' => ['Daman', 'Silvassa', 'Diu'],
            ],
            'Lakshadweep' => [
                'popular' => [],
                'others' => ['Kavaratti'],
            ],
        ];

        $now = now();

        // 1. Reset all existing cities to non-popular first
        DB::table('cities')->update(['is_popular' => false]);

        // 2. Iterate and update or insert states and cities
        foreach ($data as $stateName => $cities) {
            $state = DB::table('states')->where('name', $stateName)->first();
            if ($state) {
                $stateId = $state->id;
                DB::table('states')->where('id', $stateId)->update([
                    'slug' => Str::slug($stateName),
                    'status' => true,
                    'updated_at' => $now,
                ]);
            } else {
                $stateId = DB::table('states')->insertGetId([
                    'name' => $stateName,
                    'slug' => Str::slug($stateName),
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            foreach ($cities['popular'] as $cityName) {
                $city = DB::table('cities')->where('state_id', $stateId)->where('name', $cityName)->first();
                if ($city) {
                    DB::table('cities')->where('id', $city->id)->update([
                        'is_popular' => true,
                        'status' => true,
                        'updated_at' => $now,
                    ]);
                } else {
                    DB::table('cities')->insert([
                        'state_id' => $stateId,
                        'name' => $cityName,
                        'slug' => Str::slug($cityName),
                        'is_popular' => true,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            foreach ($cities['others'] as $cityName) {
                $city = DB::table('cities')->where('state_id', $stateId)->where('name', $cityName)->first();
                if ($city) {
                    DB::table('cities')->where('id', $city->id)->update([
                        'is_popular' => false,
                        'status' => true,
                        'updated_at' => $now,
                    ]);
                } else {
                    DB::table('cities')->insert([
                        'state_id' => $stateId,
                        'name' => $cityName,
                        'slug' => Str::slug($cityName),
                        'is_popular' => false,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }

        // 3. Ensure the exact 6 popular cities are strictly set to true
        $allowedPopular = ['New Delhi', 'Bangalore', 'Hyderabad', 'Mumbai', 'Kolkata', 'Lucknow'];
        DB::table('cities')->whereIn('name', $allowedPopular)->update(['is_popular' => true]);
        DB::table('cities')->whereNotIn('name', $allowedPopular)->update(['is_popular' => false]);
    }
}
