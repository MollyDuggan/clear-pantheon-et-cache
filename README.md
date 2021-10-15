# clear-pantheon-et-cache
The fastest way to clear the et-cache folder typically located at Pantheon~/files/uploads/et-cache.

### What it does?
This project is designed to delete contents of the et-cache folder.
It depends on __grunt__ to create a fast and well organized working environment. It's super easy to use and to setup.

---

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

Go inside the project folder and install his dependencies by typing:

```bash
npm install
```

Than you can start to write your changes using some npm scripts:

```bash
npm run start     # default task is to watch and rebuild on changes
npm run build     # build task will compile and rebuild everything
```
