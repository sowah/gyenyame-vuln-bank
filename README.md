# 🛡️ GyeNyame Bank - Vulnerable Web Application Lab (Attack & Detct)

**GyeNyame Bank** is a purposely vulnerable PHP-MySQL banking application built for training, demo, and research. It simulates a realistic insecure banking environment with multiple OWASP Top 10 vulnerabilities and an integrated **ELK Stack (Elasticsearch, Logstash, Kibana)** for log analysis and detection of web-based attacks.

---

## 🔥 Lab Highlights

- Realistic online banking interface
- Fully dockerized (PHP + MySQL + Apache)
- Integrated ELK Stack (Elastic + Logstash + Kibana)
- Apache logs streamed in real time for detection analysis

---

## 🧨 Vulnerabilities Included

The following vulnerabilities are intentionally embedded:

| Vulnerability                          | Description |
|---------------------------------------|-------------|
| 🔓 SQL Injection (SQLi)               | Classic GET/POST-based injections via login, search, etc. |
| 🪟 Local File Inclusion (LFI)         | Includes local server files via vulnerable endpoints |
| 🔑 Insecure Direct Object Reference (IDOR) | Access other users' data by modifying `id` in URL |
| 📂 File Upload to Reverse Shell       | Uploading PHP webshell for RCE |
| 🍪 Broken Authentication (Cookie tampering) | Privilege escalation via cookie value manipulation |
| ⚙️ Command Injection                  | Execute OS-level commands from form input |

---

## 📊 Detection Lab with ELK Stack

The lab includes a detection setup that streams **Apache access logs** into the ELK Stack for real-time attack visibility and detection engineering.

### ✔️ ELK Architecture

- **Elasticsearch**: Stores and indexes the logs
- **Logstash**: Parses Apache logs into structured events
- **Kibana**: Visualizes the logs and alerts

### ✔️ Logs Captured

- HTTP request methods
- Response status codes
- Referrers
- User Agents
- IP addresses
- Request paths (e.g., `/index.php?id=../../../etc/passwd`)

### ✔️ Detection Use Cases

- Detect SQLi using suspicious patterns like `' OR 1=1`
- Detect LFI by monitoring path traversal attempts (`../`)
- Detect file uploads and shell access
- Monitor for elevated status codes (401, 403, 500)
- Track suspicious user-agent behavior

---

## 🚀 How to Deploy the Lab

### 🐳 Prerequisites

- Docker & Docker Compose installed
- At least 4GB RAM for all containers

### 🛠️ Step-by-Step

1. **Clone this repository**

   ```bash
   git clone https://github.com/your-username/gyenyame-vuln-bank.git
   cd gyenyame-vuln-bank
   

### 2. Build the application

```bash
docker-compose up -d
```

### 3. Run the application

```bash
GyeNyame Bank: http://localhost:8080
Kibana Dashboard: http://localhost:5601
```

### 4. Kibana Discover Setup

```
Go to Discover
Set up index pattern: apache-*
You should see fields like ip, path, status, user_agent, etc.
```

### 5. Login Credentials

```
Role	Username	Password
Admin	admin	admin123
```

### 6. ⚙️ Docker Services

```
Service	      Port	   Description
Apache+PHP	   8080	   GyeNyame vulnerable app
MySQL	         3306	   Database
Elasticsearch	9200	   Backend search engine
Kibana	      5601	   Dashboard & Visualization
Logstash	      5044	   Ingests Apache logs
```

### 7. 📁 Folder Structure

```
gyenyame-vuln-bank/
├── docker-compose.yml
├── web/                  # PHP app codebase
├── db/                   # MySQL init scripts
├── apache-logs/          # Apache log output
├── logstash/
│   └── apache.conf       # Logstash pipeline
├── README.md
```

### 📜 License

MIT — Educational use only


### ⚠️ Legal Disclaimer

```
This environment is for educational purposes only. Do NOT deploy to the public internet or use against systems you do not own or have permission to test.
```

### 📩 Author

```
Niihack Labs - https://niihackgh.com
Built for CTFs, workshops, and pentesting practice environments.

```

### 📩 Contributions Welcome!

```
Feel free to open pull requests for:

Detection rule contributions
Custom dashboards
Bug fixes or enhancements

```
