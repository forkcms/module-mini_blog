{*
	variables that are available:
	- {$items}: contains an array with all posts, each element contains data about the post
*}

{option:!items}
	<div id="blogIndex">
		<section class="mod">
			<div class="inner">
				<div class="bd content">
					<p>{$msgBlogNoItems}</p>
				</div>
			</div>
		</section>
	</div>
{/option:!items}
{option:items}
	<div id="blogIndex">
		{iteration:items}
			<article class="mod">
				<div class="inner">
					<header class="hd">
						<h3><a href="{$items.full_url}" title="{$items.title}">{$items.title}</a></h3>
						<ul>
							<li>{$msgWrittenBy|ucfirst|sprintf:{$items.user_id|usersetting:'nickname'}} {$lblOn} {$items.edited|date:{$dateFormatLong}:{$LANGUAGE}}</li>
						</ul>
					</header>
					<div class="bd content">
						{$items.introduction}
					</div>
					<div class="awesome" id="awesome{$items.id}">
						<em>
							<span class="counter">{$items.awesomeness}</span> {$lblPeopleThinkThisPostIsAwesome} <span class="bar">|</span>
							<a class="add" rel="{$items.id}">{$lblIThinkThisIsAwesome}</a>
							<span style="display:none;" class="added">{$lblIThinkThisIsAwesome}</span>
						</em>
					</div>
				</div>
			</article>
		{/iteration:items}
	</div>
	{include:{$FRONTEND_CORE_PATH}/layout/templates/pagination.tpl}
{/option:items}
