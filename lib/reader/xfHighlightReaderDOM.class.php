<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A reader to extract text from a DOM document
 *
 * @todo Look into lazy ->next() routine for possible performance boost
 * @subpackage sfHighlight
 * @subpackage Reader
 * @author Carl Vondrick
 */
final class xfHighlightReaderDOM implements xfHighlightReader
{
  /**
   * The document
   *
   * @var DOMDocument
   */
  private $document;

  /**
   * The array of text elements in this node
   *
   * @var array
   */
  private $texts = array();

  /**
   * The node types to ignore.
   *
   * @var array
   */
  private $ignore = array(
      XML_ATTRIBUTE_NODE,
      XML_ENTITY_REF_NODE,
      XML_ENTITY_NODE,
      XML_PI_NODE,
      XML_COMMENT_NODE,
      XML_DOCUMENT_TYPE_NODE,
      XML_DOCUMENT_FRAG_NODE,
      XML_NOTATION_NODE,
      );

  /**
   * The current position in the text array
   *
   * @var int
   */
  private $position;

  /**
   * Constructor to set the DOMNode
   *
   * @param DOMNode $document
   */
  public function __construct(DOMDocument $document)
  {
    $this->document = clone $document;

    $this->buildTexts($this->document);
  }

  /**
   * Gets the original document
   *
   * @returns DOMDocument
   */
  public function getDocument()
  {
    return $this->document;
  }

  /**
   * Builds the texts array
   *
   * @param DOMNode $node
   */
  private function buildTexts(DOMNode $node)
  {
    if (in_array($node->nodeType, $this->ignore))
    {
      return;
    }

    foreach ($node->childNodes as $child)
    {
      // we must start our texts list in beginning 
      if ($child->nodeType != XML_TEXT_NODE)
      {
        $this->buildTexts($child);
      }
      else
      {
        $this->texts[] = $child;
      }
    }
  }

  /**
   * @see xfHighlightReader
   */
  public function rewind()
  {
    $this->position = -1;
  }
  
  /**
   * @see xfHighlightReader
   */
  public function replaceText(xfTokenInterface $token, $replacement)
  {
    $node = $this->texts[$this->position];
    $node->splitText($token->getEnd());
    $matched = $node->splitText($token->getStart());
    
    $highnode = $this->document->createDocumentFragment();
    $highnode->appendXml($replacement);

    $node->parentNode->replaceChild($highnode, $matched);
  }

  /**
   * @see xfHighlightReader
   */
  public function next()
  {
    $this->position++;

    if (!isset($this->texts[$this->position]))
    {
      return null;
    }

    return $this->texts[$this->position]->textContent;
  }
}
