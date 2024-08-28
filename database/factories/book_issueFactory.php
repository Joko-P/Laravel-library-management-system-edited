<?php

namespace Database\Factories;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class book_issueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
     public function definition()
    {
        return [
            'student_id' => random_int(1,500),
            'book_id' => random_int(1,250)
        ];
    }

    public function issued() {
        return $this->state(function(array $attributes) {
            $hour_distribution = [
                8 => 5,
                9 => 10,
                10 => 10,
                11 => 20,
                12 => 25,
                13 => 20,
                14 => 10,
                15 => 5,
                16 => 5
            ];
            $total_percentage = array_sum($hour_distribution);
            $current_date = $this->faker->dateTimeBetween('-10 days','now');
    
            // Loop until a valid datetime is generated (weekday and hour range check)
            while (!($current_date->format('N') >= 1 && $current_date->format('N') <= 5 && $current_date->format('H') >= 8 && $current_date->format('H') <= 16)) {
                $current_date = $this->faker->dateTimeBetween('-10 days', 'now');
    
                // Calculate a random percentage
                $random_percentage = mt_rand(1, $total_percentage);
    
                $cumulative_percentage = 0;
                foreach ($hour_distribution as $hour => $percentage) {
                    $cumulative_percentage += $percentage;
                    if ($random_percentage <= $cumulative_percentage) {
                        // Set the hour for the current date
                        $current_date->setTime($hour, 0);
                        break; // Exit the loop
                    }
                }
            }
    
            $return_date = new DateTime("@".strtotime($current_date->format('Y-m-d H:i:s').' + 7 days'));

            return [
                'issue_date' => $current_date,
                'return_date' => $return_date,
                'issue_status' => 'N'
            ];
        });
    }

    public function returned() {
        return $this->state(function(array $attributes) {
            $hour_distribution = [
                8 => 5,
                9 => 10,
                10 => 10,
                11 => 20,
                12 => 25,
                13 => 20,
                14 => 10,
                15 => 5,
                16 => 5
            ];
            $total_percentage = array_sum($hour_distribution);
            $current_date = $this->faker->dateTimeBetween('-2 years','-10 days');
    
            // Loop until a valid datetime is generated (weekday and hour range check)
            while (!($current_date->format('N') >= 1 && $current_date->format('N') <= 5 && $current_date->format('H') >= 8 && $current_date->format('H') <= 16)) {
                $current_date = $this->faker->dateTimeBetween('-2 years', '-10 days');
    
                // Calculate a random percentage
                $random_percentage = mt_rand(1, $total_percentage);
    
                $cumulative_percentage = 0;
                foreach ($hour_distribution as $hour => $percentage) {
                    $cumulative_percentage += $percentage;
                    if ($random_percentage <= $cumulative_percentage) {
                        // Set the hour for the current date
                        $current_date->setTime($hour, 0);
                        break; // Exit the loop
                    }
                }
            }
    
            $return_date = new DateTime("@".strtotime($current_date->format('Y-m-d H:i:s').' + 7 days'));
            $angka_random = random_int(4,10);
            $return_day = new DateTime("@".strtotime($current_date->format('Y-m-d H:i:s').' + '.$angka_random.' days'));
            if ($angka_random > 7) {
                $denda = 2000*($angka_random-7);
            } else {
                $denda = 0;
            }

            return [
                'issue_date' => $current_date,
                'return_date' => $return_date,
                'issue_status' => 'Y',
                'fines' => $denda,
                'return_day' => $return_day
            ];
        });
    }
}
