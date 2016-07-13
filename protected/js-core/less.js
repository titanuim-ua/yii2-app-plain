
var postcss = require("postcss");
var autoprefixer = require("autoprefixer");
var cli = require('cli');
var less = require('less');
var fs = require('fs');
var path = require('path');
require('es6-promise').polyfill();

var cleaner  = postcss([ autoprefixer({ add: false, browsers: ['> 1%', 'last 2 version'] }) ]);
var prefixer = postcss([ autoprefixer({ browsers: ['> 1%', 'last 2 version'] }) ]);

var lessFile = process.argv[2];

cli.withStdin("UTF-8", function(stdin){
    var data;
    if (lessFile=="-")
    {
       data = stdin;
    }
    else
    {
        lessFile = path.normalize(lessFile);
        data = fs.readFileSync(lessFile, "utf-8");
    }

    less.render(data,
        {
            paths: [path.dirname(lessFile)],  // Specify search paths for @import directives
            filename: path.basename(lessFile) // Specify a filename, for better error messages
            // compress: true          // Minify CSS output
        },
        function (e, out) {
            if (e) throw e;

            cleaner.process(out.css).then(function (out) {
                return prefixer.process(out.css)
            }).then(function (out) {
                process.stdout.write(out.css);
            });
        }
    );
});