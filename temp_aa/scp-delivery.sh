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
REMOTE_ROOT_FOLDER='/var/www/AA/'
REMOTE_USER='herb'
WEB_SITE_URL="http://${REMOTE_HOST}/AA/web/"
WGET_COMMAND="wget --http-user=${HTTP_USER} --http-password=${HTTP_PASSWORD} ${WEB_SITE_URL}"
STOP_SITE_URL='stopSiteForMaintenance.php?activation_code=doubleZero'
RESTART_SITE_URL='restartSiteAfterMaintenance.php?activation_code=doubleZero'

${WGET_COMMAND}${STOP_SITE_URL}

scp etc/settings.inc.php ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}etc
scp etc/constants.inc.php ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}etc
scp lib/*.php ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}lib
scp sql/*.sql ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}sql
scp web/*.php ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}web
scp web/css/*.css ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}web/css
scp web/images/*.* ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}web/images
scp web/js/*.js ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}web/js
scp web/smarty/templates/*.tpl ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_ROOT_FOLDER}web/smarty/templates

${WGET_COMMAND}${RESTART_SITE_URL}

rm ${STOP_SITE_URL}
rm ${RESTART_SITE_URL}