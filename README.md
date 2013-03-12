Logaramus
=========

Logarmus is a shell script to log a web-server's load average(15min), and a php page to view the log.

To enable logging, add a crontab on the server: 

    crontab -e

and append this line, replacing the path by your logaramus folder:

    */15 * * * * cd /path/to/folder && ./logaramus

Just in case that saves you a search, to change the default text editor:

    sudo update-alternatives --config editor

To view the log, direct your browser to the logaramus folder.

