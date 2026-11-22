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
#### Horizontal to Vertical Escalation 
Horizontal privilege escalation attacks could be turned into vertical privilege escalation attacks if a more privileged user is compromised. If an administrative account is compromised, the hijacker can perform privileged functions and alter credentials. This could also be done through parameter tampering.  

---
### Authentication  
Authentication vulnerabilities can allow attackers to gain access to sensitive resources and functionalities, highlighting its significance in security. These vulnerabilities can also reveal additional attacking vectors for further exploitations.  

*Important Distinction*
Authentication is the process of verifying who the user claims to be, Authorisation is verifying whether the user is permitted to do something.  

---
### Brute Force Attacks  
This is when the attacker uses a sequence of trials and errors in order to guess valid user credentials. Examples of this includes the dictionary attack, which uses a file of common passwords to attempt to gain access to an account. By combining with publicly available information and logic, the process of automated brute-forcing can make more educated guesses, increasing the efficiency of such attacks.  

#### Brute Forcing Usernames  
When usernames conform to a certain pattern, it can make it easier for attackers to guess. An example of such pattern can be business emails, which usually adopt the following pattern.
```
firstname.lastname@company.com
```
Even if there is no recognisable pattern, sometimes higher-privileged accounts could also be created with predictable usernames, such as 'admin' or 'administrator'.

During audits, it is crucial to check if the website discloses such usernames publicly. In additional, it is also a good idea to check if the username or any sensitive details are visible in the HTTP requests.  

#### Brute Forcing Passwords  
Similar to usernames, passwords could also be brute-forced. Difficulties when brute-forcing varies depending on the complexity of the password. Modern websites adopt password policies, forcing users to create high entropy passwords that are theoretically harder to crack in brute-forces. Take Netflix for example, you are required to create a password with:
- Minimum number of characters
- At least 1 uppercase letter  
- At least 1 special character  

While such high-entropy passwords are difficult to crack, basic human behaviours can be used and exploit. For example, rather than creating a strong password with a random combination of characters, users often take a password that they can remember and try to crowbar it into fitting the password policy.  

#### User Enumeration  
User enumeration is when the attacker observes the website's behaviour to identify whether a given username is valid. This can vary from observing login page error or examining API query response time. When paired with brute force attacks, this can greatly increase the efficiency, helping the attacker generate a shortlist of valid usernames. 

#### Bypassing Two-Factor Authentication  
The implementation of two-factor authentication can be flawed at times and the user can be in the 'logged-in' state before inputting the verification code. It is worth testing if you can directly skip to this state after completing the first authentication state.  

**Where to look**
- The page you land on *after* submitting username + password, but *before* the 2FA code (usually /login2 or similar).
- Any post-login page like /my-account, /admin, or a known logged-in URL.

---  
### Server-Side Request Forgery (SSRF)  
SSRF is a web security vulnerability that causes the server-side application to make requests to an unintended location. In these attacks, the attacker could make the server connect to internal services within the organisation infrastructure, or in some cases, to other external systems. This could leak to disclosure of credentials or sensitive information.  

**SSRF against the server**  
The attacker typically causes the application to make a HTTP request back to the server that is hosting the application - this could be through 127.0.0.1 or localhost. This is an example where the attacker modifies the POST request body to request the admin endpoint. A normal user can not access the endpoint. However if the request comes from the local machine, the normal access control is bypassed.  

**Before**
```
POST /product/stock HTTP/1.0
Content-Type: application/x-www-form-urlencoded
Content-Length: 118

stockApi=http://stock.weliketoshop.net:8080/product/stock/check%3FproductId%3D6%26storeId%3D1  
```
**After**
```
POST /product/stock HTTP/1.0
Content-Type: application/x-www-form-urlencoded
Content-Length: 118

stockApi=http://localhost/admin
```
**Trust Relationship**
Why do applications behave this way can root from various reasons:
- The access control check lives on a different component in front of the application server, when the request is made back, this component is bypassed.
- Data recovery: when an unprecedented event occurs, any user coming from the local machine can recover the system without logging on, in case they lose their credentials

**Where to look**
- Any input that is, or contains, a URL: stockApi=, url=, uri=, path=, dest=, redirect=, feed=, callback=, image=, webhook settings.
- Features that fetch things: "check stock", "import from URL", "preview link", PDF/screenshot generators, webhooks, file upload by URL.
- Hidden spots: a full URL inside a POST body, or inside XML/JSON. Sometimes only the hostname is used, so try replacing it.

**If filters block it, try**
- Alternative IP formats: 127.0.0.1 -> 127.1 , 0.0.0.0 , or decimal/hex encodings
- Different host that resolves to localhost
- Redirects: point to a URL you control that 302-redirects to the internal target 

#### SSRF Against other Back-End Systems  
In other cases, the application is able to reach internal back-end systems that are not directly accessible to normal users - protected by network topology. In some cases, internal back-end systems may contain sensitive functionalities that can be accessed by anyone that interacts with the system, without authentication.  

Suppose there is an administrative interface at the back-end URL: '**http://192.168.0.68/admin**', the following request can be submitted to access the interface:  
```
POST /product/stock HTTP/1.0
Content-Type: application/x-www-form-urlencoded
Content-Length: 118

stockApi=http://192.168.0.68/admin
```
**Recon Tips**
- Use Burp Intruder - Numbers to brute force a range of internal IP addresses
- Look at which response has a differing length or status code

---  
### File Upload Vulnerabilities  
File upload vulnerabilities happen when a web server allows users to upload files to its filesystem without validating attributes, such as name, file type, contents, or size. Failing to enforce restrictions or validate these files can allow attackers to upload arbitrary and malicious files.  

#### How do these vulnerabilities occur?  
In development, developers may try to implement what they think is robust validation that is inherently flawed or can be easily bypassed. When using a blacklist, they may fail to account for parsing discrepancies when checking file extensions. They may also omit obscure files which may stay be dangerous. 

The websites may try to check the file type property, which can be modified by attackers through Burpsuite Proxy.  

#### Deploying a web shell through unrestricted file upload  
From a security perspective, the worst possible scenario is when a website allows you to upload server-side scripts, such as PHP, Java, or Python files, and is also configured to execute them as code. If you're able to successfully upload a web shell, you effectively have full control over the server. Look at payloads/web-shell for more examples of payloads. Some examples of these payloads are: 
```php
Allows you to view the content of a file on the filesystem
<?php echo file_get_contents('/path/to/target/file'); ?>

Used together to execute arbitrary commands on the target system
<?php echo system($_GET['command']); ?>
GET /example/exploit.php?command=whoami HTTP/1.1
```  

#### Exploiting flawed validation of file upload  
Modern websites enforce protections against file upload attacks. However, these protection may not be entirely robust, enabling attackers to exploit flaws in these defense mechanism to upload web-shell payloads.  

When submitting HTML forms, the browser usually sends the POST data with the content-type header **application/x-www-form-urlencoded**. However, for large amounts of binary data, like images or documents, this can be inefficient. In this case, **multipart/form-data** is preferred.  

Consider a form containing fields for uploading an image, providing a description of it, and entering your username. Submitting such a form might result in a request that looks something like this: 

```
POST /images HTTP/1.1
    Host: normal-website.com
    Content-Length: 12345
    Content-Type: multipart/form-data; boundary=---------------------------012345678901234567890123456

    ---------------------------012345678901234567890123456
    Content-Disposition: form-data; name="image"; filename="example.jpg"
    Content-Type: image/jpeg

    [...binary content of example.jpg...]

    ---------------------------012345678901234567890123456
    Content-Disposition: form-data; name="description"

    This is an interesting description of my image.

    ---------------------------012345678901234567890123456
    Content-Disposition: form-data; name="username"

    wiener
    ---------------------------012345678901234567890123456--
```

From this, we can see that different fields of the form are separated into parts. Each part contains their own **Content-Disposition** header, providing basic information and the field it belongs to. They may also contain a **Content-Type** header, which tells the server the MIME type of data that was submitted using this input.  

A website may attempt to validate file uploads by checking that the **Content-Type** header matches an expected MIME type. If this check is implicitly trusted by the server, an attacker can modify the field to bypass this validation and upload arbitrary files to the server.