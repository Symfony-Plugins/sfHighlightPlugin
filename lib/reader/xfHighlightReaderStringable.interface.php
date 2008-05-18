<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Interface for a reader that takes and returns a string
 *
 * @package sfHighlight
 * @subpackage Reader
 * @author Carl Vondrick
 */
interface xfHighlightReaderStringable
{
  /**
   * Gets the string
   *
   * @returns string
   */
  public function getString();
}
