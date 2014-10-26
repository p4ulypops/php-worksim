php-worksim
===========
This is my Cleanup of the php-worksim code, plus additional features. 

I'm being careful not to add new features, but I would do the following
 - Create a new 'Feed Grabber' to be executed on a CRON job, instead of polling the urls every time.
 - Create a new custom post type of "Blog Entry" that would cache each entery sepoartly, using a md5(Permalink) and checking the date to see if the article has been updated. This will allow for viewing of specific articles, along with commenting/sharing them. 
 - Alert via Email when a post goes from Draft to Published.
 - Allow for a submition to just put in the url of the site, and I would find the site's RSS feed from that, along with the site's meta-information (such as OG tags, title, etc).
 - Cache the images myself into wordpress's internal Media section - which can be put on CDN.
 - Check to make sure the feed submitted is actually an RSS feed.
