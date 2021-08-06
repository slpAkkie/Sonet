'use strict'

const fs = require( 'fs' )

const gulp = require( 'gulp' )

const sassCompiler = require( 'gulp-sass' )( require( 'node-sass' ) )
const typescriptCompiler = require( 'gulp-typescript' )
const pug2html = require( 'gulp-pug' )
const BS = require( 'browser-sync' )

const config = {
  src: './src',
  dist: './dist',
  distAssets: './dist/assets',
}



function compilePug() {
  return gulp.src( config.src + '/pages/*.pug' )
    .pipe( pug2html( {
      pretty: true,
    } ) )
    .pipe( gulp.dest( config.dist ) )
}

function compileTypescript() {
  return gulp.src( config.src + '/ts/**/*.ts' )
    .pipe( typescriptCompiler( {
      target: 'es6'
    } ) )
    .pipe( gulp.dest( config.distAssets + '/js' ) )
}

function compileStyle() {
  return gulp.src( config.src + '/scss/main.scss' )
    .pipe( sassCompiler() )
    .pipe( gulp.dest( config.distAssets + '/css' ) )
}

function clear( cb ) {
  fs.rmSync( config.dist, {
    force: true,
    recursive: true,
  } )

  return cb()
}

function copyImages() {
  return gulp.src( config.src + '/img/*.*' )
    .pipe( gulp.dest( config.distAssets + '/img' ) )
}

function copyFonts() {
  return gulp.src( config.src + '/fonts/*.*' )
    .pipe( gulp.dest( config.distAssets + '/fonts' ) )
}


function copyStatic() {
  return gulp.src( config.src + '/static/**/*.*', { dot: true } )
    .pipe( gulp.dest( config.dist ) )
}

function watcher( cb ) {
  gulp.watch( config.src + '/scss/**/*.scss', compileStyle )
  gulp.watch( config.src + '/pages/**/*.pug', compilePug )
  gulp.watch( config.src + '/ts/**/*.ts', compileTypescript )
  gulp.watch( config.src + '/img/**/*.*', copyImages )
  gulp.watch( config.src + '/fonts/**/*.*', copyFonts )
  gulp.watch( config.src + '/static/**/*.*', copyStatic )

  return cb()
}

function serve( cb ) {
  BS.init( {
    files: './src/**/*.*',
    server: {
      baseDir: './dist'
    },
    watch: true,
    open: true,
    tunnel: null,
  } )

  return cb()
}



const build = gulp.parallel( clear, compilePug, compileStyle, compileTypescript, copyImages, copyFonts, copyStatic )



module.exports.serve = gulp.series( watcher, serve )
module.exports.build = build
module.exports.watcher = watcher
module.exports.dev = gulp.series( build, watcher, serve )
