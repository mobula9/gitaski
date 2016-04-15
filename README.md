[![Latest Stable Version](https://poser.pugx.org/lucascherifi/gitaski/v/stable)](https://packagist.org/packages/lucascherifi/gitaski) [![Build Status](https://travis-ci.org/lucascherifi/gitaski.svg?branch=master)](https://travis-ci.org/lucascherifi/gitaski) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucascherifi/gitaski/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucascherifi/gitaski/?branch=master) [![License](https://poser.pugx.org/lucascherifi/gitaski/license)](https://packagist.org/packages/lucascherifi/gitaski)

Gitaski (keep it stupid, simple!)
=================================

The purpose of this repository is totally useless. It makes you as "an hardcoder" (then you're not). And you can giggle your friends, THAT's important.

Easy to use. In very little time, make your github commits list a "Funky" stuff.

## Quick usage

### 1) Install

#### Fast and furious way (phar version)

##### On Linux and Mac OS X

```bash
$ sudo curl -LsS https://git.io/vwIKT -o /usr/local/bin/gitaski && sudo chmod a+x /usr/local/bin/gitaski
```
Check that "It works!": `gitaski run --help` else take a look at the full documentation [here](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md).

##### On Windows

```bash
c:\> php -r "file_put_contents('symfony', file_get_contents('https://symfony.com/installer'));"
```
Check that "It works!": `gitaski run --help` else take a look at the full documentation [here](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md).

#### Via composer (global)

```bash
$ composer global require lucascherifi/gitaski
```
Check that "It works!": `gitaski run --help` else take a look at the full documentation [here](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md).

### 2) Create an empty git repository

[Just click here](https://github.com/new).

### 3) Run the command:

```bash
$ gitaski git@github.com:YOUR_PROFILE/AN_EMPTY_REPOSITORY_ALREADY_CREATED.git --use_text=Enjoy --force
```
Adapt with you own values ("YOUR_PROFILE", "AN_EMPTY_REPOSITORY_ALREADY_CREATED" and "Enjoy").

### 4) Enjoy!

[![Enjoy](https://github.com/lucascherifi/gitaski/blob/master/doc/enjoy.png)](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)

Make good use and do not hesitate to contribute to this project.

More documentation
------------------
- [Install](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)
- [Usage](https://github.com/lucascherifi/gitaski/blob/master/doc/usage.md)
- [Contributing](https://github.com/lucascherifi/gitaski/blob/master/doc/contributing.md)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    ./LICENSE