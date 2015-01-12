#!/bin/bash

# killr.sh

# INSTALL
# save this file as killr.sh
# sudo cp killr.sh /usr/local/bin/killr

# USAGE
# echo "lol" | killr
# killr ~/somefile


stdin="$(ls -l /proc/self/fd/0)"
stdin="${stdin/*-> /}"

if [[ "$stdin" =~ ^/dev/pts/[0-9] ]]; then
    if [ $# -eq 0 ]
        then
            echo "No filename supplied"
    else
        curl -X POST --data-binary @$1 https://killr.io
    fi
else
    curl -X POST --data-binary  @- https://killr.io
fi