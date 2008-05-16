<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'document/xfDocument.class.php';
require 'result/xfDocumentHit.class.php';
require 'mock/criteria/xfMockCriterionImplementer.class.php';
require 'result/xfRetort.interface.php';
require 'result/xfRetortFilterCallback.interface.php';
require 'util/xfTokenInterface.interface.php';
require 'util/xfToken.class.php';

require 'highlight/xfHighlighter.class.php';
require 'highlight/xfHighlightKeyword.class.php';
require 'highlight/xfHighlightToken.class.php';
require 'tokenizer/xfHighlightTokenizer.interface.php';
require 'marker/xfHighlightMarker.interface.php';
require 'marker/xfHighlightMarkerUppercase.class.php';
require 'reader/xfHighlightReader.interface.php';
require 'reader/xfHighlightReaderString.class.php';

require 'search/xfHighlightTokenizerCriterionImplementer.class.php';
require 'search/xfHighlightRetortFilterCallback.class.php';

$t = new lime_test(2, new lime_output_color);

$ci = new xfMockCriterionImplementer;
$ci->tokens = array(new xfToken('foobar', 5, 11));

$hit = new xfDocumentHit(new xfDocument('guid'), $ci);
$retort = new xfHighlightRetortFilterCallback(new xfHighlightMarkerUppercase);

$t->is($retort->filter('I am foobar and I am king', $hit, 'getFoobar'), 'I am FOOBAR and I am king', '->filter() highlights the string');
$t->is($retort->filter('I am foobar and I am king', $hit, 'getFoobar', array(xfHighlightRetortFilterCallback::SKIP)), 'I am foobar and I am king', '->filter() skips highlighting if correct parameter is passed');
