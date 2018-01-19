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
          widgets: {
              src: ['assets/js/dashboard-widgets.js'],
              dest: 'dist/widgets.js'
          },
          jsdist: {
              src: ['assets/js/tether.js', 'assets/js/chartist.min.js'],
              dest: 'dist/dash-libs.js'
          },
          graphs: {
              src: ['assets/js/morris.js'],
              dest: 'dist/graph-libs.js'
          },
          bslibs: {
              src: ['assets/js/bootstrap-checkbox-radio.js', 'assets/js/bootstrap-notify.js'],
              dest: 'dist/bs-libs.js'
          },
          cssdist: {
              src: ['assets/css/bootstrap.css', 'assets/css/animate.min.css', 'assets/css/themify-icons.css', 'assets/css/font-awesome.css'],
              dest: 'dist/libraries.css'
          },
          cssextra: {
              src: ['assets/css/paper-dash-extras.css', 'assets/css/widgets.css', 'morris.css'],
              dest: 'dist/widgets.css'
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
                src: 'Gruntfile.js'
            },
            lib_test: {
                src: ['assets/js/chart_data.js','assets/js/dashboard-widgets.js']
            }
        },
        sass: {                              // Task
          dist: {                            // Target
            files: {                         // Dictionary of files
              'dist/dash.css': ['assets/sass/paper-dashboard.scss']
            }
          }
        },
        qunit: {
            files: ['test/**/*.html']
        },
        wpcss: {
            target: {
                options: {
                    commentSpacing: true,    // Whether to clean up newlines around comments between CSS rules.
                    config: 'alphabetical',  // Which CSSComb config to use for sorting properties.
                },
                files: {
                  'assets/css/widgets.css' : ['assets/css/widgets.css'],
                  'assets/css/paper-dash-extras.css' : ['assets/css/paper-dash-extras.css'],
                  'assets/css/morris.css' : ['assets/css/morris.css']
                }
            }
        },
        watch: {
            gruntfile: {
                files: '<%= jshint.gruntfile.src %>',
                tasks: ['jshint:gruntfile']
            },
            dashboard: {
                files: [ 'Gruntfile.js', 'assets/js/*.js', 'assets/css/*.css', 'assets/sass/paper/*.scss', 'assets/sass/paper/mixins/*.scss' ],
                tasks: ['uglify', 'sass', 'concat']
            }
        },
        uglify: {
          options: {
            banner: "/*! <%= pkg.name %> - v<%= pkg.version %> */"
          },
          dist: {
            src: ["dist/widgets.js",],
            dest: "dist/grunt.min.js"
          }
        }
    });

    // These plugins provide necessary tasks dist/graph.min.js'
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-wp-css');

    // stylestats: {
    //   options: {
    //     "size": true,
    //     "gzippedSize": false,
    //     "simplicity": true,
    //     "rules": true,
    //     "selectors": true,
    //     "lowestCohesion": true,
    //     "lowestCohesionSelector": true,
    //     "totalUniqueFontSizes": true,
    //     "uniqueFontSize": true,
    //     "totalUniqueColors": true,
    //     "uniqueColor": true,
    //     "idSelectors": true,
    //     "universalSelectors": true,
    //     "importantKeywords": true,
    //     "mediaQueries": true,
    //     "propertiesCount": 10,
    //     "prettify": true
    //   },
    //   myriad: [
    //     '/home/vagrant/code/myriad/wp-content/themes/myriad/mobile.css',
    //     '/home/vagrant/code/myriad/wp-content/themes/myriad/style.css',
    //     '/home/vagrant/code/myriad/wp-content/themes/myriad/mike.css'
    //   ]
    // }
    //grunt.loadNpmTasks('grunt-stylestats');

    // Default task
    grunt.registerTask('default', ['uglify', 'sass', 'wpcss', 'concat']);
};
