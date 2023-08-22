<?php
/**
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */


function auxnew_get_template_part( $slug, $name = '' ) {
    auxin_get_template_part( $slug, $name, AUXNEW()->template_path() );
}