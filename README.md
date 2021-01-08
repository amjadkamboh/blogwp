### Features
- Automatic SASS conversion to CSS when you save the file.
- Automatically adds the prefixes to your CSS for cross-browser compatibility.
- Lets you write modern JavaScript and generates browser-compatible JavaScript.
- Automatically minifies CSS/JS files.
- Automatically Optimizes the images.
- Automatically reloads your browser if you make changes in the code.
- Maintains strict code quality checks. you will see error messages if your code doesn't follow the code guide lines recommended by WordPress


### Prerequisites
 - nodejs
 - yarn
 - Composer
 - VSCode
 - Git

### Installation Instructions
Install nodejs dependencies: `yarn install`
Install PHP dependencies: `composer install`

### Configuration
Add your local WordPress URL to [gulpfile](https://github.com/ams-engineering/theme-boilerplate/blob/main/gulpfile.js#L21).

### Development
Run `yarn start` to start the project.
 - Write all your css in `src/scss/`, you can have as many scss files as you want and they will be automatically merged into one, converted it to this css, and minified. 
 - Write all your JavaScript in `src/js/`, you can have as many js files as you want and they will be automatically merged into one, and minified.
 - Put all your images in `src/img/` and they will be automatically optimized and moved to `images` directory.
