<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A reader goes through content and extracts data for it to be later changed.
 *
 * @package sfHighlight
 * @subpackage Reader
 * @author Carl Vondrick
 */
interface xfHighlightReader
{
  /**
   * Advances the pointer.
   *
   * @returns string|null string if the next part of the text, null if done
   */
  public function next();

  /**
   * Rewinds the pointer
   */
  public function rewind();

  /**
   * Replaces a token with the new text in the correct text.
   *
   * @param xfHighlightToken $token
   * @param string $new
   */
  public function replaceText(xfHighlightToken $token, $new);
}

