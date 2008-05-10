<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'highlight/xfHighlightToken.class.php';

$t = new lime_test(7, new lime_output_color);

$token = new xfHighlightToken('lucy', 5, 9);

$t->is($token->getText(), 'lucy', '->getText() returns the text');
$t->is($token->getStart(), 5, '->getStart() returns the start');
$t->is($token->getEnd(), 9, '->getEnd() returns the end');
$t->is($token->getLength(), 4, '->getLength() returns the length');

$t1 = new xfHighlightToken('lucy', 5, 9);
$t2 = new xfHighlightToken('lucy', 6, 10);
$t3 = clone $t2;

$t->is(xfHighlightToken::getSortCode($t1, $t2), 1, '::getSortCode() puts the tokens at the end');
$t->is(xfHighlightToken::getSortCode($t2, $t1), -1, '::getSortCode() puts the tokens at the end');
$t->is(xfHighlightToken::getSortCode($t3, $t2), 0, '::getSortCode() puts the tokens at the end');
