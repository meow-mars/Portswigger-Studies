### Lab: 2FA simple bypass
---
#### Objective: Bypass the two-factor authentication and access carlos' account page
**Tools Used**
Burpsuite Community Edition - Proxy Interceptor
**Solving Steps**   
To begin, I logged into the given credential and retrieved the 2FA code from the email client and switched on the Burpsuite Interceptor. Here I was able to look at the HTTP request sent after a successful 2FA submit. Rather than getting an error, this GET request retrieved the account page with the ID belonging to the user in the credential. The only difference when logging in into different accounts is the session cookie, though this could be obtained when having the other victim's credential.
```
GET /my-account?id=wiener HTTP/2
Host: 0a9f00df049cf6ba80382bcc00da009c.web-security-academy.net
Cookie: session=EXnkBB2tFkUxZ86q6B6jx3zZWbWeNHrh
...
```
Above is the GET request sent after a successful login. From here, I can change the id parameter in the request to the victim's username 'carlos'. The session cookie field can be derived from when logging in with the credential, before inputting the 2FA code. The attack flow from here is:   
```
Log into carlos' account (username + password) -> Reach the 2FA code page -> 
Turn on Burpsuite interceptor -> Instead of submitting a 2FA code, modify the 
intercepted request to GET /my-account?id=carlos -> Forward the request to 
gain access to carlos' account, skipping the 2FA step
```
