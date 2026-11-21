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
Vertical privilege escalation happens when an application does not enforce any protection for 'sensitive functionality'. For example, administrative functions could be linked to a page that should only be accessible to admin users. If a normal user can access that page, they can execute privileged functions. An example URL with admin functionalities.

```
https://insecure-website.com/admin
```

#### Where to look
In some cases, the administrative URL might be disclosed in other locations. An example of this is the "*robots.txt*" file which is usually placed in the website's root directory.
```
Extra Locations (Researched)
/sitemap.xml
Page source
Commented out HTML -- less often but could be worth checking
```
#### Security By Obscurity  
This is when sensitive functions are concealed, potentially with an unpredictable URL.
```
https://insecure-website.com/administrator-panel-yb556
```
However, this does not provide a concrete resistance to attack, as the URL could still be leaked within the application source to attackers and normal users. Take this given example, the URL is disclosed within the javascript, regardless of what role the user is.
```javascript
<script>
	var isAdmin = false;
	if (isAdmin) {
		...
		var adminPanelTag = document.createElement('a');
		adminPanelTag.setAttribute('href', 'https://insecure-website.com/administrator-panel-yb556');
		adminPanelTag.innerText = 'Admin panel';
		...
	}
</script>
```
#### Parameter-based access control methods  
This is when users' access rights or role is stored in a user-controllable location rather than being worked out server-side. This could be in a hidden field, cookie, or a preset query string parameter. On each request, the server reads the value and believes it. An attacker could modify these objects to potentially gain vertical privilege escalation. An example of this is in the URL parameter, where the role is stored and used in every request.
```
https://insecure-website.com/login/home.jsp?admin=true
https://insecure-website.com/login/home.jsp?role=1
```
When elements are hidden from the users but still returned to the browser, a user can still view and change the elements by looking into the page source and response being sent back from the server. A practice to prevent this is to keep any important information such as user role on the server.  
#### Horizontal Privilege Escalation  
This occurs when a user tries to gain resources belonging to another user, opposite to vertical privilege escalation. For example, an attacker wants to access another record belonging to another user is an example of horizontal privilege escalation. Similar to the parameter-based access control method, an attacker might modify the URL parameter to access an account that does not belong to them for instance.
```
https://insecure-website.com/myaccount?id=123
https://insecure-website.com/myaccount?id=124 <-- modified parameter
```
In some applications, GUID might be used to prevent the attacker from guessing or predicting another user's identifier. This value however, could be disclosed elsewhere in the application, such as forum comments, user messages, or reviews.  
