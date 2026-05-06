# .htaccess Documentation

Since `.htaccess` files are often ignored by version control (Git) to avoid environment conflicts, this document provides the standard configuration used for the **GibelFm** project to ensure security and proper routing.

## 1. Root Directory (`/radio/.htaccess`)
This file is responsible for transparently redirecting all traffic to the `public/` folder and blocking access to sensitive source code.

```apache
# Disable directory listing
Options -Indexes

# Prevent access to hidden files
<FilesMatch "^\.">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
    </IfModule>
</FilesMatch>

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /radio/

    # 1. Block access to sensitive folders explicitly
    RewriteRule ^(app|resources|config|routes|scratch|gibelfm|\.git|\.github)($|/) - [F,L]

    # 2. Block access to specific sensitive files in root
    RewriteRule ^(\.gitignore|composer\.json|composer\.lock|package\.json|package-lock\.json|README\.md)$ - [F,L]

    # 3. Handle the main redirection to public folder
    RewriteRule ^$ public/ [L]

    # If the request doesn't start with 'public/', prepend 'public/'
    RewriteCond %{REQUEST_URI} !^/radio/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 2. Public Directory (`/radio/public/.htaccess`)
This file handles internal routing for the application (Front Controller pattern).

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # If the request is not a physical file or directory,
    # route it to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L,QSA]
</IfModule>
```

---

## 3. Sensitive Folders (`/app/`, `/config/`, `/resources/`, `/routes/`, `/scratch/`)
Each of these folders contains an `.htaccess` file to block direct access to the PHP source code.

**Path:** `[folder]/.htaccess`
```apache
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
</IfModule>
```

---

## Setup Instructions
1. Ensure Apache has `mod_rewrite` enabled.
2. In your WAMP/Apache config, ensure `AllowOverride All` is set for the project directory.
3. If your project folder name is different from `radio`, update the `RewriteBase` and `RewriteCond` lines in the Root `.htaccess`.
