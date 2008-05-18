<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'request/sfRequest.class.php';
require 'request/sfWebRequest.class.php';
require 'response/sfResponse.class.php';
require 'response/sfWebResponse.class.php';
require 'view/sfView.class.php';
require 'controller/sfController.class.php';
require 'controller/sfWebController.class.php';
require 'controller/sfFrontWebController.class.php';
require 'storage/sfStorage.class.php';
require 'storage/sfSessionStorage.class.php';
require 'storage/sfSessionTestStorage.class.php';
require 'config/sfConfig.class.php';
require 'util/sfToolkit.class.php';
require 'util/sfParameterHolder.class.php';
require 'debug/sfTimer.class.php';
require 'debug/sfTimerManager.class.php';
require 'filter/sfFilter.class.php';
require 'filter/sfFilterChain.class.php';
require 'event/sfEventDispatcher.class.php';
require 'event/sfEvent.class.php';
require 'log/sfLogger.class.php';

require 'util/xfHighlightFilter.class.php';
require 'util/xfHighlightException.class.php';
require 'highlight/xfHighlighter.class.php';
require 'highlight/xfHighlightKeyword.class.php';
require 'highlight/xfHighlightToken.class.php';
require 'tokenizer/xfHighlightTokenizer.interface.php';
require 'tokenizer/xfHighlightTokenizerSimple.class.php';
require 'marker/xfHighlightMarker.interface.php';
require 'marker/xfHighlightMarkerSprint.class.php';
require 'reader/xfHighlightReaderInterface.interface.php';
require 'reader/xfHighlightReaderAggregate.interface.php';
require 'reader/xfHighlightReader.interface.php';
require 'reader/xfHighlightReaderStringable.interface.php';
require 'reader/xfHighlightReaderDOM.class.php';
require 'reader/xfHighlightReaderXML.class.php';
require 'reader/xfHighlightReaderXHTML.class.php';

require SF_LIB_DIR . '/../test/unit/sfContextMock.class.php';

$t = new lime_test(9, new lime_output_color);

$context = sfContext::getInstance();
$context->inject('request', 'sfWebRequest');
$context->inject('response', 'sfWebResponse');
$context->inject('controller', 'sfFrontWebController');

$response = $context->getResponse();
$request = $context->getRequest();
$controller = $context->getController();

$chain = new sfFilterChain();

$filter = new xfHighlightFilter($context, array(
  'querystring' => 'h',
  'markers' => array('[%s]', '{%s}', '(%s)')
));

$content = '<html><body>foobar</body></html>';
$response->setContent($content);
$filter->execute($chain);
$t->is($response->getContent(), $content, '->filter() does not highlight if no querystring is present');

$request->setParameter('h', 'foobar');
$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
$filter->execute($chain);
$t->is($response->getContent(), $content, '->filter() does not highlight on ajax requests');
$_SERVER['HTTP_X_REQUESTED_WITH'] = null;

$response->setHeaderOnly(true);
$filter->execute($chain);
$t->is($response->getContent(), $content, '->filter() does not highlight for header only responses');
$response->setHeaderOnly(false);

$response->setContentType('image/jpeg');
$filter->execute($chain);
$t->is($response->getContent(), $content, '->filter() does not highlight for non HTML content');
$response->setContentType('text/html');

$response->setStatusCode(304);
$filter->execute($chain);
$t->is($response->getContent(), $content, '->filter() does not highight for HTTP 304');
$response->setStatusCode(200);

$controller->setRenderMode(sfView::RENDER_NONE);
$filter->execute($chain);
$t->is($response->getContent(), $content, '->filter() does not highlight for RENDER_NONE');
$controller->setRenderMode(sfView::RENDER_CLIENT);

$filter->execute($chain);
$t->is($response->getContent(), "<?xml version=\"1.0\"?>\n<html><body>[foobar]</body></html>\n", '->filter() highlights content if criteria is met');

$response->setContent('malformed');
$context->getEventDispatcher()->connect('application.log', create_function('', '$GLOBALS["t"]->pass("->filter() notifies dispatcher");'));
$filter->execute($chain);

sfConfig::set('sf_debug', true);
class SlowResponse extends sfWebResponse
{
  public function getContent()
  {
    sleep(1);

    return '<html><body>foo</body></html>';
  }
  public function setContent($content)
  {
  }
}
$context->inject('response', 'SlowResponse');
$filter->execute($chain);
