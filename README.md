# CraftedWeb

O conteúdo abaixo é do repositório original, o qual foi excluído. Peguei o site, traduzi e modifiquei umas coisinhas.


A Content Management System for TrinityCore based emulators.

Project maintained and owned by EmuDevs.com.

Original designer: CraftedDev


**Please note that this is a freeware CMS.**

But you may NOT:
  - Distribute to others, refer them to www.EmuDevs.com.
  - Sell the CMS to others. It's freeware, stupid.
  - Claim that you are the owner/creator of the site.

 
 * Note: It is suggested that you have your world, auth and website database on the same host.
         Offsite DB hosting requires remote user setup.

# Installing

**AUTOMATIC WAY TO INSTALL:**
1. Upload all files to your desired location.

2. (Optional)Create a new database ON THE SAME DATABASE AS YOUR 'auth'. Name it for example: craftedweb. If you do not create one now, the installer will do it for you.

3. CHMOD 777 the 'error.log','/install/sql/CraftedWeb_Base.sql','/includes/configuration.php' and all files found in '/install/sql/updates/'

	How to CHMOD on FileZilla: http://www.phpjunkyard.com/tutorials/ftp-chmod-tutorial.php

4. Open up your website. You should be redirected to the Installer. Follow the instructions.

5. When you are finished with the Installer. Rename or Delete(Most secure) the /install directory. When you do this, you website Will be enabled.

6. Browse the page and check for any problems. 

	If you encounter errors/problems.
	
		5.1: Open up your configuration file and set 'useDebug' to true
		
		5.2: Browse your website again. The script Should exit the website if any errors are found. The error will be shown directly on to the site.
		
		5.3: (Info)Errors should always be stored in your error.log file(Your CHMOD must be set to 777 on the error.log file). To view these errors. 
		
		First off, Open up your configuration file and set 'useDebug' to true.
		In your browser, go into: '{YOUR WEBSITE URL}/includes/error-log.php'. If no errors are reported, you're good. Set the useDebug back to false. 
		But if you still encounter problems with your site, but no errors are returned, ask for help at the forum.
		If you do find errors, check the date on them, are they fresh? If yes, read the error, try to solve it on your own if you can. Otherwise, ask for help at 		the forum. 

7. If the website runs smoothly, you're good! Report your thoughts on the forum. Do you miss any small feature you want me to add? What were your opinions on the installation proccess? 

8. (Bonus)Open up 'documents/termsofservice.php' and 'documents/refundpolicy.php'. Enable them, and edit the file if you wish to use those.

**MANUAL WAY TO INSTALL:**
If somehow, the automatic installation does not work. Try this one.

 1. Upload all files to your desired location.
 
 2. Create a new database ON THE SAME DATABASE AS YOUR 'auth'. Name it for example: craftedweb.
 
 3. Open up any SQL software of your choice (eg. HeidiSQL). Run the SQL file located at: install/sql/CraftedWeb_Base.sql.
 
 4. (Optional)Same as above, but run the file named 'item_icons.sql' this time instead.
 
 5. Remove the file 'includes/configuration.php'
 
 6. Upload the file located at 'backups/configuration.php' into 'includes/configuration.php'
 
 7. Edit the configuration file to fit your needs.
 
 8. Browse the page and check for any problems. 

	If you encounter errors/problems.
	
		8.1: Open up your configuration file and set 'useDebug' to true
		
		8.2: Browse your website again. The script Should exit the website if any errors are found. The error will be shown directly on to the site.
		
		8.3: (Info)Errors should always be stored in your error.log file(Your CHMOD must be set to 777 on the error.log file). To view these errors.
		
		First off, Open up your configuration file and set 'useDebug' to true.
		In your browser, go into: '{YOUR WEBSITE URL}/includes/error-log.php'. If no errors are reported, you're good. Set the useDebug back to false. 
		But if you still encounter problems with your site, but no errors are returned, ask for help at the forum.
		If you do find errors, check the date on them, are they fresh? If yes, read the error, try to solve it on your own if you can. Otherwise, ask for help at 					the forum. 

9. Your website should now work.	

10. (Bonus)Open up 'documents/termsofservice.php' and 'documents/refundpolicy.php'. Enable them, and edit the file if you wish to use those.	


# FAQ

* Q: I recently updated the core files for my website, and the site tells me I have a mismatch between the databse & core.
* A: Make sure you have loaded all SQL update files found in "sql/updates". You obviously havent updated to the latest database revision.
	Example. If the website tells you that the current revision is "r_02", and the expected one is "r_04". Run "CW_Update_03" & "CW_Update_04".

	
* Q: The whole page is white!
* A: There are 2 viable problems here.
	1. You have a bunch of errors but the error reporting does not work. Check your /includes/error-log.php page. Also check your configuration file if everything is   correct.
	2. Your files cant be loaded since the user dont have access. On some webservers, you might have to CHMOD all files to 755.
   
   
* Q: I miss a function, or I've found a serious or minor bug.
* A: Report any problems you may find at EmuDevs.com. I will read all posts and do my best with the time and effort available to me.


* Q: What cores does the site support?
* A: Currently, only TrinityCore. Major cataclysm support is available also(Skyfire/ArkCore etc), but some items may be lacking, but the site will still run at ~ 95%.
	ArcEmu/Mangos support may be added in the future, but it takes extra effort to make it compatible with multiple cores.


* Q: My slider images are not uploading!
* A: You must chmod 0777 your styles/global/slideshow/ directory and the folders in it.


Thank you for using CraftedWeb.

-www.EmuDevs.com-
