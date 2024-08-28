<?php

namespace Database\Seeders;

use App\Models\book_issue;
use Database\Factories\book_issueActiveFactory;
use Database\Factories\book_issueFactory;
use Illuminate\Database\Seeder;

class BookIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (book_issue::count() == 0) {
            book_issue::factory()->count(6000)->returned()->create();
            book_issue::factory()->count(80)->issued()->create();
        }
    }
}
