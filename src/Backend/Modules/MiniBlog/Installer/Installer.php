<?php
namespace Backend\Modules\MiniBlog\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * This action will install the mini blog module.
 *
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        $this->importSQL(dirname(__FILE__) . '/Data/install.sql');

        $this->addModule('MiniBlog');

        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->makeSearchable('MiniBlog');
        $this->setModuleRights(1, 'MiniBlog');

        $this->setActionRights(1, 'MiniBlog', 'Index');
        $this->setActionRights(1, 'MiniBlog', 'Add');
        $this->setActionRights(1, 'MiniBlog', 'Edit');
        $this->setActionRights(1, 'MiniBlog', 'Delete');

        $this->insertExtra('MiniBlog', 'block', 'MiniBlog');
        $this->insertExtra('MiniBlog', 'widget', 'RecentPosts', 'recentposts');

        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation($navigationModulesId, 'MiniBlog', 'MiniBlog/Index', array('MiniBlog/Add', 'MiniBlog/Edit'));
    }
}
