<?php namespace Inerba\Geolocation\Updates;

use Seeder;
use Faker\Factory as Faker;

class Seeder103 extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $limit = 233;

        for ($i = 0; $i < $limit; $i++) {
            $title = $faker->sentence(6, true);
            
            \DB::table('rainlab_blog_posts')->insert([ //,
                'title' => $title,
                'slug' => str_slug($title),
                'content' => $faker->text(400) ,
                'geo_lat' => $faker->latitude(-90, 90),
                'geo_lng' => $faker->longitude(-90, 90),
            ]);
        }
    }
}