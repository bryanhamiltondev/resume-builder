# Resume Builder

**Self-hosted PHP resume builder.** Drop it on any PHP host and go.

Pick a template (tech or retail), fill in the hiring manager, company, role, and location -- get a finished PDF (cover letter + resume).

## Features

- Two templates: **Tech** (full-stack engineer) and **Retail** (customer service)
- Customizable: hiring manager name, company, role, location
- Clean PDF: cover letter + full resume
- Zero dependencies -- generates raw PDF from PHP
- Dark-themed form UI matching bryanhamilton.info

## Deploy

Upload `resume-builder.php` to your server. Visit it in a browser, fill out the form, click Generate.

### Deployment note for thedjcalendar.com

PHP execution is blocked in subdirectories on the host. Deploy at the **root level** as `/resume-builder.php`.

```bash
# Example FTP deploy
curl -sk --ssl -T resume-builder.php ftp://YOUR_HOST/public_html/resume-builder.php
```

Then visit: `https://thedjcalendar.com/resume-builder.php`

## How it works

The file is entirely self-contained:

1. **Form display** (GET request) -- dark-themed form with fields
2. **PDF generation** (POST request) -- generates raw PDF using PHP's string operations. No external libraries, no shell commands, no Composer.
3. **Resume data** -- two complete resume templates stored as PHP arrays with placeholder variables

## Customizing

Edit the `resume_content()` function to update resume text, skills, experience, or cover letter content. The PDF layout is handled by the `ResumePDF` class.

---

Bryan Hamilton -- [bryanhamilton.info](https://bryanhamilton.info) -- [github.com/bryanhamiltondev](https://github.com/bryanhamiltondev)