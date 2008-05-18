<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A reader for an XHTML string
 *
 * @package sfHighlight
 * @subpackage Reader
 * @author Carl Vondrick
 */
final class xfHighlightReaderXHTML implements xfHighlightReaderAggregate, xfHighlightReaderStringable
{
  /**
   * The internal reader
   *
   * @var xfHighlightReaderXML
   */
  private $reader;

  /**
   * Constructor to set the XHTML string
   *
   * @param string $xml The xml string
   * @param string $version The xml version
   * @param string $encoding the xml encoding
   * @param int $options DOMDocument options
   */
  public function __construct($xml, $version = null, $encoding = null, $options = 0)
  {
    $this->reader = new xfHighlightReaderXML($xml, $version, $encoding, $options);

    $agg = $this->reader->getReader();
    $agg->registerIgnoreCallback(array(__CLASS__, 'isHeadElement'));
    $agg->registerIgnoreCallback(array(__CLASS__, 'isTextareaElement'));
    $agg->registerIgnoreCallback(array(__CLASS__, 'isScriptElement'));
    $agg->registerIgnoreCallback(array(__CLASS__, 'isStyleElement'));
  }

  /**
   * @see xfHighlightReaderStringable
   */
  public function getString()
  {
    return $this->reader->getString();
  }

  /**
   * @see xfHighlightReaderAggregate
   */
  public function getReader()
  {
    return $this->reader;
  }

  /**
   * Tests if element is a head element 
   *
   * @param DOMNode $node
   * @returns bool true if head, false otherwise
   */
  static public function isHeadElement(DOMNode $node)
  {
    return strtolower($node->nodeName) == 'head';
  }

  /**
   * Tests if element is a textarea element
   *
   * @param DOMNode $node
   * @returns bool true if textarea, false otherwise
   */
  static public function isTextareaElement(DOMNode $node)
  {
    return strtolower($node->nodeName) == 'textarea';
  }

  /**
   * Tests if element is a script element
   *
   * @param DOMNode $node
   * @returns bool true if script, false otherwise
   */
  static public function isScriptElement(DOMNode $node)
  {
    return strtolower($node->nodeName) == 'script';
  }

  /**
   * Tests if element is a style element
   *
   * @param DOMNode $node
   * @returns bool true if style element, false otherwise
   */
  static public function isStyleElement(DOMNode $node)
  {
    return strtolower($node->nodeName) == 'style';
  }
}
