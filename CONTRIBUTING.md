# Contributing

## Getting Started

If you prefer to set things up manually, be sure to have <a href="https://nodejs.org/en/">Node.js installed first</a>. You should be running a Node version matching the [current active LTS release](https://github.com/nodejs/Release#release-schedule) or newer for this plugin to work correctly. You can check your Node.js version by typing `node -v` in the Terminal prompt.

You should also have the latest release of <a href="https://npmjs.org">npm installed</a>, npm is a separate project from Node.js and is updated frequently. If you've just installed Node.js which includes a version of npm within the installation you most likely will need to also update your npm install. To update npm, type this into your terminal: `npm install npm@latest -g`

To test the plugin, or to contribute to it, you can clone this repository and build the plugin files using Node. How you do that depends on whether you're developing locally or uploading the plugin to a remote host.

### Local Environment

First, you need a WordPress Environment to run the plugin on. The quickest way to get up and running is to use the provided docker setup. Just install [docker](https://www.docker.com/) and [docker-compose](https://docs.docker.com/compose/) on your machine and run `./bin/setup-local-env.sh`.

The WordPress installation should be available at `http://localhost:8888` (username: `admin`, password: `password`).
Inside the "docker" directory, you can use any docker command to interact with your containers. If this port is in use, you can override it in your `docker-compose.override.yml` file.

Alternatively, you can use your own local WordPress environment and clone this repository right into your `wp-content/themes` directory.

Next, open a terminal (or if on Windows, a command prompt) and navigate to the repository you cloned. Now type `npm install` to get the dependencies all set up. Then you can type `npm run dev` in your terminal or command prompt to keep the plugin building in the background as you work on it.

### On A Remote Server

Open a terminal (or if on Windows, a command prompt) and navigate to the repository you cloned. Now type `npm install` to get the dependencies all set up. Once that finishes, you can type `npm run build`. You can now upload the entire repository to your `wp-content/themes` directory on your webserver and activate the theme from the WordPress admin.

You can also type `npm run package-theme` which will run the two commands above and create a zip file automatically for you which you can use to install the theme through the WordPress admin.

## Workflow

A good workflow for new contributors to follow is listed below:
- Fork the repository
- Clone forked repository
- Create new branch
- Make code changes
- Commit code changes within newly created branch
- Push branch to forked repository
- Submit Pull Request to `bigbox-theme` repository

Ideally name your branches with prefixes and descriptions, like this: `[type]/[change]`. A good prefix would be:

- `add/` = add a new feature
- `try/` = experimental feature, "tentatively add"
- `update/` = update an existing feature