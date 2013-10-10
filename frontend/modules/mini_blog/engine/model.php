<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * In this file we store all generic functions that we will be using in the mini-blog module
 *
 * @author Davy Hellemans <davy.hellemans@netlash.com>
 * @author Dave Lens <dave.lens@netlash.com>
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 * @author Annelies Van Extergem <annelies.vanextergem@netlash.com>
 * @author Matthias Mullie <matthias.mullie@netlash.com>
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 * @author Jelmer Snoeck <jelmer.snoeck@netlash.com>
 */
class FrontendMiniBlogModel implements FrontendTagsInterface
{
	/**
	 * Add 1 to the awesomeness of a blog_post
	 *
	 * @param string $postId
	 */
	public static function addAwesomeness($postId)
	{
		FrontendModel::getContainer()->get('database')->execute(
			'UPDATE mini_blog
			 SET awesomeness = awesomeness + 1
			 WHERE id = ?',
			array((int) $postId)
		);
	}

	/**
	 * Fetch one article based upon it's meta url
	 *
	 * @param string $url
	 * @return array
	 */
	public static function get($url)
	{
		return (array) FrontendModel::getContainer()->get('database')->getRecord(
			'SELECT
			 	i.id, i.language, i.title, i.introduction, i.text, i.awesomeness, i.user_id,
			 	UNIX_TIMESTAMP(i.edited) AS edited, m.keywords AS meta_keywords,
			 	m.keywords_overwrite AS meta_keywords_overwrite, m.description AS meta_description,
			 	m.description_overwrite AS meta_description_overwrite, m.title AS meta_title,
			 	m.title_overwrite AS meta_title_overwrite, m.url
			 FROM mini_blog AS i
			 INNER JOIN meta AS m ON i.meta_id = m.id
			 WHERE i.language = ? AND i.publish = ? AND m.url = ?
			 LIMIT 1',
			array(FRONTEND_LANGUAGE, 'Y', (string) $url)
		);
	}

	/**
	 * Get all items (at least a chunk)
	 *
	 * @param int[optional] $limit
	 * @param int[optional] $offset
	 * @return array
	 */
	public static function getAll($limit = 10, $offset = 0)
	{
		$items = (array) FrontendModel::getContainer()->get('database')->getRecords(
			'SELECT
			 	i.id,i.language, i.title, i.introduction, i.text, i.awesomeness,
				UNIX_TIMESTAMP(i.edited) AS edited, i.user_id, m.url
			 FROM mini_blog AS i
			 INNER JOIN meta AS m ON i.meta_id = m.id
			 WHERE i.language = ? AND i.publish = ?
			 ORDER BY i.created DESC
			 LIMIT ?, ?',
			array(FRONTEND_LANGUAGE, 'Y', (int) $offset, (int) $limit)
		);

		// no results?
		if(empty($items)) return array();

		$ids = array();
		$link = FrontendNavigation::getURLForBlock('mini_blog', 'detail');

		foreach($items as $key => $row)
		{
			$ids[] = (int) $row['id'];
			$items[$key]['full_url'] = $link . '/' . $row['url'];
		}

		// get all tags
		$tags = FrontendTagsModel::getForMultipleItems('mini_blog', $ids);

		// loop tags and add to correct item
		foreach($tags as $postId => $tags)
		{
			if(isset($items[$postId])) $items[$postId]['tags'] = $tags;
		}

		return $items;
	}

	/**
	 * Get the number of items
	 *
	 * @return int
	 */
	public static function getAllCount()
	{
		return (int) FrontendModel::getContainer()->get('database')->getVar(
			'SELECT COUNT(i.id) AS count
			 FROM mini_blog AS i
			 WHERE i.language = ? AND i.publish = ?',
			array(FRONTEND_LANGUAGE, 'Y')
		);
	}

	/**
	 * Fetch the list of tags for a list of items
	 *
	 * @param array $ids
	 * @return array
	 */
	public static function getForTags(array $ids)
	{
		$items = (array) FrontendModel::getContainer()->get('database')->getRecords(
			'SELECT i.title, m.url
			 FROM mini_blog AS i
			 INNER JOIN meta AS m ON m.id = i.meta_id
			 WHERE i.publish = ? AND i.id IN (' . implode(',', $ids) . ')
			 ORDER BY i.created DESC',
			array('Y')
		);

		if(!empty($items))
		{
			$link = FrontendNavigation::getURLForBlock('mini_blog', 'detail');
			foreach($items as $key => $row) $items[$key]['full_url'] = $link . '/' . $row['url'];
		}

		return $items;
	}

	/**
	 * Get the id of an item by the full URL of the current page.
	 * Selects the proper part of the full URL to get the item's id from the database.
	 *
	 * @param FrontendURL $URL
	 * @return int
	 */
	public static function getIdForTags(FrontendURL $URL)
	{
		// select the proper part of the full URL
		$itemURL = (string) $URL->getParameter(1);
		return self::get($itemURL);
	}

	/**
	 * Get an array with the previous and the next post
	 *
	 * @param int $id
	 * @return array
	 */
	public static function getNavigation($id)
	{
		$id = (int) $id;
		$db = FrontendModel::getContainer()->get('database');

		$date = (string) $db->getVar(
			'SELECT i.created
			 FROM mini_blog AS i
			 WHERE i.id = ?',
			array($id)
		);

		if($date == '') return array();
		$navigation = array();

		$navigation['previous'] = $db->getRecord(
			'SELECT i.id, i.title, m.url
			 FROM mini_blog AS i
			 INNER JOIN meta AS m ON i.meta_id = m.id
			 WHERE
			 	i.id != ? AND
			 	i.publish = ? AND
			 	i.language = ? AND
			 	i.created <= ?
			 ORDER BY i.created DESC
			 LIMIT 1',
			array($id, 'Y', FRONTEND_LANGUAGE, $date)
		);

		$navigation['next'] = $db->getRecord(
			'SELECT i.id, i.title, m.url
			 FROM mini_blog AS i
			 INNER JOIN meta AS m ON i.meta_id = m.id
			 WHERE
			 	i.id != ? AND
			 	i.publish = ? AND
			 	i.language = ? AND
			 	i.created > ?
			 ORDER BY i.created ASC
			 LIMIT 1',
			array($id, 'Y', FRONTEND_LANGUAGE, $date)
		);

		return $navigation;
	}

	/**
	 * Parse the search results for this module
	 *
	 * Note: a module's search function should always:
	 * 		- accept an array of entry id's
	 * 		- return only the entries that are allowed to be displayed, with their array's index being the entry's id
	 *
	 *
	 * @param array $ids
	 * @return array
	 */
	public static function search(array $ids)
	{
		$items = (array) FrontendModel::getContainer()->get('database')->getRecords(
			'SELECT i.id, i.title, i.introduction, i.text, m.url
			 FROM mini_blog AS i
			 INNER JOIN meta AS m ON i.meta_id = m.id
			 WHERE i.publish = ? AND i.language = ?',
			array('Y', FRONTEND_LANGUAGE), 'id'
		);

		// prepare items for search
		$detailUrl = FrontendNavigation::getURLForBlock('mini_blog', 'detail');
		foreach($items as $key => $item)
		{
			$items[$key]['full_url'] = $detailUrl . '/' . $item['url'];
		}

		return $items;
	}
}
