#!/bin/sh

usage()
{
    echo usage: $0 '<http-user> <http-password>'
    exit 1
}

if test $# -ne 2
then
    usage
fi

HTTP_USER=$1
HTTP_PASSWORD=$2
REMOTE_HOST='slx0.dyndns.org'
WEB_SITE_URL="http://${REMOTE_HOST}/AA/web/"
WGET_COMMAND="wget --http-user=${HTTP_USER} --http-password=${HTTP_PASSWORD} ${WEB_SITE_URL}"
STOP_SITE_URL='stopSiteForMaintenance.php?activation_code=doubleZero'
RESTART_SITE_URL='restartSiteAfterMaintenance.php?activation_code=doubleZero'
UPDATE_PUBLIC_INFOS_URL=update_public_infos.php

${WGET_COMMAND}${STOP_SITE_URL}
${WGET_COMMAND}${UPDATE_PUBLIC_INFOS_URL}
${WGET_COMMAND}${RESTART_SITE_URL}

rm ${STOP_SITE_URL}
rm ${UPDATE_PUBLIC_INFOS_URL}
rm ${RESTART_SITE_URL}