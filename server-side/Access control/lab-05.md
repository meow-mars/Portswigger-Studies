### Lab: User ID controlled by request parameter, with unpredictable user IDs
---
#### Objective: Find the GUID for carlos, then submit his API key as the solution.
**Solving Steps**   
When logging into the given credentials, we can access the account page, this is where we can locate our own API key as well as the current account in GUID form in the URL. Our goal is to find the target account's GUID, which might be disclosed somewhere in the application and swap out the current GUID for the target GUID.  
Looking through all the posts in the main page, we can locate one of carlos' post, where we can see in the URL userId parameter the ID belonging to carlos. We can use this value to swap out the GUID in the account tab.
```
userId=0360ab95-75a9-4ba2-9c23-646b79502661
```
After doing so, we located the API key belonging to carlos and submitted it to the lab.

---
#### Solution
API Key
```
poRsvw65XfiN24vv83XfkdK55ZyOUiEd
```

---
**Date:** 2026-11-21 | **Status:** Solved