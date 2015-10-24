# yii-phing-deploy
This is my phing config to deploy yii-1.1.* apps

It uses simple scenario:
- export last revision from git repo to "export" temp directory;
- override "export" directory content with files from "override" dirictory (some config.php files, or master view's with disabled debugging params);
- rsync "export" directory to remote server.

For export data from svn repository you may use simple `rm -R` and then `svn export` commands.
For git I use some strange at first (and second, and so one) look combination of `git fetch`, `git reset --hard`, `git pull` and `git submodule update --init --recursive` commands.

 - `git fetch` and `git reset --hard` command combination restores full content of export dir with data of last deploy (it  
deletes from export dir some fantom files, which sooner or later someone like me can create in it, and restore deleted files) so directory structure must be good. It's like local `svn export` command;
 - `git pull` pulls new changes from remote repository branch;
 - `git submodule update --init --recursive` load contens of all remote repos used in my app. I plan to use Composer for this, now at this poit I have little bugs with it (this is my fault of course), i.e. with composer in yii 1.1.16 extensions loaded not into "/protected/extenstions", but into "/vendor" dir, and not all yii-extenstions version I like works properly.
 
I plan also incude yii-migrations in deploy process.

## Installation ##
To use this file you must install Phing first (so you can call it from command line "`phing`"). On FreeBSD run:

```shell
pkg install pear
pear channel-discover pear.phing.info
pear install phing/phing
# The Git tasks depend on PEAR\'s VersionControl_Git package.
pear install VersionControl_Git
```

1. Clone this repo in your preferred git, fill `build.properties` file;
1. Execute `phing` command.

On FreeBSD you may also need to create symlink on git executable, if git installed but phing doesn't see it:
```shell
ln -s /usr/local/bin/git /usr/bin/git
```

## Conclusion ##
It maybe simpler to use ssh command for this: it's faster, cause you don't waste time for googling "How to do thing with Phing" and learn "XML"-programming. :) But you may use it in many yii projects, creating symlinks for this.

I use this it my CI Jenkins installation as buld task for deploy staging project after unit tests successful on other job.
