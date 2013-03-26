<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This action will add a post to the blog module.
 *
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 */
class BackendMiniBlogAPI
{
	public static function showTopAwesome()
	{
		$number = (int) SpoonFilter::getGetValue('number', null, 10);
		$days = (int) SpoonFilter::getGetValue('days', null, 7);

		API::output('200', BackendMiniBlogModel::getTopAwesome($number, $days));
	}
}
