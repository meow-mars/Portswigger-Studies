## Key Summaries

### Path traversal: 
Allows attackers to traverse directories and read arbitrary files, potentially modifying application data or behaviour  

#### Example:  
Imagine an application loads images using **/loadImage?filename=218.png**, the application takes the requested filename and appends the filename to the base directory e.g **/var/www/images/218.png**. As a result, an attacker can modify the following URL to retrieve sensitive files, such as **/var/www/images/../../../etc/passwd**.  

#### Where to look for it
Any parameter that looks like a filename or path (filename=, file=, path=, image=, doc=) 


