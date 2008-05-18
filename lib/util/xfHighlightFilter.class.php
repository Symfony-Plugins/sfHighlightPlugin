<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A filter for the symfony filter chain that highlights responses.
 *
 * @package sfHighlight
 * @subpackage Utilities
 * @author Carl Vondrick
 */
class xfHighlightFilter extends sfFilter
{
  /**
   * @see sfFilter
   */
  public function initialize($context, $parameters = array())
  {
    $this->context = $context;

    $this->parameterHolder = new sfParameterHolder();
    $this->parameterHolder->add(array(
      'querystring'           => 'sf_highlight',
      'markers'               => array('<strong style="background-color:#ffff66">%s</strong>',
                                       '<strong style="background-color:#a0ffff">%s</strong>',
                                       '<strong style="background-color:#99ff99">%s</strong>',
                                       '<strong style="background-color:#ff9999">%s</strong>',
                                       '<strong style="background-color:#ff66ff">%s</strong>')
    ));
    $this->parameterHolder->add($parameters);

    return true;
  }

  /**
   * @see sfFilter
   */
  public function execute($chain)
  {
    $chain->execute();

    if ($this->shouldHighlight())
    {
      $timer = sfTimerManager::getTimer('sfHighlight Filter');
      
      try
      {
        $this->highlight();
      }
      catch (xfHighlightException $e)
      {
        $this->getContext()->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array($e->getMessage(), 'priority' => sfLogger::ERR)));
      }
      catch (Exception $e)
      {
        $timer->addTime();

        throw $e;
      }

      $timer->addTime();
    }
  }

  /**
   * Tests to see if request should be highlighted
   *
   * @returns bool true if should be highlighted, false otherwise
   */
  protected function shouldHighlight()
  {
    $response   = $this->getContext()->getResponse();
    $request    = $this->getContext()->getRequest();
    $controller = $this->getContext()->getController();

    return !($request->getParameter($this->getParameter('querystring'), null) == null   ||
             $request->isXmlHttpRequest()                                               ||
             strpos($response->getContentType(), 'html') === false                      ||
             $response->getStatusCode() == 304                                          ||
             $controller->getRenderMode() != sfView::RENDER_CLIENT                      ||
             $response->isHeaderOnly());
  }

  /**
   * Highlights the response
   *
   * @returns bool true if response was highlighted, false otherwise
   */
  private function highlight()
  {
    $highlighted = false;

    if ($keywords = $this->getKeywords())
    {
      $timer = sfTimerManager::getTimer('sfHighlight Filter Reader');
      $reader = $this->getReader($this->getContext()->getResponse()->getContent());
      $timer->addTime();

      if (sfConfig::get('sf_debug') && $timer->getElapsedTime() > 1)
      {
        $this->getContext()->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array('Consider caching your DTD in the XML catalog to speed up highlighting.', 'priority' => sfLogger::NOTICE)));
      }

      $timer = sfTimerManager::getTimer('sfHighlight Filter Highlighter');
      $highlighter = new xfHighlighter;
      $highlighter->addKeywords($keywords);
      $highlighter->highlight($reader);
      $timer->addTime();

      $this->getContext()->getResponse()->setContent($reader->getString());

      $highlighted = true;
    }

    return $highlighted;
  }

  /**
   * Gets the keywords
   *
   * @returns array
   */
  protected function getKeywords()
  {
    $keywords = array();
    $terms = $this->getTerms();
    $markers = $this->getMarkers();
    $numMarkers = count($markers);
  
    foreach ($terms as $number => $term)
    {
      $marker = $markers[$number % $numMarkers];
      $tokenizer = new xfHighlightTokenizerSimple(array($term));

      $keywords[] = new xfHighlightKeyword($tokenizer, $marker);
    }

    return $keywords;
  }

  /**
   * Gets the terms
   *
   * @returns array
   */
  protected function getTerms()
  {
    $terms = $this->getContext()->getRequest()->getParameter($this->getParameter('querystring'));

    return preg_split('/[\p{Z}\p{P}]+/u', $terms);
  }

  /**
   * Gets the markers
   *
   * @returns array
   */
  protected function getMarkers()
  {
    $markers = array();

    foreach ($this->getParameter('markers') as $sprint)
    {
      $markers[] = new xfHighlightMarkerSprint($sprint);
    }

    return $markers;
  }

  /**
   * Gets the reader
   *
   * @param string $content The content HTML
   * @returns xfHighlightReaderStringable & xfHighlightReaderInterface
   */
  protected function getReader($content)
  {
    return new xfHighlightReaderXHTML($content);
  }
}
