# News

Call out important threads with a terse headline and description.

## Installation

Download the [latest release](https://github.com/ShinkaDev-MyBB/News/releases) and unzip it in the root of your MyBB installation.

## Requirements

-   PHP version >= 5.3.0
-   See branch `lower-support` for an alternative that may work on lower versions. This branch is not thoroughly tested and is not guaranteed to be up to date.

## Features

-   Allow users to submit threads to a news feed
-   Pin important news to the top of the feed
-   Delete news
-   Add prefixes that news can be tagged with

### Permissions

-   Forums that threads can be submitted from
-   Usergroups that can submit news
-   Usergroups that can mark news as important
-   Usergroups that can delete news
-   Usergroups that can edit news

## Screenshots

![alt text](https://github.com/ShinkaDev-MyBB/News/blob/master/docs/latest.PNG "Latest News")
![alt text](https://github.com/ShinkaDev-MyBB/News/blob/master/docs/submit.PNG "Submit News")
![alt text](https://github.com/ShinkaDev-MyBB/News/blob/master/docs/settings.PNG "Settings")

## Development

### Shell Scripts

```bash
# Creates symbolic links for src files in MyBB installation
$ ./shinka.sh link <mybb_path>
# Destroys symbolic links
$ ./shinka.sh unlink <mybb_path>
# Bundles src files for release
$ ./shinka.sh release [-v <version> | --version <version>] [-V <vendor> | --vendor <vendor>] [-c <code> | --code <code>]
```

### Local Setup

```bash
$ git clone https://github.com/ShinkaDev-MyBB/News.git
$ cd News
$ ./shinka.sh link path/to/mybb/root
```

### Release

Versions should follow [Semantic Versioning standards](https://semver.org/).

```bash
$ ./shinka.sh release --version 0.0.1-alpha.2
```
