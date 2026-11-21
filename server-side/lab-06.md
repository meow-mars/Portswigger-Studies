### Lab: User ID controlled by request parameter with password disclosure
---
#### Objective: Retrieve the administrator's password, then use it to delete the user carlos
**Solving Steps**   
Logging into the given credentials, I can access the account portal, where I can see the URL parameter containing the id being set to the current user. Here I tried tampering with the parameter, modifying it to other potential admin accounts. I tried 'admin', but it did not work. Then I moved to 'administrator' and I was in the administrator account portal. From here I tried modifying the password and tried logging in, but it did not work, so I had to try another approach.  
I used the DevTools to look at the HTML element concealing the admin password, where I was able to spot the value, within the HTML tag value parameter. From here I was able to retrieve the administrator account password and log in.  
Logging into the administrator account, I can now access the admin panel and delete the user 'carlos'. Optionally, I can also change the email and password of the administrator account to mine, hijacking the account.

---
#### Solution

```
Username: administrator
Password: m4v1u8viv0eoz4brjpkg
```

--- 
#### Bugs Identified
- Changing the ID in the parameter allows you to view another user's page
- The password was able to be viewed from inside the Developer Console, despite it being invisible in the normal user's UI.

---
**Date:** 2026-11-21 | **Status:** Solved