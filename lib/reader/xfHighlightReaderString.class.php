<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A reader for simple strings.
 *
 * @package sfHighight
 * @subpackage Reader
 * @author Carl Vondrick
 */
final class xfHighlightReaderString implements xfHighlightReader
{
  /**
   * The current state
   *
   * @var int
   */
  private $state = 0;

  /**
   * The text
   *
   * @var string
   */
  private $text;

  /**
   * Constructor to set initial text.
   *
   * @param string $text
   */
  public function __construct($text)
  {
    $this->text = $text;
  }

  /**
   * @see xfHighlightReader
   */
  public function next()
  {
    if ($this->state == 0)
    {
      $this->state++;

      return $this->text;
    }
    
    return null;
  }

  /**
   * @see xfHighlightReader
   */
  public function rewind()
  {
    $this->state = 0;
  }

  /**
   * @see xfHighlightReader
   */
  public function replaceText(xfTokenInterface $token, $new)
  {
    $newText  = substr($this->text, 0, $token->getStart());
    $newText .= $new;
    $newText .= substr($this->text, $token->getEnd());

    $this->text = $newText;
  }

  /**
   * Returns the text
   *
   * @returns string
   */
  public function getString()
  {
    return $this->text;
  }
}
