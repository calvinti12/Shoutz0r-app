<?php

namespace Intervention\Image\Imagick\Shapes;

use ImagickDraw;
use Intervention\Image\AbstractShape;
use Intervention\Image\Image;
use Intervention\Image\Imagick\Color;

class PolygonShape extends AbstractShape
{
    /**
     * Array of points of polygon
     *
     * @var array
     */
    public $points;

    /**
     * Create new polygon instance
     *
     * @param  array  $points
     */
    public function __construct($points)
    {
        $this->points = $this->formatPoints($points);
    }

    /**
     * Format polygon points to Imagick format
     *
     * @param  Array  $points
     * @return Array
     */
    private function formatPoints($points)
    {
        $ipoints = [];
        $count = 1;

        foreach ($points as $key => $value) {
            if ($count % 2 === 0) {
                $y = $value;
                $ipoints[] = ['x' => $x, 'y' => $y];
            } else {
                $x = $value;
            }
            $count++;
        }

        return $ipoints;
    }

    /**
     * Draw polygon on given image
     *
     * @param  Image  $image
     * @param  int  $x
     * @param  int  $y
     * @return boolean
     */
    public function applyToImage(Image $image, $x = 0, $y = 0)
    {
        $polygon = new ImagickDraw;

        // set background
        $bgcolor = new Color($this->background);
        $polygon->setFillColor($bgcolor->getPixel());

        // set border
        if ($this->hasBorder()) {
            $border_color = new Color($this->border_color);
            $polygon->setStrokeWidth($this->border_width);
            $polygon->setStrokeColor($border_color->getPixel());
        }

        $polygon->polygon($this->points);

        $image->getCore()->drawImage($polygon);

        return true;
    }
}
