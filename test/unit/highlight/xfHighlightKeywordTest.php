<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'highlight/xfHighlightKeyword.class.php';
require 'tokenizer/xfHighlightTokenizer.interface.php';
require 'tokenizer/xfHighlightTokenizerSimple.class.php';
require 'marker/xfHighlightMarker.interface.php';
require 'marker/xfHighlightMarkerUppercase.class.php';

$t = new lime_test(2, new lime_output_color);

$tokenizer = new xfHighlightTokenizerSimple;
$marker = new xfHighlightMarkerUppercase;

$keyword = new xfHighlightKeyword($tokenizer, $marker);

$t->is($keyword->getTokenizer(), $tokenizer, '->getTokenizer() returns the tokenizer');
$t->is($keyword->getMarker(), $marker, '->getMarker() returns the marker');
