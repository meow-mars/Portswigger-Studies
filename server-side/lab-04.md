### Lab: User role controlled by request parameter
---
#### Objective: Delete the 'carlos' user using the admin panel identifying administrators using a forgeable cookie  
**Technologies Required**
Burpsuite Community Edition - Proxy setup (optional, but interesting to use)
**Solving Steps**   
[Method 1]
To solve this, turn on the Burpsuite Interceptor while logging into the given credentials in the lab. When logging in, you can see the full HTTP POST request with an admin flag field set to 'false'. You can alter the flag and set it to true, before forwarding the request to the server. 
```
Cookie: session=IiZFTn2OpGq9GsCJcH4qoVV4D94TPF8C; Admin=true
```
If editing the field as a POST request does not work, you can refresh the page and edit the GET request flag to the same approach above, where an Admin Panel will appear. Access the Admin Panel with the interceptor to modify the admin flag again, and from here, you can delete the user 'carlos'

[Method 2]
When logging into the account using the given credentials, use the DevTools to retrieve the stored cookie. From here, you can change the admin flag to true. This will remain persistent for all your future HTTP request, not requiring you to change the field constantly per request like the Burpsuite approach.

--- 
#### Both of these methods work because the server trusts whatever Admin value the browser sends