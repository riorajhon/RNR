# Contact form – emails to mail@myratings.online

The contact form saves submissions to the database and sends an email to **mail@myratings.online**. If messages are not arriving, use SMTP (your mail server or host’s SMTP) so delivery is reliable.

## Why you might not see messages

1. **On localhost (XAMPP)** – PHP `mail()` usually does not send real email unless you configure a relay. Use SMTP (see below).
2. **On cPanel/hosting** – `mail()` can work, but some hosts require a valid “From” address or send to spam. Using SMTP with your mailbox is more reliable.
3. **Spam folder** – Check spam/junk for mail@myratings.online.

## Option: Send via SMTP (recommended)

Configure your host’s SMTP (or the mailbox for mail@myratings.online) so the site sends through it.

1. **Get SMTP details** (from your host or email provider), for example:
   - **Host:** `mail.myratings.online` or `smtp.myratings.online` (cPanel: Email Accounts → Connect Devices)
   - **Port:** 587 (TLS) or 465 (SSL)
   - **User:** `mail@myratings.online` (or the full email)
   - **Password:** the password for that email account

2. **Add them to your config**  
   In **`backend/config.cpanel.php`** (create it from your existing cPanel config if needed), add:

   ```php
   define('CONTACT_SMTP_HOST', 'mail.myratings.online');   // your host’s SMTP server
   define('CONTACT_SMTP_PORT', 587);
   define('CONTACT_SMTP_USER', 'mail@myratings.online');
   define('CONTACT_SMTP_PASS', 'your_email_password');
   define('CONTACT_SMTP_SECURE', 'tls');   // use 'ssl' if port is 465
   ```

3. **Save** – The contact form will then send via SMTP to **mail@myratings.online** (still set in `config.php` as `CONTACT_EMAIL`). Messages should land in that inbox.

**Security:** Do not commit `config.cpanel.php` (it’s in `.gitignore`). Keep your SMTP password secret.

## If you use a different mailbox for receiving

In **`backend/config.php`** you have:

```php
define('CONTACT_EMAIL', 'mail@myratings.online');
```

Change `CONTACT_EMAIL` to another address if you want contact submissions delivered somewhere else. SMTP credentials can still be for mail@myratings.online (or any account that can send mail).
