#!/bin/bash
###############################################################################
# Assemble the directory with MediaWiki
# Usage: ./build_mediawiki REL1_31
###############################################################################

branch=$1

GITCLONE_OPTS="--depth 1 --recursive -b $branch"

mkdir -p buildcache/mediawiki

if [ ! -f buildcache/mediawiki/COMPLETE ]; then
	(
		cd buildcache
		rm -rf mediawiki
		git clone $GITCLONE_OPTS https://gerrit.wikimedia.org/r/p/mediawiki/core.git mediawiki -b "$branch"

		for EXT in AbuseFilter CheckUser MobileFrontend VisualEditor
		do
			git clone $GITCLONE_OPTS \
				https://gerrit.wikimedia.org/r/p/mediawiki/extensions/$EXT.git \
				mediawiki/extensions/$EXT
		done

		cd mediawiki
		patch -p1 <../../patches/gerrit440976.patch

		[[ -f includes/DevelopmentSettings.php ]] || \
			wget https://raw.githubusercontent.com/wikimedia/mediawiki/master/includes/DevelopmentSettings.php \
				-O includes/DevelopmentSettings.php

		composer install --prefer-dist --quiet --no-interaction
		touch COMPLETE # Mark this buildcache as usable
	)
fi

cp -r buildcache/mediawiki ./
