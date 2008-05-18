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
   * @var DOMNode
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
   * Callbacks to determine if the node should be ignored
   *
   * @var array
   */
  private $ignoreCallbacks = array();

  /**
   * The current position in the text array
   *
   * @var int
   */
  private $position;

  /**
   * Boolean to indicate if reader has been initialized
   *
   * @var bool
   */
  private $initialized = false;

  /**
   * Constructor to set the DOMNode
   *
   * @param DOMNode $document
   */
  public function __construct(DOMNode $document)
  {
    $this->document = clone $document;
  }

  /**
   * Initializes the reader
   */
  public function initialize()
  {
    if (!$this->initialized)
    {
      $this->buildTexts($this->document);

      $this->initialized = true;
    }
  }

  /**
   * Adds an ignore callback
   *
   * @param callable $callback
   */
  public function registerIgnoreCallback($callback)
  {
    $this->ignoreCallbacks[] = $callback;
  }

  /**
   * Gets the original document
   *
   * @returns DOMNode
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

    // stop building this node if callback returns true
    foreach ($this->ignoreCallbacks as $callback)
    {
      if (call_user_func($callback, $node) === true)
      {
        return;
      }
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
    $this->initialize();

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

    $response = $this->texts[$this->position]->textContent;

    if (trim($response) == '')
    {
      return $this->next();
    }

    return $response;
  }
}
