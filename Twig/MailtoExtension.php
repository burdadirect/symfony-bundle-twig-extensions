<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MailtoExtension extends AbstractExtension {

  /****************************************************************************/
  /* DEFINITIONS                                                              */
  /****************************************************************************/

  public function getFilters() : array {
    return [
      new TwigFilter('mailto', [$this, 'mailtoFilter']),
    ];
  }

  public function getFunctions() : array {
    return [
      new TwigFunction('mailto', [$this, 'mailtoFunction']),
    ];
  }

  /****************************************************************************/
  /* HELPER                                                                   */
  /****************************************************************************/

  private function mailtoEncode(string $var): string {
    return str_replace("\n", '%0D%0A', rawurlencode($var));
  }

  /****************************************************************************/
  /* FILTER                                                                   */
  /****************************************************************************/

  public function mailtoFilter(string $var): string {
    return $this->mailtoEncode($var);
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  public function mailtoFunction(string $emailAddress, ?string $subject, ?string $body): string {
    $string = 'mailto:'.$emailAddress;
    $parts = [];

    if ($subject) {
      $parts[] = 'subject='.$this->mailtoEncode($subject);
    }

    if ($subject) {
      $parts[] = 'body='.$this->mailtoEncode($body);
    }

    if (count($parts) > 0) {
      $string .= '?';
    }
    $string .= implode('&', $parts);

    return $string;
  }

}
