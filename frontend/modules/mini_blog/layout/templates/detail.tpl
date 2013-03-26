{*
	variables that are available:
	- {$item}: contains data about the post
	- {$navigation}: contains an array with data for previous and next post
*}
<div id="blogDetail">
	<article class="mod article">
		<div class="inner">
			<header class="hd">
				<h1>{$item.title}</h1>
				<ul>
					<li>{$msgWrittenBy|ucfirst|sprintf:{$item.user_id|usersetting:'nickname'}} {$lblOn} {$item.edited|date:{$dateFormatLong}:{$LANGUAGE}}</li>
				</ul>
			</header>
			<div class="bd content">
				{$item.introduction}
			</div>
			<div class="bd content">
				{$item.text}
			</div>
			<div class="awesome" id="awesome{$item.id}">
				<em>
					<span class="counter">{$item.awesomeness}</span> {$lblPeopleThinkThisPostIsAwesome} <span class="bar">|</span>
					<a class="add" rel="{$item.id}">{$lblIThinkThisIsAwesome}</a>
					<span style="display:none;" class="added">{$lblIThinkThisIsAwesome}</span>
				</em>
			</div>
			{option:navigation}
			<footer class="ft">
				<ul class="pageNavigation">
					{option:navigation.previous}
						<li class="previousLink">
							<a href="{$navigation.previous.url}" rel="prev">{$lblPreviousArticle|ucfirst}: {$navigation.previous.title}</a>
						</li>
					{/option:navigation.previous}
					{option:navigation.next}
						<li class="nextLink">
							<a href="{$navigation.next.url}" rel="next">{$lblNextArticle|ucfirst}: {$navigation.next.title}</a>
						</li>
					{/option:navigation.next}
				</ul>
			</footer>
			{/option:navigation}
		</div>
	</article>
</div>