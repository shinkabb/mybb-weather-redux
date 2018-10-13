#!/bin/sh

usage()
{
	echo "Usage: $0 <command>"
	echo
	echo "  test      Navigate to MyBB root and run PHPUnit tests."
}

test_usage()
{
	echo "Usage: $0 test <mybb_path> [-d <directory> | --directory <directory]"
	echo "Navigate to MyBB root and run PHPUnit tests."
	echo
	echo "  <mybb_path>                               Absolute path to MyBB installation"
	echo "  -d <directory, --directory <directory>    Path to tests"
}

test()
{
	CWD=$PWD
	MYBB_BASE=$1
	shift
	TEST_DIRECTORY="."

	while [[ $# -gt 0 ]]
	do
		case "$1" in
			-d | --directory)
				TEST_DIRECTORY=$2
				shift 2;;
			*)
				test_usage
				exit 1;;
		esac
	done

	if [ $MYBB_BASE ]
	then
		cd "$MYBB_BASE"
		phpunit $TEST_DIRECTORY --colors=always
		cd "$CWD"
	else
		test_usage
	fi	
}

case $1 in
	test)
		shift
		test $@
		break
		;;
	*)
		usage
		break
		;;
esac
