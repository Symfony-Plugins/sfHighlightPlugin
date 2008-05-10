<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A marker to make text uppercase.
 *
 * @package sfHighlight
 * @subpackage Marker
 * @author Carl Vondrick
 */
final class xfHighlightMarkerUppercase implements xfHighlightMarker
{
  /**
   * Makes the text uppercase.
   *
   * @param string $text
   * @returns string
   */
  public function markup($text)
  {
    return strtoupper($text);
  }
}
