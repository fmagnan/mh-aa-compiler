#!/bin/sh

PASSWORD=$1
ROOT_DIRECTORY=/mountyhall/AA/

./ncftpreplace.sh ${PASSWORD} "etc/settings.inc.php" ${ROOT_DIRECTORY}etc
./ncftpreplace.sh ${PASSWORD} "etc/constants.inc.php" ${ROOT_DIRECTORY}etc
./ncftpreplace.sh ${PASSWORD} "lib/*.php" ${ROOT_DIRECTORY}lib
./ncftpreplace.sh ${PASSWORD} "sql/*.sql" ${ROOT_DIRECTORY}sql
./ncftpreplace.sh ${PASSWORD} "web/*.php" ${ROOT_DIRECTORY}web
./ncftpreplace.sh ${PASSWORD} "web/.htaccess" ${ROOT_DIRECTORY}web
./ncftpreplace.sh ${PASSWORD} "web/css/*.css" ${ROOT_DIRECTORY}web/css
./ncftpreplace.sh ${PASSWORD} "web/images/*.*" ${ROOT_DIRECTORY}web/images
./ncftpreplace.sh ${PASSWORD} "web/js/*.js" ${ROOT_DIRECTORY}web/js
./ncftpreplace.sh ${PASSWORD} "web/smarty/templates/*.tpl" ${ROOT_DIRECTORY}web/smarty/templates