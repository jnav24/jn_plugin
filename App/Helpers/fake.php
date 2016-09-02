<?php
fake()->define('Pages', function(Faker\Generator $faker) {
    return [
        'page_content' => $faker->text,
        'page_name' => $faker->word,
        'page_url' => $faker->word,
        'created_by' => 1,
        'modified_by' => 1,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});