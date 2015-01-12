module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        watch: {
            files: [
                '**/*.js', 
                '**/*.css',
                '!public/build/*'
            ],
            tasks: ['default']
        },
        concat: {
        	dist: {
				src: [
                    'public/js/jquery.min.js',
                    'public/js/jquery.caret-1.5.2.js',
                    'public/js/highlight.pack.js',
                    'public/js/textarea-caret-position.js',
                    'public/js/interaction.js'
				],
				dest: 'public/build/scripts.js'
		    }
		},
        uglify: {
			build: {
     			src: 'public/build/scripts.js',
				dest: 'public/build/scripts.min.js'
    		}
        },
		concat_css: {
    		options: {},
			all: {
				src: [
					'public/css/hybrid.css',
                    'public/css/template.css'
				],
				dest: 'public/build/styles.css'
			},
		},
		cssmin: {
			minify: {
			    expand: true,
				cwd: 'public/build',
				src: ['styles.css'],
				dest: 'public/build',
				ext: '.min.css'
			}
		}
	});

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-concat-css');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify', 'concat_css', 'cssmin']);

};
