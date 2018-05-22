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

##
# Enable nicer messaging.
##
YELLOW_BOLD='\033[1;33m';
COLOR_RESET='\033[0m';

status () {
	echo -e "\n${YELLOW_BOLD}$1${COLOR_RESET}\n"
}
