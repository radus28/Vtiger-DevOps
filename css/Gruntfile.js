module.exports = function(grunt) {

    // Project configuration
    grunt.initConfig({
        less: {
            development: {
                options: {
                    paths: ['less']
                },
                files: {
                    '../marketing/style.css': 'style.less',
                    '../sales/style.css': 'style.less'
                }
            }
        }
    });

    // Load the plugins
    grunt.loadNpmTasks('grunt-contrib-less');

    // Default task(s)
    grunt.registerTask('default', ['less']);

};
