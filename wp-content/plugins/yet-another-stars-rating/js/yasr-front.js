/****** Yasr shortcode page ******/

    function yasrVisitorsVotes (tooltipValues, postid, ajaxurl, size, loggedUser, voteIfUserAlredyRated, loaderHtml, nonceVisitor) {

        jQuery('#yasr_rateit_visitor_votes_' + postid).bind('over', function (event, value) { jQuery(this).attr('title', tooltipValues[value-1]); });

        var cookiename = "yasr_visitor_vote_" + postid;

        //Should be useless from version 0.7.9, just to be safe
        if (voteIfUserAlredyRated == "0" ) {
            voteIfUserAlredyRated = false;
        }

        //If user is not logged in
        if (! loggedUser) {

            //Check if has cookie and if so print readonly visitor shortcode
            if (jQuery.cookie(cookiename)) {                

                var cookievote=jQuery.cookie(cookiename);

                var data = {
                    action: 'yasr_readonly_visitor_shortcode',
                    size: size,
                    rating: cookievote,
                    post_id: postid
                }

                jQuery.post(ajaxurl, data, function(response) {
                    jQuery('#yasr_visitor_votes_' + postid).html(response);
                    jQuery('.rateit').rateit();
                });

            } //End if jquery cookie

            //If not logged and not cookie allowed to voted
            else {
                yasrDefaultRatingShortcode (postid);
            }

        } //End if (!loggeduser)

        //else, if is a logged in user
        else {

            //Do this code only if he has rated yet
            //Check only for value in db, not cookie, see here https://wordpress.org/support/topic/vote-updates-and-different-users-votes-problem
            if (voteIfUserAlredyRated) {

                jQuery('#yasr_rateit_visitor_votes_' + postid).on('rated', function() {

                    var el = jQuery(this);
                    var value = el.rateit('value');
                    var value = value.toFixed(1); //

                    if (value < 1) {
                        jQuery('#yasr_visitor_votes_' + postid).html('You can\'t vote 0');
                    } 

                    else {

                        jQuery('#yasr_visitor_votes_' + postid).html(loaderHtml);

                        var data = {
                                action: 'yasr_update_visitor_rating',
                                rating: value,
                                post_id: postid,
                                size: size,
                                nonce_visitor: nonceVisitor
                            };

                        //Send value to the Server
                        jQuery.post(ajaxurl, data, function(response) {
                            //response
                            jQuery('#yasr_visitor_votes_' + postid).html(response); 
                            jQuery('.rateit').rateit();
                            //Create a cookie to disable double vote
                            jQuery.cookie(cookiename, value, { expires : 360 }); 
                        }) ;      

                    }

                });//End function update vote

            } //End if jvoteIfUserAlredyRated == true

            else {

                yasrDefaultRatingShortcode (postid);

            }

        } //End else logged

        function yasrDefaultRatingShortcode (postid) {

            //On click Insert visitor votes
            jQuery('#yasr_rateit_visitor_votes_' + postid).on('rated', function() { 

                var el = jQuery(this);
                var value = el.rateit('value');
                var value = value.toFixed(1); //

                if (value < 1) {
                    jQuery('#yasr_visitor_votes_' + postid).html('You can\'t vote 0');
                }

                else {

                    jQuery('#yasr_visitor_votes_' + postid).html(loaderHtml);

                    var data = {
                        action: 'yasr_send_visitor_rating',
                        rating: value,
                        post_id: postid,
                        size: size,
                        nonce_visitor: nonceVisitor
                    };

                    //Send value to the Server
                    jQuery.post(ajaxurl, data, function(response) {
                        //response
                        jQuery('#yasr_visitor_votes_' + postid).html(response); 
                        jQuery('.rateit').rateit();
                        //Create a cookie to disable double vote
                        jQuery.cookie(cookiename, value, { expires : 360 }); 
                    }) ;    

                }      

            });

        } //End function default_rating_shortcode

    } //End function yasr visitor votes
   
    
    function yasrMostOrHighestRatedChart (ajaxurl) {

        //Link do nothing
        /*jQuery('#yasr_multi_chart_link_to_nothing').on("click", function () {

            return false; // prevent default click action from happening!

        });*/

            //By default, hide the highest rated chart
            jQuery('#yasr-highest-rated-posts').hide();

            //On click on highest, hide most and show highest
            jQuery('#yasr_multi_chart_highest').on("click", function () {

                jQuery('#yasr-most-rated-posts').hide();

                jQuery('#yasr-highest-rated-posts').show();

                return false; // prevent default click action from happening!

        });

        //Vice versa
        jQuery('#yasr_multi_chart_most').on("click", function () {

            jQuery('#yasr-highest-rated-posts').hide();

            jQuery('#yasr-most-rated-posts').show();

            return false; // prevent default click action from happening!

        });

    }


/****** End Yasr shortcode page  ******/


/****** Tooltip function ******/

    //used in ajax page
    function yasrDrawProgressBars (valueProgressbar, postId) {

        var i = null;

        var j = 0; //This is for the array

        for (i=5; i>0; i--) {

            jQuery( "#yasr-progress-bar-postid-"+postId+"-progress-bar-" + i).progressbar({
                value: valueProgressbar[j]
            });

            j=j+1;

        }
        
    }

    //used in shortcode page and ajax page
    function yasrDrawTipsProgress(postid, ajaxurl) {

        var varTipsContent = null;

        jQuery('#yasr-total-average-dashicon-' + postid).tooltip({

            position: { my: 'center bottom' , at: 'center top-10' },
            tooltipClass: "yasr-visitors-stats-tooltip",
            content: function(tipsContent) {

                if (!varTipsContent) {

                    var data = {
                        action: 'yasr_stats_visitors_votes',
                        post_id: postid
                    }

                    jQuery.post(ajaxurl, data, function(response) {
                        varTipsContent = response;
                        tipsContent(response);
                    });

                } 

                else {
                    return varTipsContent;
                }

            },
            disabled: true,
            close: function( event, ui ) { 
                jQuery(this).tooltip('disable'); 
            }

        });

        jQuery('#yasr-total-average-dashicon-' + postid).on("click", function(){
            jQuery(this).tooltip('enable').tooltip('open');
        });

    }



/****** End tooltipfunction ******/


/****** draw progress bar for yasr_pro_comment_reviews_summary ******/

    function yasrDrawProgressBarsReviewsSummery (valueProgressbar, postId) {

            var i = null;

            var j = 0; //This is for the array

            for (i=5; i>0; i--) {

                jQuery( "#yasr-pro-reviews-summary-postid-"+postId+"-progress-bar-" + i).progressbar({
                    value: valueProgressbar[j]
                });

                j=j+1;

            }
            
        }

/****** End progressbar function *******/


/****** Yasr pro shortcode page ******/

    function yasrProMostOrHighestRatedChart (view) {

        if (view != 'highest') {

            //By default, hide the highest rated chart
            jQuery('#yasr-pro-highest-rated-posts').hide();

            //On click on highest, hide most and show highest
            jQuery('#yasr-pro-multi-chart-highest').on("click", function () {

                jQuery('#yasr-pro-most-rated-posts').hide();

                jQuery('#yasr-pro-highest-rated-posts').show();

                return false; // prevent default click action from happening!

            });

            //Vice versa
            jQuery('#yasr-pro-multi-chart-most').on("click", function () {

                jQuery('#yasr-pro-highest-rated-posts').hide();

                jQuery('#yasr-pro-most-rated-posts').show();

                return false; // prevent default click action from happening!

            });

        }

        else {

            //By default, hide the most rated chart
            jQuery('#yasr-pro-most-rated-posts').hide();

            //On click on most, hide highest and show most
            jQuery('#yasr-pro-multi-chart-most').on("click", function () {

                jQuery('#yasr-pro-highest-rated-posts').hide();

                jQuery('#yasr-pro-most-rated-posts').show();

                return false; // prevent default click action from happening!

            });

            //Vice versa
            jQuery('#yasr-pro-multi-chart-highest').on("click", function () {

                jQuery('#yasr-pro-most-rated-posts').hide();

                jQuery('#yasr-pro-highest-rated-posts').show();

                return false; // prevent default click action from happening!

            });

        }

    }

/****** End Yasr pro shortcode page ******/