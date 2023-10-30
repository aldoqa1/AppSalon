//modules
const {src, dest, watch, parallel} = require("gulp");
const sassV = require("gulp-sass")(require("sass"));
const plumberV = require("gulp-plumber");

//images
const avifV = require("gulp-avif");
const webpV = require("gulp-webp");
const cacheV = require("gulp-cache");
const imageminV = require("gulp-imagemin");

//function
function css(done){

    src("./src/scss/**/*.scss")
    .pipe(plumberV())
    .pipe(sassV())
    .pipe(dest("./public/build/css"));

    done();
}

function js(done){

    src("./src/js/**/*.js")
    .pipe(plumberV())
    .pipe(dest("./public/build/js"));

    done();
}

function images(done){

    quality = {
        quality : 50
    }

    optimization = {
        optimizationLevel : 3
    }

    src("./src/img/**/*.{jpg,jpeg,png}")
    .pipe(plumberV())
    .pipe(webpV(quality))
    .pipe(dest("./public/build/img"));

    src("./src/img/**/*.{jpg,jpeg,png}")
    .pipe(plumberV())
    .pipe(avifV(quality))
    .pipe(dest("./public/build/img"));

    src("./src/img/**/*.{jpg,jpeg,png}")
    .pipe(plumberV())
    .pipe(cacheV(imageminV(optimization)))
    .pipe(dest("./public/build/img"));

    done();
}

function dev(done){
    watch("./src/scss/**/*.scss", css);
    watch("./src/js/**/*.js", js);
    done();
}

//exports

//exports.DEV = parallel(dev, images);
exports.build = parallel(images, js, css);