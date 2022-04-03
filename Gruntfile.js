module.exports = function(grunt) {
    // dependencies
    let path = require('path');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');


    // Task configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        targetPath : 'build/MovieTheme', // output path for the theme
        srcPath: 'src', // Base path for source files

        sass: {
            build: {
                files: [{
                    expand: true,
                    cwd: '<%= srcPath %>/scss',
                    src: ['*.scss'],
                    dest: '<%= targetPath %>/',
                    ext: '.css'
                }]
            }
        },
        uglify: {
            build: {
                src: '<%= srcPath %>/js/*.js',
                dest: '<%= targetPath %>/js/scripts.min.js'
            }
        },
        copy: {
            build: {
                files: [{
                    expand: true,
                    cwd: '<%= srcPath %>',
                    src: ['*.php'],
                    dest: '<%= targetPath %>',
                },
                {
                    expand: true,
                    cwd: '<%= srcPath %>/vendor/font-awesome-4.7.0/fonts',
                    src: ['*'],
                    dest: '<%= targetPath %>/fonts',
                },
                {
                    expand: true,
                    cwd: '<%= srcPath %>/images',
                    src: ['*'],
                    dest: '<%= targetPath %>/images',
                }
                ]
            }
        },
        clean: {
            build: ['<%= targetPath %>/*']

        },
        watch: { // For convenience when developing
            files: '<%= srcPath %>/**/*',
            tasks: ['default']
        }
    });

    // Aggregate tasks as required
    grunt.registerTask('default', ['sass:build', 'uglify:build', 'copy:build']);
}