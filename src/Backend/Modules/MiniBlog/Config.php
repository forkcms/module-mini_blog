<?php
namespace Backend\Modules\MiniBlog;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * This action will add a post to the blog module.
 *
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */
final class Config extends BackendBaseConfig
{
    /**
     * The default action.
     *
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * The disabled actions.
     *
     * @var array
     */
    protected $disabledActions = array();
}
