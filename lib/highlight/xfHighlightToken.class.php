<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The highlight token.
 *
 * @package sfHighlight
 * @subpackage Highlight
 * @author Carl Vondrick
 */
final class xfHighlightToken
{
  /**
   * The text
   * 
   * @var string
   */
  private $text;

  /**
   * The start position
   *
   * @var int
   */
  private $start;

  /**
   * The end position
   *
   * @var int
   */
  private $end;

  /**
   * Constructor to set values
   *
   * @param string $text
   * @param int $start
   * @param int $end
   */
  public function __construct($text, $start, $end)
  {
    $this->text = $text;
    $this->start = $start;
    $this->end = $end;
  }

  /**
   * Gets the text
   *
   * @returns string
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * Gets the start position
   *
   * @returns int
   */
  public function getStart()
  {
    return $this->start;
  }

  /**
   * Gets the end position
   *
   * @returns int
   */
  public function getEnd()
  {
    return $this->end;
  }

  /**
   * Gets the length
   *
   * @returns int
   */
  public function getLength()
  {
    return $this->end - $this->start;
  }

  /**
   * System to sort the tokens
   *
   * @param xfHighlightToken $a
   * @param xfHighlightToken $b
   * @returns int The sort code for usort
   */
  static public function getSortCode(xfHighlightToken $a, xfHighlightToken $b)
  {
    if ($a->getStart() < $b->getStart())
    {
      return 1;
    }
    elseif ($a->getStart() > $b->getStart())
    {
      return -1;
    }
    
    return 0;
  }
}
