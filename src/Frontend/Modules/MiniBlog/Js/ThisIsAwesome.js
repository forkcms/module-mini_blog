/**
 * This JS-file is loaded in every action page of the mini_blog module
 *
 * @author Jelmer Snoeck <jelmer.snoeck@netlash.com>
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */

jsFrontend.MiniBlog =
{
    // init, something like a constructor
    init: function () {
        //init ajax action (this_is_awesome)
        jsFrontend.MiniBlog.ajax();
    },

    ajax: function () {
        // for all buttons with the awesome class (on the detailpage, just one, but on the index page, many
        $('.awesome a.add').click(function (e) {
            e.preventDefault();

            // split the url in pieces, so we can easily get the working language
            // We need to add the language attribute to every
            // ajax call because our site is multilangual.
            var chunks = document.location.pathname.split('/');

            // we added a rel-attribute to our HTML-tag which contains the id of the blogpost
            var arg = $(this).attr('rel');

            $.ajax(
                {
                    data: {
                        fork: { module: 'MiniBlog', action: 'ThisIsAwesome' },
                        post_id: arg
                    },
                    success: function (data) {
                        //alert the user of we're in debug mode and something went wrong
                        if (data.code != 200 && jsFrontend.debug) {
                            alert(data.message);
                        }

                        // hide the button on which we clicked
                        $('#awesome' + arg + ' a.add').hide();
                        $('#awesome' + arg + ' .added').css({'opacity': 0.4});
                        $('#awesome' + arg + ' .added').show();

                        //increment the items awesomeness counter
                        $('#awesome' + arg + ' .counter').html('<strong>' + (parseInt($('#awesome' + arg + ' .counter').html()) + 1) + '</strong>');
                    }
                });
        });
    }
}

$(jsFrontend.MiniBlog.init);