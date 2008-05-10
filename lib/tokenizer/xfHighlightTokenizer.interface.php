<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The tokenizer creates tokens from text based off search criteria.
 *
 * @package sfHighlight
 * @subpackage Tokenizer
 * @author Carl Vondrick
 */
interface xfHighlightTokenizer
{
  /**
   * Tokenizes the text and returns an array of xfHighlightToken-s
   *
   * @param string $text The text to tokenize
   * @returns array of xfHighlightToken
   */
  public function tokenize($text);
}
