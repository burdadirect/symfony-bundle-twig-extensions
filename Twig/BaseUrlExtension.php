<?php

namespace HBM\TwigExtensionsBundle\Twig;

class BaseUrlExtension extends \Twig_Extension {

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
      new \Twig_SimpleFilter('baseurlImages', array($this, 'baseurlImagesFilter')),
      new \Twig_SimpleFilter('baseurlVideos', array($this, 'baseurlVideosFilter')),
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
