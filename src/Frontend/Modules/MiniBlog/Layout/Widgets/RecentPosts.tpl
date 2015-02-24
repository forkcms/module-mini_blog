{*
	variables that are available:
	- {$widgetMiniBlogRecentPosts}
*}
<section id="blogRecentCommentsWidget" class="mod">
	<div class="inner">
		<header class="hd">
			<h3>{$lblRecentArticles|ucfirst}</h3>
		</header>
		<div class="bd content">
			{option:widgetMiniBlogRecentPosts}
				<ul>
					{iteration:widgetMiniBlogRecentPosts}
						<li>
							<a href="{$widgetMiniBlogRecentPosts.full_url}">{$widgetMiniBlogRecentPosts.title}</a>
							{$msgWrittenBy|ucfirst|sprintf:{$widgetMiniBlogRecentPosts.user_id|usersetting:'nickname'}} {$lblOn} {$widgetMiniBlogRecentPosts.edited|date:{$dateFormatShort}:{$LANGUAGE}}
						</li>
					{/iteration:widgetMiniBlogRecentPosts}
				</ul>
			{/option:widgetMiniBlogRecentPosts}
			{option:!widgetMiniBlogRecentPosts}
				{$msgThereAreNoRecentItemsYet}
			{/option:!widgetMiniBlogRecentPosts}
		</div>
	</div>
</section>
