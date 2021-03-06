
module.exports = function (grunt) {
    'use strict';

    function bowerJson() {
        require('bower-json').validate(require('./bower.json'));
    }

    grunt.initConfig({
        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            all: [
                'Gruntfile.js',
                'js/cors/*.js',
                'js/*.js',
                'server/node/server.js',
                'test/test.js'
            ]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-bump-build-git');
    grunt.registerTask('bower-json', bowerJson);
    grunt.registerTask('test', ['jshint', 'bower-json']);
    grunt.registerTask('default', ['test']);

};
