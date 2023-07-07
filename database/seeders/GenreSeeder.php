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
		DB::table('genres')->insert([
			[
				'genre' => json_encode(['en' => 'Fantasy', 'ka' => 'ფენტეზი']),
			],
			[
				'genre' => json_encode(['en' => 'Comedy', 'ka' => 'კომედია']),
			],
			[
				'genre' => json_encode(['en' => 'Drama', 'ka' => 'დრამა']),
			],
			[
				'genre' => json_encode(['en' => 'Horror', 'ka' => 'საშინელებათა ფილმი']),
			],
			[
				'genre' => json_encode(['en' => 'Mystery', 'ka' => 'მისტიკა']),
			],
			[
				'genre' => json_encode(['en' => 'Romance', 'ka' => 'რომანტიკა']),
			],
			[
				'genre' => json_encode(['en' => 'Thriller', 'ka' => 'თრილერი']),
			],
		]);
	}
}
