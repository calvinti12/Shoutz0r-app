<?php

namespace Intervention\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProviderLaravel5 extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../../config/config.php' => config_path('image.php')]);

        // setup intervention/imagecache if package is installed
        $this->cacheIsInstalled() ? $this->bootstrapImageCache() : null;
    }

    /**
     * Determines if Intervention Imagecache is installed
     *
     * @return boolean
     */
    private function cacheIsInstalled()
    {
        return class_exists('Intervention\\Image\\ImageCache');
    }

    /**
     * Bootstrap imagecache
     *
     * @return void
     */
    protected function bootstrapImageCache()
    {
        $app = $this->app;
        $config = __DIR__.'/../../../../imagecache/src/config/config.php';

        $this->publishes([$config => config_path('imagecache.php')]);

        // merge default config
        $this->mergeConfigFrom($config, 'imagecache');

        // imagecache route
        if (is_string(config('imagecache.route'))) {

            $filename_pattern = '[ \w\\.\\/\\-\\@\(\)]+';

            // route to access template applied image file
            $app['router']->get(
                config('imagecache.route').'/{template}/{filename}',
                ['uses' => 'Intervention\Image\ImageCacheController@getResponse', 'as' => 'imagecache']
            )->where(['filename' => $filename_pattern]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // merge default config
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'image');

        // create image
        $app->singleton(
            'image',
            function ($app) {
                return new ImageManager($app['config']->get('image'));
            }
        );

        $app->alias('image', 'Intervention\Image\ImageManager');
    }
}
