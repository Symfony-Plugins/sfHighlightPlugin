<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'reader/xfHighlightReaderInterface.interface.php';
require 'reader/xfHighlightReader.interface.php';
require 'reader/xfHighlightReaderString.class.php';
require 'highlight/xfHighlightToken.class.php';

$t = new lime_test(4, new lime_output_color);

$string = 'I am a walrus in the sky with diamonds.';

$reader = new xfHighlightReaderString($string);
$reader->rewind();
$t->is($reader->next(), $string, '->next() first returns the string');
$t->is($reader->next(), null, '->next() secondly returns null');
$reader->rewind();
$t->is($reader->next(), $string, '->rewind() resets ->next()');

$token = new xfHighlightToken('walrus', 7, 13);
$reader->replaceText($token, 'lucy');
$t->is($reader->getString(), 'I am a lucy in the sky with diamonds.', '->replaceText() does the replacement');
