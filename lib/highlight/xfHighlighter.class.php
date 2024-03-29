<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * xfHighlighter integrates keywords and readers to highlight a piece of text.
 *
 * @package xfHighlight
 * @subpackage Highlight
 * @author Carl Vondrick
 */
final class xfHighlighter
{
  /**
   * The keywords
   *
   * @var array
   */
  private $keywords = array();

  /**
   * Constructor to set initial keywords.
   *
   * @param array $keywords
   */
  public function __construct(array $keywords = array())
  {
    $this->addKeywords($keywords);
  }

  /**
   * Adds a keyword to be highlighted.
   *
   * @param xfHighlightKeyword $keyword
   */
  public function addKeyword(xfHighlightKeyword $keyword)
  {
    $this->keywords[] = $keyword;
  }

  /**
   * Adds a bunch of keywords
   *
   * @param xfHighlightKeyword $keywords
   */
  public function addKeywords(array $keywords)
  {
    foreach ($keywords as $keyword)
    {
      $this->addKeyword($keyword);
    }
  }
  
  /**
   * Does the highlighting on the reader.
   *
   * @param xfHighlightReaderInterface $inReader
   * @returns xfHighlightReaderInterface
   */
  public function highlight(xfHighlightReaderInterface $inReader)
  {
    $reader = $this->resolveReader($inReader);

    $reader->rewind();

    while($text = $reader->next())
    {
      foreach ($this->keywords as $keyword)
      {
        $marker = $keyword->getMarker();

        $tokens = $keyword->getTokenizer()->tokenize($text);
        usort($tokens, array('xfHighlightToken', 'getSortCode'));

        foreach ($tokens as $token)
        {
          $highlightedText = $marker->markup($token->getText());

          $reader->replaceText($token, $highlightedText);
        }
      }
    }

    return $inReader;
  }

  /**
   * Resolves the reader and its aggregates
   *
   * @param xfHighlightReaderInterface $reader
   * @returns xfHighlightReader
   */
  private function resolveReader(xfHighlightReaderInterface $reader)
  {
    if ($reader instanceof xfHighlightReaderAggregate)
    {
      $reader = $this->resolveReader($reader->getReader());
    }

    return $reader;
  }
}
