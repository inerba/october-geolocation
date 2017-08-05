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

    public function near($lat, $lng, $paginate=10, $page=0)
    {

        $posts = PostModel::select('id', 'title', 'description', 'geo_lat', 'geo_lng')
                        ->whereNotNull('geo_lat')->whereNotNull('geo_lng')
                        ->distance($lat, $lng)
                        ->orderBy('distance', 'ASC')
                        ->skip($page)->take($paginate)
                        ->get();

        return $this->get_json($posts);
    }

    public function geofence($lat, $lng, $inner_radius=0, $outer_radius = 50, $paginate=10, $page=0)
    {
        $page = $page * $paginate;

        $posts = PostModel::geofence($lat, $lng, $inner_radius, $outer_radius)
                    ->orderBy('distance', 'ASC')
                    ->skip($page)->take($paginate)
                    ->get();

        return $this->get_json($posts);
    }


}