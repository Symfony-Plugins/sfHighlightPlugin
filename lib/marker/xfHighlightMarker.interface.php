<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The marker takes a string and highlights it.
 *
 * @package sfHighlight
 * @subpackage Marker
 * @author Carl Vondrick
 */
interface xfHighlightMarker
{
  /**
   * Marks up the text.
   *
   * @param string $text
   * @return string 
   */
  public function markup($text);
}
