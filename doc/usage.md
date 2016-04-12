# Quick example

```bash
$ gitaski run git@github.com:YOUR_PROFILE/AN_EMPTY_REPOSITORY_ALREADY_CREATED.git --use_text=Hello --force
```

# Command usage

```bash
$ gitaski run --help
```

```bash
Usage:
  gitaski [options] [--] [<github_repository_url>]

Arguments:
  github_repository_url                                    Which github repository URL?

Options:
      --use_text=USE_TEXT                                  If set, the ascii art will be generated from this text.
      --artwork_path=ARTWORK_PATH                          If set, the JSON file at this path will be used instead of the text.
  -f, --input_filepath=INPUT_FILEPATH                      If set, this file will be used to generate dummy content. [default: "/Users/lcherifi/projects/gitascii/src/Resources/fixtures/sample.md"]
      --commit_list_yml_filepath=COMMIT_LIST_YML_FILEPATH  If set, this file will be used to generate dummy content. [default: "/Users/lcherifi/projects/gitascii/src/Resources/fixtures/commit-messages.yml"]
      --output_filename=OUTPUT_FILENAME                    If set, this filename will be used for the commited file. [default: "README.md"]
      --force                                              If set, the commits will be really pushed to the repository URL, else it run in dry-mode mode.
  -h, --help                                               Display this help message
  -q, --quiet                                              Do not output any message
  -V, --version                                            Display this application version
      --ansi                                               Force ANSI output
      --no-ansi                                            Disable ANSI output
  -n, --no-interaction                                     Do not ask any interactive question
  -v|vv|vvv, --verbose                                     Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
 Build Github ASCII art
```

# Generate an artwork

@see http://patorjk.com/software/taag/

Font name to use : http://artii.herokuapp.com/fonts_list