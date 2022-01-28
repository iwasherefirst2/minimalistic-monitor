# Simple Monitoring Script

A minimalistic scripts to monitor if 
your server is alive and measures the request time for a given domain.

Requires SQLite to store results and curl to conduct requests.

## Installation

Make sure you have installed sqlite and curl for your current PHP version.
For example, for PHP 7.4 the install command would look like this:
```
    sudo apt-get install php7.4-sqlite
    sudo apt-get install php7.4-curl
```

Adjust configuration in `config.php` possible parameters are

Attribut | Description
--- | ---
url | The site you want to monitor
logFile | A log file to see if daemon still running
sleepDuration | Time between watch alive requests to your server
db | The SQLite databasename 

Next, create the SQLite database by running 

```
    php setup.php
```

## Running the watcher daemon

Simply run

```
    php monitor.php
```

this will watch until you stop the process.
