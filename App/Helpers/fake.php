<?php
fake()->define('Pages', function(Faker\Generator $faker) {
    return [
        'page_content' => $faker->text,
        'page_name' => $faker->word,
        'page_url' => $faker->word,
        'created_by' => $faker->randomDigit,
        'modified_by' => $faker->randomDigit,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});