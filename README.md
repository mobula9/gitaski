[![Latest Stable Version](https://poser.pugx.org/lucascherifi/gitaski/v/stable)](https://packagist.org/packages/lucascherifi/gitaski) [![Build Status](https://travis-ci.org/lucascherifi/gitaski.svg?branch=master)](https://travis-ci.org/lucascherifi/gitaski) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucascherifi/gitaski/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucascherifi/gitaski/?branch=master) [![License](https://poser.pugx.org/lucascherifi/gitaski/license)](https://packagist.org/packages/lucascherifi/gitaski)

Gitaski (keep it stupid, simple!)
=================================

The purpose of this repository is totally useless. It makes you as "an hardcoder" (then you're not). And you can giggle your friends, THAT's important.

Easy to use. In very little time, make your github commits list a "Funky" stuff.

## The quick and impressive "35 seconds" setup.

### 1) Create an empty git repository (about 15 sec)

Just [click here](https://github.com/new), type something like "long-stories" then type "Enter". It's done, next step.

### 2) Install Gitaski (about 10 sec)

```bash
sudo curl -LsS https://git.io/vwIKT -o /usr/local/bin/gitaski && sudo chmod a+x /usr/local/bin/gitaski
```

(requires PHP installed on your machine)

- Quick check: `gitaski run --help`, else take a look at the [install documentation](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)
- Windows users? See the [install documentation](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)
- Prefer using composer? See the [install documentation](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)

### 3) Run the command  (about 10 sec)

```bash
gitaski git@github.com:<YOUR_PROFILE>/<EMPTY_CREATED_REPOSITORY>.git --use_text=Enjoy --force
```
Note: adapt with you own values (`YOUR_PROFILE`,`EMPTY_CREATED_REPOSITORY`,`Enjoy`)

### 4) Enjoy!

[![Enjoy](https://github.com/lucascherifi/gitaski/blob/master/doc/enjoy.png)](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)

Make good use and do not hesitate to contribute to this "very useful" project.

## Uninstall
```bash
sudo rm /usr/local/bin/gitaski
```

Wants also to remove the pretty ascii art you draw? Just delete the Github repository you created.

Full documentation
------------------
- [Install](https://github.com/lucascherifi/gitaski/blob/master/doc/install.md)
- [Usage](https://github.com/lucascherifi/gitaski/blob/master/doc/usage.md)
- [Contributing](https://github.com/lucascherifi/gitaski/blob/master/doc/contributing.md)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    ./LICENSE