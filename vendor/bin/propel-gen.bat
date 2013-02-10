#!/usr/bin/env sh
SRC_DIR="`pwd`"
cd "`dirname "$0"`"
cd '../propel/propel1/generator/bin'
BIN_TARGET="`pwd`/propel-gen.bat"
cd "$SRC_DIR"
"$BIN_TARGET" "$@"
