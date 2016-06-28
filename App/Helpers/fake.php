<?php
fake()->define('Pages', function(Faker\Generator $faker) {
    return [
        'page_content' => $faker->text,
        'page_name' => $faker->name,
        'page_url' => $faker->url,
        'created_by' => $faker->name,
        'modified_by' => $faker->name,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});