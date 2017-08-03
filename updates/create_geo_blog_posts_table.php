<?php namespace Inerba\Geolocation\Updates;
use Schema;
use October\Rain\Database\Updates\Migration;
use System\Classes\PluginManager;
class CreateGeoBlogPostsTable extends Migration
{
    public function up()
    {
        if(PluginManager::instance()->hasPlugin('RainLab.Blog'))
        {
            Schema::table('rainlab_blog_posts', function($table)
            {
                $table->double('geo_lat')->nullable();
                $table->double('geo_lng')->nullable();
                $table->text('geo_components')->nullable();
            });
        }
    }
    public function down()
    {
        if(PluginManager::instance()->hasPlugin('RainLab.Blog'))
        {
            Schema::table('rainlab_blog_posts', function($table)
            {
                $table->dropColumn('geo_lat');
                $table->dropColumn('geo_lng');
                $table->dropColumn('geo_components');
            });
        }
    }
}