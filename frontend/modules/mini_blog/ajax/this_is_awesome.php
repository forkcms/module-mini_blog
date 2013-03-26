<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This is the "this is awesome-action", it will add 1 to awesomeness of a mini_blog_post
 *
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 */
class FrontendMiniBlogAjaxThisIsAwesome extends FrontendBaseAJAXAction
{
	/**
	 * Execute the action
	 */
	public function execute()
	{
		$post_id = (int) SpoonFilter::getPostValue('post_id', null, '', 'int');

		if($post_id == 0) $this->output(self::BAD_REQUEST, null, 'invalid post_id-parameter.');

		FrontendMiniBlogModel::addAwesomeness($post_id);

		$this->output(self::OK);
	}
}
