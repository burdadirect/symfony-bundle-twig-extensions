<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ResponsiveSvgExtension extends AbstractExtension {

  /**
   * @var
   */
  private $config;

  /**
   * @var LoggerInterface
   */
  private $logger;

  /**
   * ResponsiveSvgExtension constructor.
   *
   * @param $config
   * @param LoggerInterface $logger
   */
  public function __construct($config, LoggerInterface $logger)
  {
    $this->config = $config;
    $this->logger = $logger;
  }

  /****************************************************************************/
  /* DEFINITIONS                                                              */
  /****************************************************************************/

  /**
   * @return array|TwigFilter[]
   */
  public function getFilters() : array {
    return [
      new TwigFilter('responsiveSVG', [$this, 'generateResponsiveSvg'], ['is_safe' => ['html']]),
      new TwigFilter('responsiveSourceSVG', [$this, 'generateResponsiveSourceSvg'], ['is_safe' => ['html']]),
    ];
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  /**
   * @param $file
   *
   * @return string
   */
  private function resolvePath($file) : string {
    if (isset($this->config['aliases'][$file]['path'])) {
      $path = $this->config['aliases'][$file]['path'];
      return $this->config['public_dir'].'/'.$path;
    }

    return $file;
  }

  /**
   * @param $file
   *
   * @return string
   */
  private function resolveUrl($file) : string {
    if (isset($this->config['aliases'][$file]['path'])) {
      return '/'.$this->config['aliases'][$file]['path'];
    }

    return $file;
  }

  /**
   * @param $path
   *
   * @return string|null
   */
  private function loadContent($path) : ?string {
    return file_get_contents($path) ?: NULL;
  }

  /**
   * @param $uri
   *
   * @return string
   */
  public function generateResponsiveSourceSvg($uri) : string {
    $pathResolved = $this->resolvePath($uri);
    $svgContent = $this->loadContent($pathResolved);

    $searchReplace = [
      '<?xml version="1.0" encoding="utf-8"?>' => '',
      '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' => '',
      '<svg ' => '<svg style="display:none;" ',
    ];

    return str_replace(array_keys($searchReplace), array_values($searchReplace), $svgContent);
  }

  /**
   * @param $uri
   * @param array $config
   *
   * @return string
   */
  public function generateResponsiveSvg($uri, array $config = []) : string {
    $default = [
      'offsetX' => 0,
      'offsetY' => 0,
      'class' => ''
    ];

    $config = array_merge($default, $config);

    list($file, $identifier) = explode('#', $uri);

    $pathResolved = $this->resolvePath($file);
    $urlResolved = $this->resolveUrl($file);

    $href = $urlResolved;
    if ($this->config['inline']) {
      $href = '';
    }
    if ($identifier !== '') {
      $href .= '#' . $identifier;
    }

    // Parse svg file and read viewBox attribute.
    $svg = $this->loadContent($pathResolved);
    if ($svg === false) {
      $this->logger->debug('Cannot find svg ' . $uri);
      return '';
    }

    $crawler = new Crawler($svg);

    $item = $crawler;
    if ($identifier !== '') {
      $item = $crawler->filter('#' . $identifier);
    }

    if (!$item->count()) {
      $this->logger->debug('Cannot find svg element for ' . $uri);
      return '';
    }

    $viewBox = $item->attr('viewBox');

    if ($viewBox === '') {
      $this->logger->debug('Cannot find viewBox attribute in ' . $uri);
      return '';
    }

    // Build markup
    list(, , $width, $height) = explode(' ', $viewBox);

    $width += $config['offsetX'];
    $height += $config['offsetY'];

    if (isset($config['width'])) {
      $width = $config['width'];
    }

    if (isset($config['height'])) {
      $height = $config['height'];
    }

    $classes = array_merge(['responsive-svg'], explode(' ', $config['class']));

    $dom = new \DOMDocument();

    $wrapper = $dom->createElement('div');
    $wrapper->setAttribute('class', implode(' ', $classes));
    $wrapper->setAttribute('style', $this->config['styles']['wrapper']);

    $filler = $dom->createElement('div');
    $filler->setAttribute('style', $this->config['styles']['filler'].' padding-bottom: ' . number_format($height / $width * 100, 5) . '%');
    $wrapper->appendChild($filler);

    if ($identifier !== '') {
      $svg = $dom->createElement('svg');
      $svg->setAttribute('viewBox', '0 0 ' . number_format($width, 5) . ' ' . number_format($height, 5));

      $use = $dom->createElement('use');
      $use->setAttribute('xlink:href', $href);
      $svg->appendChild($use);
    } else {
      $svg = $dom->createElement('object');
      $svg->setAttribute('type', 'image/svg+xml');
      $svg->setAttribute('data', $href);
    }

    $svg->setAttribute('style', $this->config['styles']['svg']);

    $wrapper->appendChild($svg);
    $dom->appendChild($wrapper);

    return $dom->saveHTML();
  }

}
