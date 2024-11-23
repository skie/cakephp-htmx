<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Faker\Factory;

class PostsSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Factory::create();
        $data = [];

        for ($i = 0; $i < 500; $i++) {
            $created = $faker->dateTimeBetween('-1 year', 'now');
            $data[] = [
                'title' => $faker->sentence(6),
                'overview' => $faker->paragraph(2),
                'body' => $faker->paragraphs(5, true),
                'is_published' => $faker->boolean(70), // 70% chance of being published
                'created' => $created->format('Y-m-d H:i:s'),
                'modified' => $created->format('Y-m-d H:i:s'),
            ];
        }

        $table = $this->table('posts');
        $table->insert($data)->save();
    }
}
