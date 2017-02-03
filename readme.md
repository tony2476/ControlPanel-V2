# Introduction

This repo is a starting framework consisting of the following parts.

* Codeigniter 3.x (Latest version at time of creation)
* Ion Auth
* Bootstrap
* HMVC
* SB Admin Panel 2

It also includes additional modules as follows;

* Basic RBACL system based on Ion Auth User Groups.
* A menu editor and display system.

All modules are fully self contained and the aim is for them not to require any additional modules.  Modules are located in application/modules.

This is a work in progress and is not ready for production use yet.

## Ion Auth
I do not include the Ion Auth code here directly.  To import the most recent version of ion auth and keep it up to date.

`cd application/third_party
`git clone git@github.com:benedmunds/CodeIgniter-Ion-Auth.git
`mv CodeIgniter-Ion-Auth/ ion-auth
`cd ion-auth/
`git pull

Periodically do a git pull in this folder. 
