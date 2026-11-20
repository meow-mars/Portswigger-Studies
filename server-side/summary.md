## Key Summaries
---
### Path traversal: 
Allows attackers to traverse directories and read arbitrary files, potentially modifying application data or behaviour  

#### Example:  
Imagine an application loads images using **/loadImage?filename=218.png**, the application takes the requested filename and appends the filename to the base directory e.g **/var/www/images/218.png**. As a result, an attacker can modify the following URL to retrieve sensitive files, such as **/var/www/images/../../../etc/passwd**.  

#### Where to look for it
Any parameter that looks like a filename or path (filename=, file=, path=, image=, doc=)  

---

### Access Control  
Application constraints of who or what is authorised to perform actions/access resources. 
- Authentication confirms who the user is
- Session management identifies subsequent requests made by the said user
- Access control determines whether the user is authorised to carry out the action that they intend to do  

Access control design decisions are made by humans so errors are more likely to occur. An example this can lead to is **vertical privilege escalation**.  
- This is when a non-admin user gains access to functionality that they were not supposed to have, giving them vertical privilege escalation.

#### Unprotected Functionality