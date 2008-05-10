<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'marker/xfHighlightMarker.interface.php';
require 'marker/xfHighlightMarkerSprint.class.php';
require 'util/xfHighlightException.class.php';

$t = new lime_test(2, new lime_output_color);

$marker = new xfHighlightMarkerSprint('[%s]');
$t->is($marker->markup('foobar'), '[foobar]', '->markup() marks up according to the pattern');

try {
  $msg = '->__construct() fails if pattern is missing %s';
  new xfHighlightMarkerSprint('foobar');
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

