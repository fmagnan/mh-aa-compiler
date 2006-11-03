#!/bin/sh

USER=admin@sirherbert.byethost32.com
HOST=206.222.15.234
PASSWORD=$1
LOCAL_FILES=$2
REMOTE_DIRECTORY=$3

for i in `ls $2`
do
	ncftpput -m -u ${USER} -p ${PASSWORD} ${HOST} ${REMOTE_DIRECTORY} ${i}
done