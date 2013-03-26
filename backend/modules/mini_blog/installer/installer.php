<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This action will install the mini blog module.
 *
 * @author Jelmer Snoeck <jelmer.snoeck@netlash.com>
 */
class MiniBlogInstaller extends ModuleInstaller
{
	/**
	 * Install the module
	 */
	public function install()
	{
		$this->importSQL(dirname(__FILE__) . '/data/install.sql');

		$this->addModule('mini_blog');

		$this->importLocale(dirname(__FILE__) . '/data/locale.xml');

		$this->makeSearchable('mini_blog');
		$this->setModuleRights(1, 'mini_blog');

		$this->setActionRights(1, 'mini_blog', 'index');
		$this->setActionRights(1, 'mini_blog', 'add');
		$this->setActionRights(1, 'mini_blog', 'edit');
		$this->setActionRights(1, 'mini_blog', 'delete');

		$miniBlogId = $this->insertExtra('mini_blog', 'block', 'MiniBlog');
		$this->insertExtra('mini_blog', 'widget', 'RecentPosts', 'recent_posts');

		// set navigation
		$navigationModulesId = $this->setNavigation(null, 'Modules');
		$navigationBlogId = $this->setNavigation($navigationModulesId, 'MiniBlog', 'mini_blog/index', array('mini_blog/add',	'mini_blog/edit'));
	}
}
