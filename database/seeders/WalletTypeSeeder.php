<?php

namespace Database\Seeders;

use App\Models\WalletType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $walletTypes = [
            [
                'name' => 'wallet_one',
                'display_name' => 'Wallet One',
                'minimum_balance' => 0,
                'monthly_interest_rate' => 1
            ],
            [
                'name' => 'wallet_two',
                'display_name' => 'Wallet Two',
                'minimum_balance' => 5000,
                'monthly_interest_rate' => 5
            ],
            [
                'name' => 'wallet_three',
                'display_name' => 'Wallet Three',
                'minimum_balance' => 50000,
                'monthly_interest_rate' => 15
            ]
        ];

        foreach ($walletTypes as $walletType) {
            WalletType::create($walletType);
        }
    }
}
