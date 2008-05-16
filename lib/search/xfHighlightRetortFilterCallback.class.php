<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A retort filter for the highlighter.
 *
 * Depends on sfSearch
 *
 * @package sfHighlight
 * @subpackage Search
 * @author Carl Vondrick
 */
final class xfHighlightRetortFilterCallback implements xfRetortFilterCallback
{
  /**
   * If flag is present in arguments, then the response is not highlighted.
   */
  const SKIP = 'skip-highlighting';

  /**
   * The marker used
   *
   * @var xfHighlightMarker
   */
  private $marker;

  /**
   * Constructor to set marker
   *
   * @param xfHighlightMarker $marker
   */
  public function __construct(xfHighlightMarker $marker)
  {
    $this->marker = $marker;
  }

  /**
   * @see xfRetortFilterCallback
   */
  public function filter($response, xfDocumentHit $doc, $method, array $args = array())
  {
    if (!in_array(self::SKIP, $args))
    {
      $keyword = new xfHighlightKeyword(new xfHighlightTokenizerCriterionImplementer($doc->getCriterionImplementer()), $this->marker);

      $h = new xfHighlighter;
      $h->addKeyword($keyword);

      $response = $h->highlight(new xfHighlightReaderString($response))->getText();
    }

    return $response;
  }
}
