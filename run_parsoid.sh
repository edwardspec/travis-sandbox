#!/bin/bash
###############################################################################
# Download and start Parsoid.
# Usage: ./run_parsoid REL1_31
# (where REL1_31 is the branch of MediaWiki)
###############################################################################

branch=$1
GITCLONE_OPTS="--recurse-submodules -j 5"

if [ "$branch" != "REL1_27" ]; then
	# See below, REL1_27 can't use --depth 1,
	# because it would need to revert Parsoid to older revision.
	GITCLONE_OPTS="--depth 1 $GITCLONE_OPTS"
fi

if [ ! -f parsoid/COMPLETE ]; then
	rm -rf parsoid
	git clone $GITCLONE_OPTS https://gerrit.wikimedia.org/r/p/mediawiki/services/parsoid

	(
		cd parsoid

		if [ "$branch" = "REL1_27" ]; then
			# Legacy MediaWiki 1.27 doesn't support latest Parsoid.
			# Revert Parsoid to the supported version.
			git checkout v0.8.1
		fi

		npm install
		ln -s . src # "npm start" tries to run src/lib/index.js, which is actually lib/index.js
	)

	touch parsoid/COMPLETE
fi

cp config.yaml parsoid/
cd parsoid && ( PORT=8142 npm start >$TRAVIS_BUILD_DIR/parsoid.log & ) && cd -
