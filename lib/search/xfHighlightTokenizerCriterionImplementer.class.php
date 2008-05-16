<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A simple tokenizer that reads from the criterion implementer.
 *
 * Depends on sfSearch
 *
 * @package sfHighlight
 * @subpackage Tokenizer
 * @author Carl Vondrick
 */
final class xfHighlightTokenizerCriterionImplementer implements xfHighlightTokenizer
{
  /**
   * The criterion implementer
   *
   * @var xfCriterionImplementer
   */
  private $implementer;

  /**
   * Constructor to set criterion implementer
   *
   * @param xfCriterionImplementer $implementer
   */
  public function __construct(xfCriterionImplementer $implementer)
  {
    $this->implementer = $implementer;
  }

  /**
   * @see xfHighlightTokenizer
   */
  public function tokenize($text)
  {
    return $this->implementer->tokenize($text);
  }
}
