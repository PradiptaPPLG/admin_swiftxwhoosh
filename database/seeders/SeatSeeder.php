<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    public function run()
    {
        // Clear existing seats first to avoid duplication
        DB::table('seats')->truncate();

        $trains = DB::table('trains')->get();

        foreach ($trains as $train) {
            $seats = [];
            
            // Wagon 1: First Class (W1) - Row 1 to 5
            for ($row = 1; $row <= 5; $row++) {
                foreach (['A', 'C'] as $col) { // 1-1 layout for First Class
                    $seats[] = [
                        'train_id' => $train->train_id,
                        'seat_number' => "W1-0{$row}{$col}",
                        'class' => 'vip',
                    ];
                }
            }

            // Wagon 2: Business Class (W2) - Row 1 to 7
            for ($row = 1; $row <= 7; $row++) {
                foreach (['A', 'B', 'D', 'E'] as $col) { // 2-2 layout
                    $seats[] = [
                        'train_id' => $train->train_id,
                        'seat_number' => "W2-0{$row}{$col}",
                        'class' => 'business',
                    ];
                }
            }

            // Wagon 3 to 8: Premium Economy (W3-W8) - Row 1 to 12
            for ($w = 3; $w <= 8; $w++) {
                for ($row = 1; $row <= 12; $row++) {
                    $rowStr = $row < 10 ? "0$row" : "$row";
                    foreach (['A', 'B', 'C', 'D', 'E'] as $col) { // 3-2 layout
                        $seats[] = [
                            'train_id' => $train->train_id,
                            'seat_number' => "W{$w}-{$rowStr}{$col}",
                            'class' => 'economy',
                        ];
                    }
                }
            }

            // Insert in chunks to avoid memory issues
            foreach (array_chunk($seats, 100) as $chunk) {
                DB::table('seats')->insert($chunk);
            }
        }
    }
}
