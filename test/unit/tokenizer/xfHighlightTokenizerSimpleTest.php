<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'tokenizer/xfHighlightTokenizer.interface.php';
require 'tokenizer/xfHighlightTokenizerSimple.class.php';
require 'highlight/xfHighlightToken.class.php';

$t = new lime_test(8, new lime_output_color);

$tokenizer = new xfHighlightTokenizerSimple(array('hello', 'you', 'awesome'));
$tokenizer->setCaseInsensitive();

$tokens = $tokenizer->tokenize('Hello, how are you?');

$t->is(count($tokens), 2, '->tokenize() returns the correct number of tokens');
$t->is($tokens[0]->getText(), 'Hello', '->tokenize() tokenizes a single token correctly');
$t->is($tokens[0]->getStart(), 0, '->tokenize() tokenizes a single token start position');
$t->is($tokens[0]->getEnd(), 5, '->tokenize() tokenizes a single token end position');
$t->is($tokens[1]->getText(), 'you', '->tokenize() tokenizes a second token correctly');

$tokenizer->setCaseSensitive();
$t->is(count($tokenizer->tokenize('Hello, I am awesome')), 1, '->tokenize() acknowledges case sensitive matching');

$tokenizer->setRegularExpression('/ /');
$tokens = $tokenizer->tokenize('hello awesome, how are you?');
$t->is(count($tokens), 1, '->setRegularExpression() changes the matching expression');
$t->is($tokens[0]->getText(), 'hello', '->setRegularExpression() changes the matching expression');
