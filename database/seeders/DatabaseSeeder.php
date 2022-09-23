<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'first_name' => 'Abhishek',
            'last_name' => 'Chaudhary',
            'email' => 'iamdev.abhishek@gmail.com',
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        
        User::factory(50)->create();
        
        $this->call(VendorSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(ExpenseSeeder::class);
    }
}
