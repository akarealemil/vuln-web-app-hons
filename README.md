# Vulnerable Web Application

## Vulnerabilities
The vulnerabilities part of this website are:
- Information Disclosure
- NoSQL Injection
- Cross-Site Scripting
- Broken Access Control

### Information Disclosure
Vulnerability 1:
On homepage, within the navbar source (inspect element to access), there are two hidden parts; logs and directories.

Logs contains information which should not be exposed, such as hashed passwords, MySQL errors with passwords, JWT Authentication Tokens
Directories lists some directories, but some are hidden.

Vulnerability 2:
robots.txt contains directories that are hidden within the vulnerability list. One of these is debug.php which contains information about the web server.

Vulnerability 3:
Improper error pages

### NoSQL Injection


### Cross-Site Scripting


### Broken Access Control