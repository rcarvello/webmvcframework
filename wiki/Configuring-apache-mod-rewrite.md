## Prerequisites

To follow this tutorial, you will need:

One Debian 10 server with Apache installed

### Step 1 - Enabling mod_rewrite

First we need to activate mod_rewrite. It’s already installed, but it’s disabled on a default Apache installation.
Use the a2enmod command to enable the module:

`sudo a2enmod rewrite`

This will activate the module or alert you that the module is already enabled. To put these changes into effect, restart
Apache:

`sudo systemctl restart apache2`

mod_rewrite is now fully enabled.

### Step 2 - Configure Apache2 Virtual Host

Before you start using mod_rewrite you’ll need to set up and secure a few more settings.

By default, Apache prohibits using rewrite (with is configured by the framework into .htaccess file) so first, you need
to allow changes to the site configuration. Open the default Apache configuration file using nano or your favorite text
editor:

`sudo nano /etc/apache2/sites-available/000-default.conf`

Inside that file, you will find a <VirtualHost *:80> block starting on the first line. Inside of that block, add the
following new block so your configuration file looks like the following. Make sure that all blocks are properly
indented:

```
/etc/apache2/sites-available/000-default.conf

<VirtualHost *:80>
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    . . .
</VirtualHost>
```

Save and close the file. If you used nano, do so by pressing CTRL+X, Y, then ENTER.  
Note: Do the same changes for SSL sites.

Then, check your configuration:

`sudo apache2ctl configtest`

If there are no errors, restart Apache to put your changes into effect:

`sudo systemctl restart apache2`