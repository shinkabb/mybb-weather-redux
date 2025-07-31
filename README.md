# Weather
Provides weather data for use in index templates.

**Cache is updated every hour**

## Installation
Upload `inc` to the root of your MyBB installation.

## Usage
| Variable                           | Description         | Example |
|------------------------------------|---------------------|---------|
| `{$weather['weather'][0]['main']}` | Current weather     | Sunny   |
| `{$weather['main']['temp']}`       | Current temperature | 73.5    |

See [OpenWeatherMap API Documentation](https://openweathermap.org/api) for further information.

## Screenshots
![alt text](https://github.com/ShinkaDev-MyBB/mybb-weather/blob/master/docs/settings.PNG "Settings")
![alt text](https://github.com/ShinkaDev-MyBB/mybb-weather/blob/master/docs/example.PNG "Example")

## Installation

Download the [latest release](https://github.com/shinkabb/mybb-weather-redux) and unzip in the root of your MyBB installation.

## Requirements

-   PHP version >= 5.3.0
-   See branch `lower-support` for an alternative that may work on lower versions. This branch is not thoroughly tested and is not guaranteed to be up to date.

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
$ git clone https://github.com/shinkabb/mybb-weather-redux.git
$ cd mybb-weather-redux

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
# Run only weather-redux tests
$ ./shinka.sh test path/to/mybb/root -d path/to/mybb/root/inc/plugins/Shinka/weather-redux
# Run specific tests
$ ./shinka.sh test path/to/mybb/root -d path/to/tests
```

#### Release

Versions should follow [Semantic Versioning standards](https://semver.org/).

```bash
$ shinka release --version 0.0.1-alpha.2
```
