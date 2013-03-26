{include:{$BACKEND_CORE_PATH}/layout/templates/head.tpl}
{include:{$BACKEND_CORE_PATH}/layout/templates/structure_start_module.tpl}

<div class="pageTitle">
	<h2>{$lblMiniBlog|ucfirst}: {$lblAdd}</h2>
</div>

{form:add}
	<p>
		<label for="title">{$lblTitle|ucfirst}</label>
		{$txtTitle} {$txtTitleError}
	</p>

	<div class="tabs">
		<ul>
			<li><a href="#tabContent">{$lblContent|ucfirst}</a></li>
			<li><a href="#tabSEO">{$lblSEO|ucfirst}</a></li>
		</ul>

		<div id="tabContent">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td id="leftColumn">

						<div class="box">
							<div class="heading">
								<div class="oneLiner">
									<h3>{$lblIntroduction|ucfirst}<abbr title="{$lblRequiredField}">*</abbr></h3>

								</div>
							</div>
							<div class="optionsRTE">
								{$txtIntroduction} {$txtIntroductionError}
							</div>
						</div>

						<div class="box">
							<div class="heading">
								<h3>{$lblText|ucfirst}<abbr title="{$lblRequiredField}">*</abbr></h3>
							</div>
							<div class="optionsRTE">
								{$txtText} {$txtTextError}
							</div>
						</div>
					</td>
					<td id="sidebar">

						<div class="box" id="articleMeta">
							<div class="heading">
								<h3><label for="tags">{$lblTags|ucfirst}</label></h3>
							</div>
							<div class="options">
								{$txtTags} {$txtTagsError}
							</div>
						</div>

						<div class="box" id="articlePublish">
							<div class="heading">
								<h3>{$lblPublish|ucfirst}</h3>
							</div>
							<div class="options">
								{$chkPublish} <label for="publish">{$lblPublish|ucfirst}</label> {$chkPublishError}
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div id="tabSEO">
			{include:{$BACKEND_CORE_PATH}/layout/templates/seo.tpl}
		</div>
	</div>

	<div class="fullwidthOptions">
		<div class="buttonHolderRight">
			<input id="addButton" class="inputButton button mainButton" type="submit" name="add" value="{$lblAdd|ucfirst}" />
		</div>
	</div>
{/form:add}

{include:{$BACKEND_CORE_PATH}/layout/templates/structure_end_module.tpl}
{include:{$BACKEND_CORE_PATH}/layout/templates/footer.tpl}