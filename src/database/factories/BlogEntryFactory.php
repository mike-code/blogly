<?php

$factory->define(\App\Models\BlogEntry::class, function (Faker\Generator $faker, array $data)
{
    $user = $data['user'] ?? factory(\App\Models\User::class)->create();

    return [
        'author_id'    => $user->id,
        'author_name'  => $user->name,
        'title'        => $faker->sentence(5),
        'content'      => $faker->text(500),
        'is_published' => false,
        'created_at'   => $faker->dateTime()
    ];
});

$factory->state(\App\Models\BlogEntry::class, 'published', function (Faker\Generator $faker)
{
    return [
        'is_published' => true
    ];
});
