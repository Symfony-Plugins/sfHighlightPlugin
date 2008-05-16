<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'highlight/xfHighlighter.class.php';
require 'highlight/xfHighlightKeyword.class.php';
require 'highlight/xfHighlightToken.class.php';
require 'tokenizer/xfHighlightTokenizer.interface.php';
require 'tokenizer/xfHighlightTokenizerSimple.class.php';
require 'marker/xfHighlightMarker.interface.php';
require 'marker/xfHighlightMarkerUppercase.class.php';
require 'marker/xfHighlightMarkerSprint.class.php';
require 'reader/xfHighlightReader.interface.php';
require 'reader/xfHighlightReaderString.class.php';

$t = new lime_test(3, new lime_output_color);

$keywords = array(
  new xfHighlightKeyword(new xfHighlightTokenizerSimple(array('foo', 'bar')), new xfHighlightMarkerUppercase),
  new xfHighlightKeyword(new xfHighlightTokenizerSimple(array('baz')), new xfHighlightMarkerSprint('[%s]'))
);

$reader = new xfHighlightReaderString('foo is better than bar if only because of the small amount of baz');

$h = new xfHighlighter($keywords);
$reader = $h->highlight($reader);

$t->isa_ok($reader, 'xfHighlightReaderString', '->highlight() returns a xfHighlightReader');
$t->is($reader->getText(), 'FOO is better than BAR if only because of the small amount of [baz]', '->highlight() highlights the string according to the reader and keywords');

$t->is($h->highlight(new xfHighlightReaderString('baz! bow before baz for i am baz'))->getText(), '[baz]! bow before [baz] for i am [baz]', '->highlight() works with changing string length');
