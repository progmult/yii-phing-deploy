# yii-phing-deploy
This is my phing config to deploy yii-1.1.* apps

It uses simple scenario:
- export last revision from git repo to "export" temp directory;
- rsync override "export" directory content with files from "override" dirictory (some config.php files or master view's with disabled debugging params);
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

1. Extract this repo in your preferred dir, fill `build.properties` file;
2. Clone your project into "export" dir (it's just one time) `git clone yoursshrepoaddress`;
1. Execute `phing` command.

If you run deploy at first time, you need to clone your repo in "export" dir (see p.2);
`git clone yoursshrepoaddress`.
To do this you must be logged in with user credentials, which next will be used to call phing automatically.

For this user you need to generate ssh-deployments key and add it to git and deploy servers:
```ssh
# generate new ssh key for deploy user, I use jenkins.
su jenkins
ssh-keygen -t rsa
# copy public key to your deploy server
cd ~/.ssh
ssh-copy-id -id_rsa.pub deployuser@yourdeployserver.com
# same way copy public key to your git server or copy-paste it content to your gitserver web interface
cat id_rsa.pub
```

## Conclusion ##
It maybe simpler to use ssh command for this: it's faster, cause you don't waste time for googling "How to do thing with Phing" and learn "XML"-programming. :) But you may use one deploy config for many yii projects, just created symlinks to build.xml.

I use this it my CI Jenkins installation as buld task for deploy staging project after unit tests successful on other job.
