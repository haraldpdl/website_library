osCommerce Library (Website)
============================

This repository contains the development of the new osCommerce Documentation
website powered by the osCommerce Online Merchant v3.0 framework.

Our website is not a general purpose solution for users to use as their
website - it is custom and tailored to run the main osCommerce website. The
frontend design is licensed and some graphics will not be available on Github.
No installation routine is present however setup instructions are available for
those interested in helping out.

The actual documentation content is Copyright (c) osCommerce. All rights
reserved. The content may be reproduced for personal use only. Documentation
authors grant osCommerce the ability to use the documentation as described in:

http://www.oscommerce.com/cla.txt

Installation
------------

Follow the instructions at and install haraldpdl/oscommerce_website first.

    https://github.com/haraldpdl/oscommerce_website

Copy this repository:

    git clone https://github.com/haraldpdl/website_library.git

The following directory structure is now in place:

* oscommerce - osCommerce Online Merchant v3.0
* oscommerce_website - osCommerce Website
* website_library - osCommerce Library Website

Symlink the following directories from "website_library" to "oscommerce":

    cd oscommerce/osCommerce/OM/Custom/Site
    ln -s ../../../../../website_library/osCommerce/OM/Custom/Site/Library Library
    cd ../../../../public
    ln -s ../../../website_library/public/external/prettify external/prettify
    ln -s ../../../website_library/public/sites/Library sites/Library

A configuration block is also required in osCommerce/OM/Config/settings.ini,
which can be copied from an existing block:

    [Library]
    enable_ssl = "false"
    http_server = "http://your-server"
    https_server = "http://your-server"
    http_cookie_domain = ""
    https_cookie_domain = ""
    http_cookie_path = "/oscommerce/"
    https_cookie_path = "/oscommerce/"
    dir_ws_http_server = "/oscommerce/"
    dir_ws_https_server = "/oscommerce/"

The website can then be accessed with the following URL:

    http://your-server/oscommerce/index.php?Library

Feedback
---------

Please review the following forum topic for discussions on the documentation
website.

http://forums.oscommerce.com/topic/390596-oscommerce-library-new-documentation-site/

Discussions for our new website platform are held in:

http://forums.oscommerce.com/forum/89-website-platform/

Note
----

Although the source code to new osCommerce website is available, it will
obviously not be packaged together with osCommerce Online Merchant v3.0.

Making the source code available serves to showcase the capabilities of the
framework, to migrate the Add-Ons and Live Shops sites to the new platform,
to create new Documentation and Translations Sites, and to kickstart the
initiative of a general purpose CMS Site that can be packaged with
osCommerce Online Merchant v3.0.
