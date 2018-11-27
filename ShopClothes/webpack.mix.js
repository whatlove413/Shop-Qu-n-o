let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/mix/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/mix/global/plugins/simple-line-icons/simple-line-icons.min.css',
    'resources/assets/mix/global/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/mix/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    'resources/assets/mix/global/plugins/select2/css/select2.min.css',
    'resources/assets/mix/global/plugins/select2/css/select2-bootstrap.min.css',
    'resources/assets/mix/global/css/components.min.css',
    'resources/assets/mix/global/css/plugins.min.css',
    'resources/assets/mix/pages/css/login.min.css',
    'resources/assets/mix/layouts/layout/css/layout.min.css',
    'resources/assets/mix/layouts/layout/css/themes/darkblue.min.css',
    'resources/assets/mix/layouts/layout/css/custom.min.css',
    'resources/assets/mix/different/css/googleFont.css',
    'resources/assets/mix/pages/css/error.min.css',
    'resources/assets/mix/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
    'resources/assets/mix/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css',
    'resources/assets/mix/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css',
    'resources/assets/sass/admin.css',
], 'public/css/all.css');

mix.scripts([
    'resources/assets/mix/global/plugins/jquery.min.js',
    'resources/assets/mix/global/plugins/bootstrap/js/bootstrap.min.js',
    'resources/assets/mix/global/plugins/js.cookie.min.js',
    'resources/assets/mix/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
    'resources/assets/mix/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
    'resources/assets/mix/global/plugins/jquery.blockui.min.js',
    'resources/assets/mix/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
    'resources/assets/mix/global/plugins/jquery-validation/js/jquery.validate.min.js',
    'resources/assets/mix/global/plugins/jquery-validation/js/additional-methods.min.js',
    'resources/assets/mix/global/plugins/select2/js/select2.full.min.js',
    'resources/assets/mix/global/scripts/app.min.js',
    'resources/assets/mix/pages/scripts/login.min.js',
    'resources/assets/mix/layouts/layout/scripts/layout.min.js',
    'resources/assets/mix/layouts/layout/scripts/demo.min.js',
    'resources/assets/mix/layouts/global/scripts/quick-sidebar.min.js',
    'resources/assets/mix/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
    'resources/assets/mix/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js',
    'resources/assets/mix/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js',
    'resources/assets/mix/global/plugins/ckeditor/ckeditor.js',
    'resources/assets/mix/global/plugins/bootstrap-markdown/lib/markdown.js',
    'resources/assets/mix/pages/scripts/form-validation.min.js',
    'resources/assets/mix/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js',
    'resources/assets/mix/pages/scripts/ui-bootstrap-growl.min.js',
    'resources/assets/js/admin.js',
], 'public/js/all.js');

mix.copy([
    'resources/assets/mix/layouts/layout/img/**/*',
], 'public/img/all').version();

mix.copy([
    'resources/assets/mix/img/**/*',
], 'public/img').version();

mix.copy([
    'resources/assets/mix/different/icon_image/**/*',
], 'public/').version();

mix.copy([
    'resources/assets/mix/different/icon_fonts/**/*',
], 'public/fonts').version();

mix.copy([
    'resources/assets/mix/different/icon_fonts/**/*',
], 'public/css/fonts').version();

