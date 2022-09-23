<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Faker\Factory;
use DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Invoice::truncate();
        InvoiceItem::truncate();

        foreach(range(1, 100) as $i) {
            foreach(range(1, 28) as $j) {
                $invoice = Invoice::create([
                    'number' => 'INV-'.mt_rand(1000000000, 9999999999),
                    'customer_id' => rand(1, 100),
                    'date' => '2078-'.mt_rand(01, 12).'-'.$j,
                    'due_date' => '2078-'.mt_rand(01, 12).'-'.$j,
                    'reference' => 'LPO #'.$i,
                    'terms_and_conditions' => $faker->text,
                    'discount' => mt_rand(5, 20),
                    'sub_total' => mt_rand(10000, 90000),
                    'extra_cost' => mt_rand(0, 100),
                    'status' => rand(0,1) ? 'Paid' :  'Un paid'
                ]);    
            }
            
            foreach(range(1, mt_rand(2, 4)) as $j) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => mt_rand(1, 40),
                    'unit_price' => mt_rand(100, 500),
                    'qty' => mt_rand(1, 6)
                ]);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
