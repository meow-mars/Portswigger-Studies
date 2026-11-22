### Lab: Unprotected admin functionality with unpredictable URL
---
#### Objective: Delete the 'carlos' user using the unprotected admin panel
**Solving Steps**   
On the website, I opened the developer console and accessed the Sources tab, looking through each sources for potential disclosure of unprotected pages. On the login page, I spotted an inline script which is hidden to normal users. The script creates a link to the admin panel, setting the href attribute as '/admin-68znvc'. From here I accessed the unprotected administration page to delete the 'carlos' user.  

---
#### Solution
```javascript
/*
Vulnerable Script
*/
var isAdmin = false;
if (isAdmin) {
   var topLinksTag = document.getElementsByClassName("top-links")[0];
   var adminPanelTag = document.createElement('a');
   adminPanelTag.setAttribute('href', '/admin-68znvc');
   adminPanelTag.innerText = 'Admin panel';
   topLinksTag.append(adminPanelTag);
   var pTag = document.createElement('p');
   pTag.innerText = '|';
   topLinksTag.appendChild(pTag);
}
```
```
URL accessed: 
https://0aa300e60327063e81ce849600410004.web-security-academy.net/admin-68znvc
```

---
**Date:** 2026-11-20 | **Status:** Solved