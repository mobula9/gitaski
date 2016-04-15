Installation
============

Download the "gitaski" PHP Library
----------------------------------

### A) Via a PHAR file

```bash
sudo curl -LsS https://git.io/vwIKT -o /usr/local/bin/gitaski && sudo chmod a+x /usr/local/bin/gitaski
```

##### On Windows

```bash
c:\> php -r "file_put_contents('gitaski', file_get_contents('https://git.io/vwIKT'));"
```

### B) Via composer (global access)

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
composer global require lucascherifi/gitaski
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Simply add this directory to your PATH in your ~/.bash_profile (or ~/.bashrc) like this:

```bash
export PATH=~/.composer/vendor/bin:$PATH
```

To keep your tools up to date, you simply do this:

```bash
composer global update
```

Enjoy !

Remove this useless PHP Library (via composer global access)
------------------------------------------------------------

To remove this package, edit ~/.composer/composer.json and then run `composer global update`.