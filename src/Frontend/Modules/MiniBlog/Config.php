<?php

namespace Frontend\Modules\MiniBlog;

use Frontend\Core\Engine\Base\Config as FrontendBaseConfig;

/**
 * This is the configuration-object
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */
final class Config extends FrontendBaseConfig
{
    /**
     * The default action
     *
     * @var    string
     */
    protected $defaultAction = 'index';


    /**
     * The disabled actions
     *
     * @var    array
     */
    protected $disabledActions = array();
}
