<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PRODUCTS = [
            [ 'name' => 'Location Scoring', 'telco_name' => 'idver' ],
            [ 'name' => 'KTP Match', 'telco_name' => 'ktpscore' ],
            [ 'name' => 'Recycle Number', 'telco_name' => 'recycle' ],
            [ 'name' => 'Active Roaming', 'telco_name' => 'roaming2' ],
            [ 'name' => 'Last Location', 'telco_name' => 'lastloc2' ],
            [ 'name' => 'Interest', 'telco_name' => 'loyalist' ],
            [ 'name' => 'Telco SES', 'telco_name' => 'telcoses' ],
            [ 'name' => 'Active Status', 'telco_name' => 'substat2' ],
            [ 'name' => '1 IMEI Multiple Number', 'telco_name' => 'numberswitching2' ],
            [ 'name' => 'Call Forwarding Status', 'telco_name' => 'forwarding2' ],
            [ 'name' => 'SIM Swap', 'telco_name' => 'simswap' ],
            [ 'name' => 'Telco Score BIN 25', 'telco_name' => 'tscore' ],
        ];

        foreach ($PRODUCTS AS $keyProduct => $valueProduct) {
            Product::create($valueProduct);
        }
    }
}
