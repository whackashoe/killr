<?php

class PastesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paste::create([
            'slug' => 'about',
            'code' => '
about killr.io
===

share code or get beat.



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



save that to killr.sh.

run chmod +x killr.sh

now do ./killr.sh ~/code/filetoshare

convenient eh?

'
        ]);

        Paste::create([
            'slug' => 'terms',
            'code' => "
terms of service
===

remember that one kid who thought he was funny but everyone thought he sucked
    don't be an older version of that

if you use this site nothing i have ever done is my fault and you will take full responsibility for all of it
    or at least as much as the courts will allow :)
"
        ]);

        for($i=0; $i<6; $i++) {
            $p = Paste::create([
                'slug' => strtolower(str_random(5)),
                'code' => strtolower(str_random(rand(100, 500)))
            ]);

            $this->tree($p->id);
        }
    }

    private function tree($id)
    {
        $r = rand(0, 100);

        while($r > 50) {
            $p = Paste::create([
                'parent_id' => $id,
                'slug' => strtolower(str_random(5)),
                'code' => strtolower(str_random(rand(100, 500)))
            ]);

            $this->tree($p->id);

            $r = rand(0, 100);
        }
    }
}
