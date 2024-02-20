# SUMMARY
Example project run with PHP 8 and Laravel 9 as REST API
## Requirement

- Make pagkage
- Docker
- Docker Compose

### Install make package

- [Windows](http://gnuwin32.sourceforge.net/packages/make.htm)
```shell
Download and install GnuWin32
Go to the install folder C:\Program Files (x86)\GnuWin32\bin
Copy all files inside the bin folder to the root project directory (libiconv2.dll, libintl3.dll, make.exe)
```
- Mac/Linux: install `make` package

### How do get set up?
Check Makefile for more details and command
*Use Mailhog (http://localhost:8025) for email confirm incase needed
```shell
$ git clone
$ cd <folder_name>
$ make up //Start docker container
$ make app-init //init Laravel package
$ make clear //Clear cache
$ make app-db-fresh //Migrate & seed new data
$ make down //Stop docker container
```