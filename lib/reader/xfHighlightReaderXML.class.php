<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A reader to extract text from a XML string
 *
 * @package sfHighlight
 * @subpackage Reader
 * @author Carl Vondrick
 */
final class xfHighlightReaderXML implements xfHighlightReaderAggregate, xfHighlightReaderStringable
{
  /**
   * The DOM reader
   *
   * @var xfHighlightReaderDOM
   */
  private $reader;

  /**
   * Constructor to set the string
   *
   * @param string $xml The xml string
   * @param string $version The xml version
   * @param string $encoding the xml encoding
   * @param int $options DOMDocument options
   */
  public function __construct($xml, $version = null, $encoding = null, $options = 0)
  {
    $dom = new DOMDocument($version, $encoding);
    $dom->resolveExternals = true;
    $dom->substitueEntities = false;

    libxml_clear_errors();
    $oldXmlError = libxml_use_internal_errors(true);

    if (!$dom->loadXml($xml, $options))
    {
      $errors = libxml_get_errors();

      libxml_clear_errors();
      libxml_use_internal_errors($oldXmlError);

      $msg = 'XML document failed to parse correctly: ';

      foreach ($errors as $error)
      {
        $msg .= '[' . trim($error->message) . '], ';
      }

      $msg = substr($msg, 0, -2);

      throw new xfHighlightException($msg);
    }

    libxml_clear_errors();
    libxml_use_internal_errors($oldXmlError);

    $this->reader = new xfHighlightReaderDOM($dom);
  }

  /**
   * @see xfHighlightReaderStringable
   */
  public function getString()
  {
    return $this->reader->getDocument()->saveXML();
  }

  /**
   * @see xfHighlightReaderAggregate
   */
  public function getReader()
  {
    return $this->reader;
  }
}
