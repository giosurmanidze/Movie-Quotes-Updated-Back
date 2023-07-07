<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$genres = [
			['en' => 'Horror', 'ka' => 'საშინელებათა ფილმი'],
			['en' => 'Fantasy', 'ka' => 'ფენტეზი'],
			['en' => 'Comedy', 'ka' => 'კომედია'],
			['en' => 'Drama', 'ka' => 'დრამა'],
			['en' => 'Mystery', 'ka' => 'მისტიკა'],
			['en' => 'Romance', 'ka' => 'რომანტიკა'],
			['en' => 'Thriller', 'ka' => 'თრილერი'],
			['en' => 'Western', 'ka' => 'ვესტერნი'],
		];

		$records = [];
		foreach ($genres as $genre) {
			$records[] = [
				'genre' => json_encode($genre),
			];
		}

		DB::table('genres')->insert($records);
	}
}
