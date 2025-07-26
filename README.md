# 🏦 GyeNyame Vulnerable Bank

**GyeNyame Bank** is a deliberately vulnerable web application designed for cybersecurity students and professionals to learn about common web vulnerabilities through hands-on exploration.

> 🔥 For educational and ethical hacking **training only**. Do not deploy in production environments.

---

## 📦 Features & Tech Stack

- PHP + MySQL web application
- Apache web server
- Docker & Docker Compose
- Intentionally vulnerable core logic

---

## ⚠️ Vulnerabilities Included

This lab simulates several common OWASP-style web attack vectors:

| Vulnerability                         | Description                                                                 |
|--------------------------------------|-----------------------------------------------------------------------------|
| **SQL Injection (SQLi)**             | Bypass login or extract data using SQL payloads                            |
| **Local File Inclusion (LFI)**       | Read system files through path manipulation                                |
| **Insecure Direct Object Reference** | Access other users' accounts and data via ID manipulation                  |
| **File Upload → Reverse Shell**      | Upload malicious file and execute remote shell                             |
| **Improper Auth via Cookies**        | Privilege escalation through tampered session cookies                      |
| **Command Injection**                | Execute system commands through vulnerable parameters                       |

---

## 🚀 Deployment (Local Lab Setup)

You must have Docker and Docker Compose installed.

### 1. Clone the repository

```bash
git clone https://github.com/your-username/gyenyame-vuln-bank.git
cd gyenyame-vuln-bank
```

### 2. Build the application

```bash
docker-compose up -d
The vulnerable banking site will be accessible at:
```

### 3. Run the application

```bash
http://localhost:8080
```

### 4. Login Credentials

Role	Username	Password
Admin	admin	admin123



### 📜 License

MIT — Educational use only


### 📩 Author

Niihack Labs - https://niihackgh.com
Built for CTFs, workshops, and pentesting practice environments.

