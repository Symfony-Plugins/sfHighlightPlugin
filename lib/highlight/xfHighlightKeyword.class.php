<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A keyword connects a tokenizer to a marker.
 *
 * @package sfHighlight
 * @subpackage Highlight
 * @author Carl Vondrick
 */
final class xfHighlightKeyword 
{
  /**
   * The tokenizer.
   *
   * @var xfHighlightTokenizer
   */
  private $tokenizer;

  /**
   * The marker.
   *
   * @var xfHighlightMarker
   */
  private $marker;

  /**
   * Constructor to set initial tokenizer and marker.
   *
   * @param xfHighlightTokenizer $tokenizer
   * @param xfHighlightMarker $marker
   */
  public function __construct(xfHighlightTokenizer $tokenizer, xfHighlightMarker $marker)
  {
    $this->tokenizer = $tokenizer;
    $this->marker = $marker;
  }

  /** 
   * Gets the tokenizer.
   *
   * @returns xfHighlightTokenizer
   */
  public function getTokenizer()
  {
    return $this->tokenizer;
  }

  /**
   * Gets the marker.
   *
   * @returns xfHighlightMarker
   */
  public function getMarker()
  {
    return $this->marker;
  }
}
