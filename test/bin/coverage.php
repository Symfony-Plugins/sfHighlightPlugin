<?php
/**
 * This file is part of the sfHighlight package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../bootstrap/unit.php';
require 'util/sfFinder.class.php';

$h = new lime_harness(new lime_output_color);
$h->base_dir = dirname(__FILE__) . '/../..';
$h->register(sfFinder::type('file')->name('xf*Test.php')->in(glob($h->base_dir . '/test/')));

$c = new lime_coverage($h);
$c->extension = '.php';
$c->verbose = true;
$c->base_dir = $h->base_dir . '/lib/';

$c->register(sfFinder::type('file')->name('*.class.php')->prune('vendor')->in($c->base_dir));
$c->run();
