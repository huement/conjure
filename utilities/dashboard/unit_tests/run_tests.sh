#!/usr/bin/env bash

function docs {
	echo ""
	echo "More info: https://phpunit.de/manual/current/en/textui.html"
	echo ""
}

function menu {
	echo ""
	echo "-----[RUN PHPUNIT TEST]---------------- --------  -----   ----    ---     --      -"
	echo ""
}

function run_test {
	echo -e "\n$1 \nRunning command:\nphpunit $1 --coverage-html=unit_test_results --testdox-html=unit_test_results/dox.html --whitelist $2 \n\n"
	../vendor/bin/phpunit $1 $2 --coverage-html=unit_test_results --testdox-html=unit_test_results/dox.html --whitelist $3
}

menu

#run_test "ClassName" "FileName.php" "Test Directory"
run_test "WPTest" "WPTest.php" "./"

echo -e "\n\n"

docs
