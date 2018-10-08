# News

Call out important threads with a terse headline and description.

## Installation

Download the [latest release](https://github.com/ShinkaDev-MyBB/News/releases) and unzip in the root of your MyBB installation.

## Requirements

-   PHP version >= 5.3.0
-   See branch `lower-support` for an alternative that may work on lower versions. This branch is not thoroughly tested and is not guaranteed to be up to date.

## Features

-   Allow users to submit threads to a news feed
-   Pin important news to the top of the feed
-   Delete news
-   Add prefixes that news can be tagged with
-   Moderation to approve or deny pending news.

### Permissions

-   Forums that threads can be submitted from
-   Usergroups that can submit news
-   Usergroups that can mark news as important
-   Usergroups that can delete news
-   Usergroups that can edit news
-   Usergroups that require moderator approval
-   Usergroups that can approve or deny pending news

## Screenshots

![alt text](https://github.com/ShinkaDev-MyBB/News/blob/master/docs/latest.PNG "Latest News")
![alt text](https://github.com/ShinkaDev-MyBB/News/blob/master/docs/submit.PNG "Submit News")
![alt text](https://github.com/ShinkaDev-MyBB/News/blob/master/docs/settings.PNG "Settings")

### Contributing

#### Shell Scripts

```bash
# Creates hard links for src files in MyBB installation
$ shinka link
# Destroys hard links
$ shinka unlink
# Runs tests
$ shinka test <mybb_path> [-d <test_path>]
# Bundles src files for release
$ shinka release [-v <version> | --version <version>] [-V <vendor> | --vendor <vendor>] [-c <code> | --code <code>]
# Lists available commands
$ shinka --help
# Shows usage and options for command
$ shinka <command> --help
```

#### Local Setup

```bash
$ git clone https://github.com/ShinkaDev-MyBB/News.git
$ cd News

# Optional but recommended
$ yarn global add shinka-cli
# Update shinka.json with your MyBB root path
$ yarn link
```

#### Testing

> This is a terrible, brute-force way to unit test code that relies on MyBB's library and database. If you have a better idea, open an issue or a pull request!

Copy `src/inc/plugins/Shinka/Core/Test/resources/config/database.example.php` to `src/inc/plugins/Shinka/Core/Test/resources/config/database.php` and update file to match your test database.

**Do not run on production database.** Tables are truncated during testing.

```bash
# Run all tests
$ ./shinka.sh test path/to/mybb/root
# Run only News tests
$ ./shinka.sh test path/to/mybb/root -d path/to/mybb/root/inc/plugins/Shinka/News
# Run specific tests
$ ./shinka.sh test path/to/mybb/root -d path/to/tests
```

#### Release

Versions should follow [Semantic Versioning standards](https://semver.org/).

```bash
$ shinka release --version 0.0.1-alpha.2
```
