<?php
/**
 * WAFFLE DESCRIPTION!
 *
 * @package     Controllers\Controller
 * @category    Controllers
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     $Id$
 */

namespace WAFFLE\Controller;

use WAFFLE\Controller;                                  # Primary: controller for index.php
use WAFFLE\Framework\Engines\Template;                  # Template: engine developed to substitute special WAFFLE tags while publishing a clean HTML document

require '/../lib/.framework/template.class.php';

# Set: root directories in array
$web['layout'] = rtrim(dirname(__FILE__), '/inc') . '/web/views/layout/';
$web['head']   = rtrim(dirname(__FILE__), '/inc') . '/web/views/head/';
$web['body']   = rtrim(dirname(__FILE__), '/inc') . '/web/views/body/';
$web['app']    = rtrim(dirname(__FILE__), '/inc') . '/web/views/';
$web['images'] = rtrim(dirname(__FILE__), '/inc') . '/web/images/';

// session_start();                                        # Session: start

# ------------------------------------ [ Header ] ------------------------------------ #

# Load: header views
$notes  = new Template($web['head'] . 'notes.wad');
$meta   = new Template($web['head'] . 'meta.wad');
$styles = new Template($web['head'] . 'style-sheets.wad');
$script = new Template($web['head'] . 'script.wad');

####################################################################
###                       Load Template(s)                       ###
####################################################################

# Load: layout
$layout = new Template($web['layout']  . 'html5.wad');

# Load: principle page elements
$header = new Template($web['body'] . 'header.wad');
$main   = new Template($web['body'] . 'main.wad');
$footer = new Template($web['body'] . 'footer.wad');

# Load: composite application template
$app    = new Template($web['app'] . 'app.wad');

# Load: project and/or application frame(s)
// Cycle through various projects applications

####################################################################
###                       Build Master Page                      ###
####################################################################

# Set: tags inside layout 'bootstrap'
$layout->set('file_notes',              $notes->output());
$layout->set('title',                   'Byrne-Systems | Developing Tools & Systems to Inspire Exploration & Discovery');
$layout->set('meta_tags',               $meta->output());
$layout->set('favicon',                 $header->favicon($web['images'] . 'fav/cube.fav'));
$layout->set('styles',                  $styles->output());
$layout->set('wrapper',                 'Byrne-Systems');

$layout->set('header',                  $header->output());
$layout->set('main',                    $main->output());
$layout->set('footer',                  $footer->output());

$layout->set('script',                  $script->output());

# Compile: all pre-parsed views into a single application view 'app.wad' to echo (or print) to users' screen; or stdout
$app->set('app',                            $layout->output());