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
require 'marker/xfHighlightMarkerUppercase.class.php';
require 'util/xfHighlightException.class.php';

$t = new lime_test(1, new lime_output_color);

$marker = new xfHighlightMarkerUppercase;
$t->is($marker->markup('fooBar'), 'FOOBAR', '->markup() makes text uppercase');
