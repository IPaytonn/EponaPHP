#!/bin/bash
DIR="$(cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"
cd "$DIR"
if [ -f ./bin/php5/bin/php ]; then
	exec ./bin/php5/bin/php -d enable_dl=On EponaPHP.php $@
else
	echo "Please use the correct PHP bianaries."
	exec php -d enable_dl=On EponaPHP.php $@
fi