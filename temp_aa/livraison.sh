#!/bin/sh
PASSWORD=$1;
USER=sirherbert
HOST=ftpperso.free.fr
REMOTE_DIRECTORY=/mountyhall/AA/
LOCAL_TEMPORARY_DIRECTORY=/tmp/

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/lib
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} lib

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/pub
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} pub

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/sql
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} sql

ncftpget -R -DD -u ${USER} -p ${PASSWORD} ${HOST} /tmp/ ${REMOTE_DIRECTORY}/web
ncftpput -R -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} web