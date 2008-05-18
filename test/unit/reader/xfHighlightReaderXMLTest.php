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
require 'util/xfHighlightException.class.php';

$t = new lime_test(3, new lime_output_color);

$xml = '<?xml version="1.0"?>
<root><parent><child>foobar</child></parent></root>
';
$reader = new xfHighlightReaderXML($xml);

$t->isa_ok($reader->getReader(), 'xfHighlightReaderDOM', '->getReader() returns an "xfHighlightReaderDOM"');
$t->is($reader->getString(), $xml, '->getString() returns the XML string');

try {
  $msg = '->__construct() fails if XML is invalid';
  new xfHighlightReaderXML('<foo><bar>');
  $t->fail($msg);
} catch (xfHighlightException $e) {
  $t->pass($msg);
}

