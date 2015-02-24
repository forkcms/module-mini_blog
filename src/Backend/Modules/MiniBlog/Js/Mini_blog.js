/**
 * Interaction for the mini blog module
 *
 * @author Jelmer Snoeck <jelmer.snoeck@netlash.com>
 */
jsBackend.miniBlog =
{
	// init, something like a constructor
	init: function()
	{
		// variables
		$title = $('#title');
		if($title.length > 0) $title.doMeta();
	}
}

$(jsBackend.miniBlog.init);