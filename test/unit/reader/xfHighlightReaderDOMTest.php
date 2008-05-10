<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'reader/xfHighlightReader.interface.php';
require 'reader/xfHighlightReaderDOM.class.php';
require 'highlight/xfHighlightToken.class.php';

$t = new lime_test(9, new lime_output_color);

function getFullText($reader)
{
  do
  {
    $text = trim($reader->next());
  } while ($text === '');

  return $text;
}

$xml = <<<XML
<root>
  <!-- this is a comment. he likes pie too -->
  <parent>
    <child>I love pie</child>
    <child>Hmmm... pie!</child>
  </parent>
  <parent class="pie">
    Pipe down children!
    <child>Pie is yummy.</child>
    Pie is bad for you!
  </parent>
</root>
XML;

$domdoc = new DOMDocument;
$domdoc->loadXml($xml);

$reader = new xfHighlightReaderDOM($domdoc);

$t->ok($reader->getDocument() == $domdoc && $reader->getDocument() !== $domdoc, '->__construct() clones the DOMDocument');

$expected = array(
  'I love pie',
  'Hmmm... pie!',
  'Pipe down children!',
  'Pie is yummy.',
  'Pie is bad for you!',
);

foreach ($expected as $phrase)
{
  $t->is(getFullText($reader), $phrase, '->next() returns node "' . $phrase . '"');
}

$reader->next();
$t->is($reader->next(), null, '->next() returns "null" at the end');

$reader->rewind();
$t->is(getFullText($reader), 'I love pie', '->rewind() starts the iterator over');

$reader->replaceText(new xfHighlightToken('love', 2, 6), 'hate');

$text = $reader->getDocument()->saveXml();
$expected = <<<XML
<?xml version="1.0"?>
<root>
  <!-- this is a comment. he likes pie too -->
  <parent>
    <child>I hate pie</child>
    <child>Hmmm... pie!</child>
  </parent>
  <parent class="pie">
    Pipe down children!
    <child>Pie is yummy.</child>
    Pie is bad for you!
  </parent>
</root>

XML;

$t->is($text, $expected, '->replaceText() replaces the text in the correct node');
