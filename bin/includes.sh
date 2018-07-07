#!/bin/bash

##
# Checks if an array countains a particular value.
#
# @param {mixed} needle   The value to search for.
# @param {array} haystack The array to search.
#
# @return bool Whether the haystack contains the needle or not.
##
in_array() {
	local needle="$1";
	shift;
	local haystack=("$@");

	local item;

	for item in "${haystack[@]}"; do
		if [ "$item" == "${needle}" ]; then
			return 0;
		fi
	done

	return 1;
}

# Enable nicer messaging for build status.
BLUE_BOLD='\033[1;34m';
GREEN_BOLD='\033[1;32m';
RED_BOLD='\033[1;31m';
YELLOW_BOLD='\033[1;33m';
COLOR_RESET='\033[0m';

error () {
	echo -e "\n${RED_BOLD}$1${COLOR_RESET}\n"
}

status () {
	echo -e "\n${BLUE_BOLD}$1${COLOR_RESET}\n"
}

success () {
	echo -e "\n${GREEN_BOLD}$1${COLOR_RESET}\n"
}

warning () {
	echo -e "\n${YELLOW_BOLD}$1${COLOR_RESET}\n"
}
