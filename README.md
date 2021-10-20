# clear-pantheon-et-cache
The fastest way to clear the et-cache folder typically located at Pantheon `~/files/et-cache`. Note: Pantheon's `~/files` folder is an aliasfor `~/wp-content/uploads`.

### What it does?
This project is designed to delete contents of the et-cache folder.
It depends on __grunt__ to create a fast and well organized working environment. It's super easy to use and to setup.

---

### Why would you want to use this plugin?
It's a last resort when you've tried the following tests and you're still not seeing results or if you just want a precise visual way to clear the et-cache folder.

+ Disable **Dynamic CSS** at **Divi** > **Theme Options** > **General** > **Performance** and click to disable Dynamic CSS.
+ Be sure that your Divi parent theme is using the latest version. **Appearance** > **Themes**.
+ Go to [Pantheon WordPress Plugins and Themes with Known Issues](https://pantheon.io/docs/plugins-known-issues) for [Divi WordPress Theme & Visual Page Builder](https://pantheon.io/docs/plugins-known-issues#divi-wordpress-theme--visual-page-builder) issues and follow Issue #1 > Solution #1 and #2, and Issue #2 > Solution(first solution). 
+ **Important**: You must create a [symlink for et-cache](https://pantheon.io/docs/plugins-known-issues#divi-wordpress-theme--visual-page-builder) for this to work. This is noted in the task above from Pantheon Issue #1 - Solution #2.1. 
```
$ cd wp-content
$ ln -s ./uploads/et-cache ./et-cache
```
+ Added the following lines to the Divi-child theme functions.php. 
```php
function change_frequency_of_heartbeat_settings($settings)
{
   $settings['interval'] = 100; //Anything between 15-120
   return $settings;
}
add_filter('heartbeat_settings', 'change_frequency_of_heartbeat_settings');
```
+ Added the following lines to ~/wp-config.php
```php
define('WP_CACHE', true);
set_time_limit(1500);
// Disable divi cache with et-cache
define('ET_BUILDER_CACHE_MODULES', false);
```
+ 
+ Be sure that **Static CSS File Generation** is disabled at **Divi** > **Theme Options** > **Builder** > **Advanced**.

### Getting started
+ Type `npm install && npm run start`

Then you are ready to go!

---

### Structure
```
├── assets
│   ├── dist
│   │   ├── css
│   │   └── js
│   └── src
│       ├── js
│       │   ├── admin-script.js
│       │   └── user-script.js
│       └── scss
│           ├── admin-style.scss
│           └── user-style.scss
├── include
│   └── main-class.php
├── languages
│   └── clear-pantheon-et-cache.pot
├── Gruntfile.js
├── package.json
├── README.md
└── clear-pantheon-et-cache.php

9 directories, 10 files
```

---

### How does it works?
All your plugin related files are located in `assets/src` folder.
While in watch mode all the files in `assets/src` folder and sub-folders will be compiled, uglified and saved in the `assets/dist` folder with the same name of the source file and following the same folder structure.

---

### Development

Go inside the project folder and install dependencies by typing:

```bash
npm install
```

Than you can start to write your changes using some npm scripts:

```bash
npm run start     # default task is to watch and rebuild on changes
npm run build     # build task will compile and rebuild everything
```
