module.exports = function (grunt) {
    'use strict';
    // Project configuration
    grunt.initConfig({
        // Metadata
        pkg: grunt.file.readJSON('package.json'),
        // Task configuration
        concat: {
            options: {
                banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
                    '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
                    '<%= pkg.repository ? "* " + pkg.repository + "\\n" : "" %>' +
                    '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author %>;' +
                    ' Licensed <%= pkg.license %> */\n',
                stripBanners: true
            },
            dist: {
                src: ['assets/js/presscraft-dashboard.js'],
                dest: 'dist/presscraft-dashboard.js'
            },
            jsdist: {
                src: ['assets/js/weather-widget.js','assets/js/chartist.min.js','assets/js/bootstrap-checkbox-radio.js','assets/js/bootstrap-notify.js'],
                dest: 'dist/dash-libs.js'
            },
            cssdist: {
                src: ['assets/css/bootstrap.min.css','assets/css/animate.min.css','assets/css/themify-icons.css','assets/css/bloodcrowl.css','assets/css/knightsquest.css'],
                dest: 'dist/dash-libs.css'
            }
        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
                    '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
                    '<%= pkg.repository ? "* " + pkg.repository + "\\n" : "" %>' +
                    '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author %>;' +
                    ' Licensed <%= pkg.license %> */\n',
            },
            dist: {
                src: 'assets/js/presscraft-dashboard.js',
                dest: 'dist/dash.min.js'
            }
        },
        jshint: {
            options: {
                node: true,
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                unused: true,
                eqnull: true,
                browser: true,
                globals: { jQuery: true },
                boss: true
            },
            gruntfile: {
                src: 'gruntfile.js'
            },
            lib_test: {
                src: ['lib/**/*.js', 'test/**/*.js']
            }
        },
        sass: {                              // Task
          dist: {                            // Target
            files: {                         // Dictionary of files
              'dist/dash.css': 'assets/sass/paper-dashboard.scss'
            }
          }
        },
        qunit: {
            files: ['test/**/*.html']
        },
        watch: {
            gruntfile: {
                files: '<%= jshint.gruntfile.src %>',
                tasks: ['jshint:gruntfile']
            },
            lib_test: {
                files: '<%= jshint.lib_test.src %>',
                tasks: ['jshint:lib_test', 'qunit']
            }
        }
    });

    // These plugins provide necessary tasks
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');

    // Default task
    grunt.registerTask('default', ['jshint', 'qunit', 'concat', 'uglify', 'sass']);
};