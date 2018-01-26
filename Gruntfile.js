/*
 * grunt-md2html
 * https://github.com/bylexus/grunt-md2html
 *
 * Copyright (c) 2013 Alexander Schenkel
 * Licensed under the MIT license.
 */

'use strict';

module.exports = function(grunt) {
    var path = require('path');

  /** ---------  [ SET CONFIGS ]  --------- **/
	var ENV    = grunt.file.readJSON( "_taskrunner/config/env.json" );
	var PKDATA = grunt.file.readJSON( "package.json" );
	var DIRS   = PKDATA.directories;

	/** ---------  [ GRUNT SETUP ]  --------- **/
	var GCmd         = require( path.join(process.cwd(), "_taskrunner/config/functions.js"));
	var GTasks       = GCmd.initConfigs(grunt, DIRS.grunt_menu_tasks);
	grunt.log.header = GCmd.logger(grunt);

  var CFGDATA =
  {
  	time      : Math.floor(Date.now() / 1000),
  	taskList  : GTasks,
  	directory : DIRS,
  	env       : ENV,
  	taskDir   : DIRS.grunt_tasks,
  	questDir  : DIRS.grunt_quests,
  	menuFile  : DIRS.grunt_menu
  };

	grunt.option("info", CFGDATA);
	grunt.loadNpmTasks("grunt-notify");

  // Project configuration.
  require("load-grunt-config")(grunt, {
		// path to task.js files, defaults to grunt dir
		configPath : path.join(process.cwd(), DIRS.grunt_tasks),
		// auto grunt.initConfig
		init       : true,
		// data passed into config. Can use with <%= test %>
		data       : CFGDATA,
		pkg        : PKDATA,
		jitGrunt   : {
      staticMappings : {
        asciify               : 'grunt-asciify-color',
        availabletasks        : 'grunt-available-tasks',
        browserSync           : 'grunt-browser-sync',
        connect               : 'grunt-contrib-connect',
        usebanner             : 'grunt-banner',
        watch                 : 'grunt-contrib-watch',
        changelogcustomizable : 'grunt-changelog-customizable',
        concat                : 'grunt-contrib-concat',
        copy                  : 'grunt-contrib-copy',
        postcss               : 'grunt-postcss',
        sass                  : 'grunt-contrib-sass',
        webpack               : 'grunt-webpack',
        md2html               : 'grunt-md2html',
        twigRender            : 'grunt-twig-render',
        markdownit            : 'grunt-markdown-it',
        handlebars            : 'grunt-compile-handlebars'
      }
    },
		// optionall add another task dir:
		//customTasksDir : PKDATA.questDir
	});

  // // Actually load this plugin's task(s).
  //grunt.loadTasks('tasks');
  //
  // // These plugins provide necessary tasks.
  // grunt.loadNpmTasks('grunt-contrib-jshint');
  // grunt.loadNpmTasks('grunt-contrib-clean');
  // grunt.loadNpmTasks('grunt-contrib-nodeunit');
  //
  // // Whenever the "test" task is run, first clean the "tmp" dir, then run this
  // // plugin's task(s), then test the result.
  // grunt.registerTask('test', ['clean', 'md2html', 'nodeunit']);

  // By default, lint and run all tests.
  grunt.registerTask('default', ['asciify:banner']);
  grunt.registerTask('docs', ['md2html']);
  grunt.registerTask('mddoc', ['asciify:banner','markdownit']);

};
