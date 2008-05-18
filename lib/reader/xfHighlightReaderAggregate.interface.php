<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Reader aggregate interface to indicate object holds a reader
 *
 * @package sfHighlight
 * @subpackage Reader
 * @author Carl Vondrick
 */
interface xfHighlightReaderAggregate extends xfHighlightReaderInterface
{
  /**
   * Gets the internal reader
   *
   * @returns xfHighlightReaderInterface
   */
  public function getReader();
}
