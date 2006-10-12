#!/bin/sh
PASSWORD=$1;
USER=sirherbert
HOST=ftpperso.free.fr
REMOTE_DIRECTORY=/mountyhall/AA/
LOCAL_TEMPORARY_DIRECTORY=/tmp/

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/lib/*.php
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} lib/*.php

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/pub/*.txt
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} pub/*.txt

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/sql/*.sql
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} sql/*.sql

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web/*.php
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web/*.php

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web/css/*.css
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web/css/*.css

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web/js/*.js
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web/js/*.js

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web/images/*.jpg
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web/images/*.jpg

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web/images/*.gif
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web/images/*.gif

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web/smarty/templates/*.tpl
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web/smarty/templates/*.tpl