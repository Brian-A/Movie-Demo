# Project setup
- Clone/download this repo and then run `npm i`
- You'll need to add your TMDB API key to `functions.php`

# Building the project
- Once you've setup the project as above you can simply type either `grunt` for a one-off build or `grunt watch` if you want the project to build on file change. This will output the theme files to the build directory. You can change this path by altering `targetPath` in Gruntfile.js (via `grunt.initConfig`'s configuration object).

# Note of caution
- Be careful running `grunt clean` as it will blow away everything in `targetPath`

# WordPress setup
- Install WordPress as per normal
  - Copy the folder `MovieTheme` into `wp-content/themes` 
  - Activate `Movie Theme` theme `via Appearance > Themes`
  - Create a page called `Movies` and set its page template to `Movie Listing`
  - Create a page called `Movie` and set its page template to `Singular Movie page`
  - Go to Settings > Reading and set `Your homepage displays` to `A static page` and select `Movies` as the homepage, leave Posts page unset.


        

