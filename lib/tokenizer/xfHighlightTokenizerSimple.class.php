<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A tokenizer that simply splits by spaces.
 *
 * @package sfHighlight
 * @subpackage Tokenizer
 * @author Carl Vondrick
 */
final class xfHighlightTokenizerSimple implements xfHighlightTokenizer
{
  /**
   * The regular expression used to split
   *
   * @var string
   */
  private $regex = '/\W+/'; // /[^a-zA-Z0-9]+/

  /**
   * The matches to look for
   *
   * @var array
   */
  private $matches = array();

  /**
   * If true, tokenizer is case sensitive. 
   *
   * @var bool
   */
  private $caseSensitive = false;

  /**
   * Constructor to set initial matches
   *
   * @param array $matches strings to match
   */
  public function __construct(array $matches = array())
  {
    $this->addMatches($matches);
  }

  /**
   * Changes the regular expression
   *
   * @param string $regex The regex
   */
  public function setRegularExpression($regex)
  {
    $this->regex = $regex;
  }

  /**
   * Adds matches to look for
   *
   * @param array $matches of strings to match
   */
  public function addMatches(array $matches)
  {
    $this->matches = array_merge($this->matches, $matches);
  }

  /**
   * Makes the tokenizer case sensitive
   */
  public function setCaseSensitive()
  {
    $this->caseSensitive = true;
  }

  /**
   * Makes the tokenizer case insensitive
   */
  public function setCaseInsensitive()
  {
    $this->caseSensitive = false;
  }

  /**
   * @see xfHighlightTokenizer
   */
  public function tokenize($text)
  {
    $tokens = array();

    foreach (preg_split($this->regex, $text, -1, PREG_SPLIT_OFFSET_CAPTURE) as $tokenData)
    {
      if ($this->isTokenValid($token = $tokenData[0]))
      {
        $start = $tokenData[1];
        $end = $start + strlen($token);

        $tokens[] = new xfHighlightToken($token, $start, $end);
      }
    }

    return $tokens;
  }

  /**
   * Compares two texts to see if they match
   *
   * @param string $text The string to test if it matches
   * @returns bool true if they match, false otherwise
   */
  private function isTokenValid($token)
  {
    if (!$this->caseSensitive)
    {
      $token = strtolower($token);
    }

    foreach ($this->matches as $match)
    {
      if (!$this->caseSensitive)
      {
        $match = strtolower($match);
      }

      if ($token == $match)
      {
        return true;
      }
    }

    return false;
  }
}
