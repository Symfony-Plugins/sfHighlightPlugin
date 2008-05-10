<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A marker that uses sprintf() to calculate the highlighted result.
 *
 * @package sfHighlight
 * @subpackage Marker
 * @author Carl Vondrick
 */
final class xfHighlightMarkerSprint implements xfHighlightMarker
{
  /**
   * The pattern
   *
   * @var string
   */
  private $pattern;

  /**
   * Constructor to set pattern.
   *
   * @param string $pattern
   */
  public function __construct($pattern)
  {
    if (false === strpos($pattern, '%s'))
    {
      throw new xfHighlightException('Pattern must contain an %s');
    }

    $this->pattern = $pattern;
  }

  /**
   * Calculates the result.
   *
   * @param string $text
   * @returns string
   */
  public function markup($text)
  {
    return sprintf($this->pattern, $text);
  }
}
