#!/bin/bash
# Daily dump of the CAT2 database, keeps 7 days
STAMP=$(date +%F)
mysqldump CAT2 | gzip > /var/backups/isproject1/CAT2-$STAMP.sql.gz
find /var/backups/isproject1 -name 'CAT2-*.sql.gz' -mtime +7 -delete
