# Nequlos
Nequlos is a powerful php file manager that is free to use and is portable so you can move it easily between different servers if needed.

Current Version: 1.5S

Includes XSRF Protection

Updates coming soon:
Language change support.

Public Hosting is not recommended


make sure you create a .htaccess file with this in it:

php_value upload_max_filesize 1024M
php_value post_max_size 1024M
<FilesMatch ".*\.(txt)$">
    Order Deny,Allow
    Deny from all
</FilesMatch>
