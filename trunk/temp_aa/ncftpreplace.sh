#!/bin/sh

USER=sirherbert
HOST=ftpperso.free.fr
PASSWORD=$1
LOCAL_FILES=$2
REMOTE_DIRECTORY=$3

for i in `ls $2`
do
	ncftpput -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} ${i}
done