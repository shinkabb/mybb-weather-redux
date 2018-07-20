#!/bin/sh

link_usage()
{
	echo "Usage: $0 link <mybb_path>"
	echo "Create symbolic links for plugin files and directories."
	echo
	echo "  <mybb_path>    Absolute path to MyBB installation"
}

unlink_usage()
{
	echo "Usage: $0 unlink <mybb_path>"
	echo "Destroy symbolic links for plugin files and directories."
	echo
	echo "  <mybb_path>    Absolute path to MyBB installation"
}

release_usage()
{
	echo "Usage: $0 release [-v <version> | --version <version>] [-V <vendor> | --vendor <vendor>] [-c <code> | --code <code>]"
	echo "Bundle source files for release."
	echo
	echo "  -v <version>, --version <version>     Semantic version"
	echo "                                        default: 1.0.0"
	echo "  -V <vendor>, --vendor <vendor>        Plugin vendor name"
	echo "                                        default: shinka"
	echo "  -c <code>, --code <code>              Plugin code name"
	echo "                                        default: news"
}

test_usage()
{
	echo "Usage: $0 test <mybb_path> [-d <directory> | --directory <directory]"
	echo "Navigate to MyBB root and run PHPUnit tests."
	echo
	echo "  <mybb_path>                               Absolute path to MyBB installation"
	echo "  -d <directory, --directory <directory>    Path to tests"
}

make_symlinks()
{
	MYBB_BASE=""
	FORCE=""
	while [[ $# -gt 0 ]]
	do
		case "$1" in
			-f | --force)
				FORCE="-f"
				shift;;
			*)
				MYBB_BASE=$1
				shift;;
		esac
	done

	if [ $MYBB_BASE ]
	then
		ln -s $FORCE "$PWD/src/news.php" "$MYBB_BASE/news.php" 
		echo "Linked news.php"
		
		ln -s $FORCE "$PWD/src/inc/plugins/news.php" "$MYBB_BASE/inc/plugins/news.php"
		echo "Linked inc/plugins/news.php"
		
		ln -s $FORCE "$PWD/src/inc/languages/english/news.lang.php" "$MYBB_BASE/inc/languages/english/news.lang.php"
		echo "Linked inc/languages/news.lang.php"
		
		ln -s $FORCE "$PWD/src/inc/languages/english/admin/news.lang.php" "$MYBB_BASE/inc/languages/english/admin/news.lang.php"
		echo "Linked inc/languages/english/admin/news.lang.php"
		
		ln -s $FORCE "$PWD/src/inc/plugins/MybbStuff" "$MYBB_BASE/inc/plugins/MybbStuff"
		echo "Linked inc/plugins/MybbStuff"
		
		ln -s $FORCE "$PWD/src/inc/plugins/Shinka" "$MYBB_BASE/inc/plugins/Shinka"
		echo "Linked inc/plugins/Shinka"
	else
		link_usage
	fi	
}

destroy_symlinks()
{
	MYBB_BASE=$1;
	if [ $1 ]
	then
		rm "$MYBB_BASE/news.php"
		echo "Unlinked news.php"
		
		rm "$MYBB_BASE/inc/plugins/news.php"
		echo "Unlinked inc/plugins/news.php"
		
		rm "$MYBB_BASE/inc/languages/english/news.lang.php"
		echo "Unlinked inc/languages/english/news.lang.php"
		
		rm "$MYBB_BASE/inc/languages/english/admin/news.lang.php"
		echo "Unlinked inc/languages/english/admin/news.lang.php"
		
		rm -R "$MYBB_BASE/inc/plugins/MybbStuff/"
		echo "Unlinked inc/plugins/MybbStuff/"
		
		rm -R "$MYBB_BASE/inc/plugins/Shinka/"
		echo "Unlinked inc/plugins/Shinka/"
	else
		unlink_usage
	fi	
}

release()
{
	VERSION="1.0.0"
	VENDOR="shinka"
	CODE="news"
    while [[ $# -gt 0 ]]
	do
		case "$1" in
			-v | --version)
				VERSION=$2
				shift 2;;
			-V | --vendor)
				VENDOR=$2
				shift 2;;
			-c | --code)
				CODE=$2
				shift 2;;
			*)
				release_usage
				exit 1;;
		esac
	done

	bundle $VENDOR $CODE $VERSION
}

bundle()
{
	git archive HEAD:src --format zip -o "$1-$2-$3.zip"
	echo "Release bundled in $1-$2-$3.zip"
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
	link)
		make_symlinks $@
		break
		;;
	unlink)
		destroy_symlinks $2
		break
		;;
	relink)
		destroy_symlinks $2
		make_symlinks $2
		break
		;;
	test)
		shift
		test $@
		break
		;;
	release)
		release $@
		break
		;;
	*)
		echo "Sorry, I don't understand"
		break
		;;
esac
