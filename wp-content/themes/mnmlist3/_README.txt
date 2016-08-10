Manifest README

Author: Leo Babauta
Author URI: http://mnmlist.com
Theme URI: http://mnmlist.com/theme


mnmlist is a clean and very minimalist theme that focuses on the content without distractions. It has a single sidebar. No widgets. No comments. No search. No dynamic sidebar. No nothing.

This is v3 of the theme. In this version:

* fonts have been improved
* some other stuff has been stripped
* the archives is now on the main page (index page)
* it still has no sidebar, header, comments, widgets, etc.

This theme is uncopyrighted -- use as you like, spread it, sell it, do whatever you want. Thanks and enjoy.


Basic Setup
---------------------------------
You'll need to edit several pages in the Wordpress theme editor - go to Wordpress admin, then Appearance, then editor (after you've activated this theme).

- Index
Change the link at the bottom to include your RSS or email subscription url or page. Right now it has my page on mnmlist:

<h1><b><a href="http://mnmlist.com/feeds/">subscribe</a></b></h1>


- Footer
Right now, there's an "uncopyright" link, but it will go to my uncopyright page. Create your own, or put a copyright notice here, or whatever links you want. I also have links that say "more" and "less", but you can change these to whatever links you want -- perhaps your about page, contact page, or whatever.

- Archives
To get the search box to work correctly, you'll need to put your domain name into the line:
	var domainroot="mnmlist.com"
You'll also want to change the categories and links in the Categories section to reflect your blog's categories and links.


Again, there are no comments. You'll need to add these in to the theme if you want them. It's not that hard -- just copy comments php files and code from other themes, and add it to this theme.

This theme is designed to be as minimalist as possible, so I've stripped out a lot of functions that other themes have. That's the choice I've made and I like it that way.

This theme is "as is" - any bugs, you need to fix it. Any changes you want, you'll need to make them.