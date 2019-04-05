<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BaseUrlExtension extends AbstractExtension {

  /**
   * @var string
   */
  protected $base_url_images;

  /**
   * @var string
   */
  protected $base_url_videos;

  public function __construct($base_url_config) {
    $this->base_url_images = $base_url_config['images'];
    $this->base_url_videos = $base_url_config['videos'];
  }

  public function getFilters() : array {
    return array(
      new TwigFilter('baseurlImages', array($this, 'baseurlImagesFilter')),
      new TwigFilter('baseurlVideos', array($this, 'baseurlVideosFilter')),
    );
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  public function baseurlImagesFilter($src) : string {
    return rtrim($this->base_url_images, '/').'/'.ltrim($src, '/');
  }

  public function baseurlVideosFilter($src) : string {
    return rtrim($this->base_url_videos, '/').'/'.ltrim($src, '/');
  }



}
