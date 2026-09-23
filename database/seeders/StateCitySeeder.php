<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateCitySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('cities')->truncate();
        DB::table('states')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        /*
        |----------------------------------------------------------------------
        | All 28 Indian states + 8 UTs, with major cities.
        | Cities marked is_popular=true appear on the homepage city grid.
        |----------------------------------------------------------------------
        */
        $data = [
            'Andhra Pradesh' => [
                'popular' => ['Visakhapatnam', 'Vijayawada', 'Tirupati'],
                'others' => ['Guntur', 'Nellore', 'Kurnool', 'Rajahmundry', 'Kakinada'],
            ],
            'Arunachal Pradesh' => [
                'popular' => ['Itanagar'],
                'others' => ['Naharlagun', 'Pasighat'],
            ],
            'Assam' => [
                'popular' => ['Guwahati', 'Dibrugarh'],
                'others' => ['Silchar', 'Jorhat', 'Nagaon', 'Tinsukia'],
            ],
            'Bihar' => [
                'popular' => ['Patna', 'Gaya', 'Muzaffarpur'],
                'others' => ['Bhagalpur', 'Darbhanga', 'Purnia', 'Ara'],
            ],
            'Chhattisgarh' => [
                'popular' => ['Raipur', 'Bilaspur'],
                'others' => ['Durg', 'Bhilai', 'Korba', 'Rajnandgaon'],
            ],
            'Goa' => [
                'popular' => ['Panaji', 'Margao'],
                'others' => ['Vasco da Gama', 'Mapusa'],
            ],
            'Gujarat' => [
                'popular' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot'],
                'others' => ['Bhavnagar', 'Jamnagar', 'Gandhinagar', 'Anand', 'Nadiad'],
            ],
            'Haryana' => [
                'popular' => ['Gurugram', 'Faridabad', 'Chandigarh'],
                'others' => ['Ambala', 'Sonipat', 'Rohtak', 'Hisar', 'Panipat', 'Karnal'],
            ],
            'Himachal Pradesh' => [
                'popular' => ['Shimla', 'Dharamsala'],
                'others' => ['Manali', 'Solan', 'Kullu', 'Mandi'],
            ],
            'Jharkhand' => [
                'popular' => ['Ranchi', 'Jamshedpur', 'Dhanbad'],
                'others' => ['Bokaro', 'Hazaribagh', 'Deoghar'],
            ],
            'Karnataka' => [
                'popular' => ['Bengaluru', 'Mysuru', 'Mangaluru', 'Hubli'],
                'others' => ['Belagavi', 'Kalaburagi', 'Davanagere', 'Udupi', 'Shivamogga'],
            ],
            'Kerala' => [
                'popular' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode'],
                'others' => ['Thrissur', 'Kollam', 'Kannur', 'Palakkad', 'Malappuram'],
            ],
            'Madhya Pradesh' => [
                'popular' => ['Bhopal', 'Indore', 'Jabalpur', 'Gwalior'],
                'others' => ['Ujjain', 'Sagar', 'Satna', 'Rewa', 'Dewas'],
            ],
            'Maharashtra' => [
                'popular' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik'],
                'others' => ['Aurangabad', 'Solapur', 'Kolhapur', 'Amravati', 'Thane', 'Navi Mumbai'],
            ],
            'Manipur' => [
                'popular' => ['Imphal'],
                'others' => ['Thoubal', 'Bishnupur'],
            ],
            'Meghalaya' => [
                'popular' => ['Shillong'],
                'others' => ['Tura', 'Jowai'],
            ],
            'Mizoram' => [
                'popular' => ['Aizawl'],
                'others' => ['Lunglei'],
            ],
            'Nagaland' => [
                'popular' => ['Kohima', 'Dimapur'],
                'others' => ['Mokokchung'],
            ],
            'Odisha' => [
                'popular' => ['Bhubaneswar', 'Cuttack', 'Rourkela'],
                'others' => ['Berhampur', 'Sambalpur', 'Puri', 'Balasore'],
            ],
            'Punjab' => [
                'popular' => ['Chandigarh', 'Ludhiana', 'Amritsar', 'Jalandhar'],
                'others' => ['Patiala', 'Bathinda', 'Mohali', 'Phagwara', 'Hoshiarpur'],
            ],
            'Rajasthan' => [
                'popular' => ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota'],
                'others' => ['Ajmer', 'Bikaner', 'Alwar', 'Bhilwara', 'Sikar'],
            ],
            'Sikkim' => [
                'popular' => ['Gangtok'],
                'others' => ['Namchi', 'Gyalshing'],
            ],
            'Tamil Nadu' => [
                'popular' => ['Chennai', 'Coimbatore', 'Madurai', 'Salem'],
                'others' => ['Trichy', 'Tirunelveli', 'Vellore', 'Erode', 'Tiruppur'],
            ],
            'Telangana' => [
                'popular' => ['Hyderabad', 'Warangal', 'Nizamabad'],
                'others' => ['Khammam', 'Karimnagar', 'Ramagundam', 'Secunderabad'],
            ],
            'Tripura' => [
                'popular' => ['Agartala'],
                'others' => ['Udaipur', 'Dharmanagar'],
            ],
            'Uttar Pradesh' => [
                'popular' => ['Lucknow', 'Kanpur', 'Agra', 'Varanasi', 'Prayagraj', 'Noida'],
                'others' => ['Meerut', 'Ghaziabad', 'Bareilly', 'Aligarh', 'Moradabad', 'Gorakhpur', 'Mathura', 'Jhansi'],
            ],
            'Uttarakhand' => [
                'popular' => ['Dehradun', 'Haridwar', 'Roorkee'],
                'others' => ['Nainital', 'Haldwani', 'Rishikesh', 'Kotdwar'],
            ],
            'West Bengal' => [
                'popular' => ['Kolkata', 'Howrah', 'Durgapur', 'Siliguri'],
                'others' => ['Asansol', 'Bardhaman', 'Malda', 'Jalpaiguri'],
            ],
            // Union Territories
            'Delhi' => [
                'popular' => ['New Delhi', 'Delhi'],
                'others' => ['Dwarka', 'Rohini', 'Janakpuri', 'Laxmi Nagar'],
            ],
            'Jammu & Kashmir' => [
                'popular' => ['Srinagar', 'Jammu'],
                'others' => ['Anantnag', 'Baramulla', 'Sopore'],
            ],
            'Ladakh' => [
                'popular' => ['Leh'],
                'others' => ['Kargil'],
            ],
            'Puducherry' => [
                'popular' => ['Puducherry'],
                'others' => ['Karaikal', 'Mahe'],
            ],
            'Andaman & Nicobar Islands' => [
                'popular' => ['Port Blair'],
                'others' => [],
            ],
            'Chandigarh' => [
                'popular' => ['Chandigarh'],
                'others' => [],
            ],
            'Dadra & Nagar Haveli and Daman & Diu' => [
                'popular' => ['Daman'],
                'others' => ['Silvassa', 'Diu'],
            ],
            'Lakshadweep' => [
                'popular' => ['Kavaratti'],
                'others' => [],
            ],
        ];

        $now = now();

        foreach ($data as $stateName => $cities) {
            $stateId = DB::table('states')->insertGetId([
                'name' => $stateName,
                'slug' => Str::slug($stateName),
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $cityRows = [];

            foreach ($cities['popular'] as $city) {
                $cityRows[] = [
                    'state_id' => $stateId,
                    'name' => $city,
                    'slug' => Str::slug($city),
                    'is_popular' => true,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach ($cities['others'] as $city) {
                $cityRows[] = [
                    'state_id' => $stateId,
                    'name' => $city,
                    'slug' => Str::slug($city),
                    'is_popular' => false,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (! empty($cityRows)) {
                DB::table('cities')->insert($cityRows);
            }
        }
    }
}
