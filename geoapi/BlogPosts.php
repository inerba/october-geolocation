<?php namespace Inerba\Geolocation\Geoapi;

use Response;
use Illuminate\Routing\Controller;
use RainLab\Blog\Models\Post as PostModel;

/**
 * Sample Resourceful Test Controller
 */
class BlogPosts extends Controller
{
    use Traits\MappedResponse;

    public function near($lat, $lng, $max_distance=0, $paginate=10, $page=0)
    {
        $page = $page * $paginate;

        $posts = PostModel::whereNotNull('geo_lat')->whereNotNull('geo_lng')->distance($lat, $lng);
        
        if($max_distance > 0)
            $posts = $posts->having('distance', '<=', 1000);

        $posts = $posts->orderBy('distance', 'ASC')->skip($page)->take($paginate)->get();

        return $this->get_json($posts, [
            'id' => 'id',
            'title' => 'title',
            'description' => 'description',
            'km' => 'distance',
            'latitude' => 'geo_lat',
            'longitude' => 'geo_lng'
        ]);
    }

    public function geofence($lat, $lng, $inner_radius=0, $outer_radius = 50, $paginate=10, $page=0)
    {
        $page = $page * $paginate;

        $posts = PostModel::geofence($lat, $lng, $inner_radius, $outer_radius)
                    ->orderBy('distance', 'ASC')
                    ->skip($page)->take($paginate)
                    ->get();

        return $this->get_json($posts, [
            'id' => 'id',
            'title' => 'title',
            'description' => 'description',
            'latitude' => 'geo_lat',
            'longitude' => 'geo_lng'
        ]);
    }


}