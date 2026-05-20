# .htaccess Documentation

This document explains the `.htaccess` configuration for the **GibelFm** project. These files ensure proper routing and secure your sensitive code.

> [!IMPORTANT]
> Since `.htaccess` files are usually ignored by Git, you must manually create them when deploying to a new server or moving the project.

---

## 1. Root Directory Setup
There are two common ways to set up this project. Choose the one that matches your environment.

### **Option A: Subfolder (e.g., Local WAMP /radio/)**
Use this if your URL looks like `localhost/radio/`.

**File:** `/.htaccess` (Root)
```apache
# Disable directory listing
Options -Indexes

# Prevent access to hidden files
<FilesMatch "^\.">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
</FilesMatch>

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /radio/

    # Block access to sensitive folders
    RewriteRule ^(app|resources|config|routes|scratch|gibelfm|\.git|\.github)($|/) - [F,L]

    # Redirect to public folder
    RewriteRule ^$ public/ [L]
    RewriteCond %{REQUEST_URI} !^/radio/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### **Option B: Root Domain (e.g., InfinityFree / Production)**
Use this if your URL looks like `yourdomain.com/` and you uploaded the files directly into `htdocs`.

**File:** `/.htaccess` (Root)
```apache
# Disable directory listing
Options -Indexes

# Prevent access to hidden files
<FilesMatch "^\.">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
</FilesMatch>

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # Block access to sensitive folders
    RewriteRule ^(app|resources|config|routes|scratch|gibelfm|\.git|\.github)($|/) - [F,L]

    # Redirect to public folder
    RewriteRule ^$ public/ [L]
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 2. Public Directory Routing
This file stays the same regardless of your folder setup. It routes all virtual URLs (like `/news`) to the `index.php` file.

**File:** `/public/.htaccess`
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

## 3. Defense-in-Depth (Sensitive Folders)
Place this file inside `app/`, `config/`, `resources/`, `routes/`, and `scratch/` to ensure no one can ever access your PHP logic directly.

**File:** `[folder]/.htaccess`
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

## Troubleshooting
1. **500 Error**: Usually caused by a typo in `.htaccess` or your server not having `mod_rewrite` enabled.
2. **403 Error**: Expected if you try to access the `/app/` folder directly.
3. **Broken Links**: If CSS/JS doesn't load, check the `RewriteBase` in your root `.htaccess`.
