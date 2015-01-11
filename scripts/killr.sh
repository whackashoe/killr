#!/bin/bash
stdin="$(ls -l /proc/self/fd/0)"
stdin="${stdin/*-> /}"

if [[ "$stdin" =~ ^/dev/pts/[0-9] ]]; then
    if [ $# -eq 0 ]
        then
            echo "No filename supplied"
    else
        curl -X POST --data-binary @$1 http://killr.io
    fi
else
    curl -X POST --data-binary  @- http://killr.io
fi
