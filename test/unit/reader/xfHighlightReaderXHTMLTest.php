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
require 'reader/xfHighlightReaderAggregate.interface.php';
require 'reader/xfHighlightReaderStringable.interface.php';
require 'reader/xfHighlightReaderDOM.class.php';
require 'reader/xfHighlightReaderXML.class.php';
require 'reader/xfHighlightReaderXHTML.class.php';

$t = new lime_test(6, new lime_output_color);

$xhtml = '<?xml version="1.0"?>
<html>
  <head>
    <title>Foobar</title>
  </head>
  <body>
    How are you?
    <textarea>I am ok</textarea>
    Carl
    <script>baz</script>
    Fabien
    <style>yay</style>
    symfony
  </body>
</html>
';
$reader = new xfHighlightReaderXHTML($xhtml);

$t->isa_ok($reader->getReader(), 'xfHighlightReaderXML', '->getReader() returns an "xfHighlightReaderXML"');
$t->is($reader->getString(), $xhtml, '->getString() returns the XHTML');

$reader->getReader()->getReader()->rewind();

$t->is(trim($reader->getReader()->getReader()->next()), 'How are you?', 'reader ignores <head>');
$t->is(trim($reader->getReader()->getReader()->next()), 'Carl', 'reader ignores <textarea>');
$t->is(trim($reader->getReader()->getReader()->next()), 'Fabien', 'reader ignores <script>');
$t->is(trim($reader->getReader()->getReader()->next()), 'symfony', 'reader ignores <style>');
