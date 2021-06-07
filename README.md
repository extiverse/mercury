# Mercury

The smallest planet in our solar system is a great example that small things can have great meaning. Mercury  stands closest to our sun and orbits the sun in the least days. It is like a satellite constantly watching over the sun.

This extension helps you keep your Flarum community better updated. I have more plans for it and willing to listen to incorporate your suggestions, but right now it:

- shows a button in the admin area with the number of available updates to your extensions
- contains an admin page listing all your extensions and whether they have newer versions available
- offers a cronjob/scheduled command that can check for updates in your absence
- can send an email to all admins whenever it finds any updates

### Requirements

Sorry people, this extension is **only for systems running php 7.4 or higher**. 
Not being able to use all type hints made me go bald.

### Installation

```bash
composer require extiverse/mercury:*
```

Go to your admin area and enable the extension. Follow the link on the Mercury page to retrieve an Extiverse API token. Without a token this extension does not work.

### Command

Run the command in your ssh/terminal/cli if you want a quick overview of whether extensions have updates:

```bash
php flarum mercury:update-check
```

### Cronjob

This extension does not automatically register itself (yet) to the Flarum scheduler. I've chosen against it so that you can configure your own interval; I recommend checking less than once a day.

The command to schedule is:

```bash
php flarum mercury:update-check --notify
```

If you drop the `--notify` flag no notifications are send to admins.

This [excellent discussion](https://discuss.flarum.org/d/24118) by Ian Morland will help you set up your cronjob. Instead of using the command `schedule:run` use `mercury:update-check --notify`.

### Links

- [GitHub](https://github.com/extiverse/mercury)
- [Extiverse](https://extiverse.com)

[![](https://extiverse.com/extiverse/mercury/open-graph-image)](https://extiverse.com/extiverse/mercury)
