<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// create an xfTokenInterface if unavailable from sfSearch
// this is neccessary to remove the dependency on sfSearch
if (!interface_exists('xfTokenInterface', true))
{
  /**
   * Token interface to achieve duck typing
   *
   * @package sfHighlight
   * @subpackage Highlight
   * @author Carl Vondrick
   * @see sfSearch's xfTokenInterface
   */
  interface xfTokenInterface
  {
  }
}

/**
 * The highlight token.
 *
 * @package sfHighlight
 * @subpackage Highlight
 * @author Carl Vondrick
 */
final class xfHighlightToken implements xfTokenInterface
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
   * @param xfTokenInterface $a
   * @param xfTokenInterface $b
   * @returns int The sort code for usort
   */
  static public function getSortCode(xfTokenInterface $a, xfTokenInterface $b)
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
