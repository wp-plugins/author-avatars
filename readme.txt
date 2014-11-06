=== Author Avatars List ===
Contributors: bforchhammer, pbearne
Donate link:
Tags: Avatar, Author, Editor, Image, Photo, Picture, Profile, Shortcode, Random, Sidebar, Thumbnail, User, Widget, Wpmu
Requires at least: 2.6
Tested up to: 2.7.2
Stable tag: 0.7.1

Display lists of user avatars using widgets or shortcodes.

== Description ==

This plugin makes it easy to *display lists of user avatars* on your (multiuser) blog. It also allows to *insert single avatars* for blog users or any email address into a post or page. (Great for displaying an image of someone you're talking about.)

Avatar lists can be inserted into your sidebar by adding a widget or into posts/pages by using a [shortcode](http://codex.wordpress.org/User:Bforchhammer/Author_Avatars_ShortCode_Documentation). The plugin comes with a tinymce editor plugin which makes inserting shortcodes very easy.

Both shortcode and widget can be configured to...

*   Show a custom title (widget only)
*   Only show specific user groups and/or hide certain users
*   Limit the number of users shown
*   Change the sort order of users or show in random order
*   Adjust the size of user avatars
*   Show users from the current blog, all blogs or a selection of blogs (on WPMU)
*   Group users by their blog (when showing from multiple blogs), and show the blog name above each grouping (experimental feature).

The plugin makes use of built in wordpress (core) functions to retrieve user information and get avatars.

Single user avatars can be inserted using the [show_avatar shortcode](http://codex.wordpress.org/User:Bforchhammer/Author_Avatars_ShortCode_Documentation#The.C2.A0.5Bshow_avatar.5D_shortcode) and configured to...

*   Adjust the size of the user avatar.
*   Align the avatar left, centered or right.

Please report bugs and provide feedback in the [wordpress support forum](http://wordpress.org/tags/author-avatars?forum_id=10#postform). (I'm following all posts with the "author-avatars" tag.)

= Planned Features/Ideas =

*   User information popup on rollover
*   Advanced user display configuration / templates
*   I18n: provide base for translations
*   Any ideas or suggestions? [tell us about it](mailto:b.forchhammer@mind2.de)!

= Latest Changes (Version 0.7) =

*   Implemented new sorting by "number of posts" and "date of registration"
*   Added "sort direction" setting
*   Fixed numeric sorting (user id)
*   New option to link user avatars to their "website" or "blog" (wpmu)
*   Fixed uninstall behaviour

[Full Changelog](http://codex.wordpress.org/User:Bforchhammer/Author_Avatars_Changelog)

== Installation ==

1. Upload the `author-avatars` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Enable and configure the widget as usual on the Design / Widgets page.

[Look at this page](http://codex.wordpress.org/User:Bforchhammer/Author_Avatars_ShortCode_Documentation) to find out how to use the [authoravatars] shortcode.

[Changelog](http://codex.wordpress.org/User:Bforchhammer/Author_Avatars_Changelog)

== Screenshots ==

1. Very simple set up of the widget on an empty blog.
2. The Widget configuration panel.
3. Examples of what the <code>[authoravatars]</code> shortcode can do.
4. Shortcode helper available from the WYSIWYG editor on the edit post page.

== Frequently asked questions ==

= Shortcode, huh? =

A shortcode is a tag like <code>[authoravatars]</code> which you can insert into a page or post to display a list of users on that post/page. You can read more about shortcodes in general in the wordpress codex, for example [here](http://codex.wordpress.org/Using_the_gallery_shortcode) or [here](http://codex.wordpress.org/Shortcode_API).

= How do I use the author avatar shortcode? =

As of version 0.6 the plugin comes with a tinymce plugin which makes it very easy to insert shortcode(s).

If you'd like to do it manually it's still simple: just add <code>[authoravatars]</code> into your post and hit save! There's a large number of [parameters](http://codex.wordpress.org/User:Bforchhammer/Author_Avatars_ShortCode_Documentation) available.

The plugin comes with two shortcodes: <code>[authoravatars]</code> for lists of avatars and <code>[show_avatar]</code> for single avatars.

= I can't get my widget to show users from multiple blogs! =

Make sure you have enabled the "blog filter" in Site Admin / Author Avatars for the blog on which you are trying to use this feature on. By default this is only enabled for the root blog (blog id = 1).

And you are running [Wordpress MU](http://mu.wordpress.org/), right?

= Can I upload custom pictures for users? =

No, the Author Avatars List plugin only provides ways of <strong>displaying</strong> user avatars.

The plugin uses the Wordpress Core Template function <code>get_avatar()</code> to retrieve the actual avatar images. In order to display custom images you need to look for plugins which use/override WordPress' avatar features and provide respective upload features...

Have a look at the [User Photo](http://wordpress.org/extend/plugins/user-photo/) Plugin (turn on option "Override Avatar with User Photo") or the [Add Local Avatar](http://wordpress.org/extend/plugins/add-local-avatar/) Plugin.

= I get a "404 Page not found" error when I click on the avatar of a user! =

This happens when the user has not written any posts on a blog. There are two things that you should do in this situation:

1. To prevent the 404 page from showing up install the [Show authors without posts](http://wordpress.org/extend/plugins/show-authors-without-posts/) Plugin. This forces WordPress to always show the user page if the user exists.

2. If not already there add a custom user/author template to your theme. Otherwise if a user has no posts their user page is going to be quite empty by default...
You can find a [tutorial](http://codex.wordpress.org/Author_Templates) on Author Templates as well as a [Sample Template File](http://codex.wordpress.org/Author_Templates#Sample_Template_File) in the WordPress Codex.
