To make the local server display newly uploaded files in index.php & my-blogs.php:

	1. The "Image" folder needs to gain read & write access, and ownership of the file
	   needs to change so that the PHP process is running under the same user who owns
	   the directory.
	2. If you're using XAMPP, the Apache process might be running under a system account.
	   This can be checked using the following command in the terminal:
		
		ps aux | grep httpd

	3. Look for a process owned by a user (such as _www or daemon). If it's a system 
	   user, change the directory ownership to match by using the following command:

		sudo chown -R (system_user):staff path/to/photo_abcd_A/images

	4. After running the two previous commands, retry using the website using the local
	   server. It should now be functioning properly.
