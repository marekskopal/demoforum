<?php

namespace App\Forms\Renderer;

/**
 * Bootstrap form renderer
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BootstrapRenderer extends \Tomaj\Form\Renderer\BootstrapRenderer
{

    /** @var array */
    public $wrappers = [
        'form' => [
            'container' => null
        ],
        'error' => [
            'container' => 'div class="alert alert-danger"',
            'item' => 'p'
        ],
        'group' => [
            'container' => 'fieldset',
            'label' => 'legend',
            'description' => 'p'
        ],
        'controls' => [
            'container' => 'div'
        ],
        'pair' => [
            'container' => 'div class=form-group',
            '.required' => 'required',
            '.optional' => null,
            '.odd' => null,
            '.error' => 'has-error'
        ],
        'control' => [
            'container' => null,
            '.odd' => null,
            'description' => 'span class=help-block',
            'requiredsuffix' => '',
            'errorcontainer' => 'span class=help-block',
            'erroritem' => '',
            '.required' => 'required',
            '.text' => 'text',
            '.password' => 'text',
            '.file' => 'text',
            '.submit' => 'button',
            '.image' => 'imagebutton',
            '.button' => 'button'
        ],
        'label' => [
            'container' => null,
            'suffix' => null,
            'requiredsuffix' => '',
        ],
        'hidden' => [
            'container' => 'div'
        ]
    ];

}
