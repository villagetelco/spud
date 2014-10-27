#!/bin/bash

ROOT=/var/www/spud


cat $ROOT/cron/crontab.spud >> /etc/crontab
cron restart