# PHP .env File Loader - README

Eine einfache PHP-Funktion zum Laden von Umgebungsvariablen aus .env Dateien - OHNE externe Dependencies!

## Was macht dieser Code?

Lädt Konfigurationswerte aus einer .env Datei und macht sie verfügbar über:
- \$_ENV[KEY]
- \$_SERVER[KEY]  
- getenv(KEY)

## Schnellstart

### 1. env-loader.php erstellen

Kopiere den Code in eine neue Datei env-loader.php

### 2. .env Datei erstellen

Datei: .env
<br>
DB_HOST=localhost<br>
DB_PORT=3306<br>
DB_NAME=meine_datenbank<br>
DB_USER=root<br>
DB_PASSWORD=geheimes_passwort<br>

API_KEY=abc123xyz789

APP_ENV=production<br>
APP_DEBUG=false<br>

### 3. Verwenden in index.php

require_once loadEnv.php;

loadEnv(__DIR__ . /.env);

\$dbHost = \$_ENV[DB_HOST];<br>
\$apiKey = getenv(API_KEY);

## Vollständiges Beispiel

### Dateistruktur

mein-projekt/
├── .env                 (NICHT committen!)<br>
├── .env.example         (Template committen)<br>
├── env-loader.php<br>
├── config.php<br>
└── index.php<br>

### config.php

require_once loadEnvr.php;<br>
loadEnv(__DIR__ . /.env);<br>

define(DB_HOST, \$_ENV[DB_HOST]);<br>
define(DB_NAME, \$_ENV[DB_NAME]);<br>
define(DB_USER, \$_ENV[DB_USER]);<br>
define(DB_PASSWORD, \$_ENV[DB_PASSWORD]);<br>

function getDbConnection() {
    \$dsn = mysql:host= . DB_HOST . ;dbname= . DB_NAME;<br>
    \$pdo = new PDO(\$dsn, DB_USER, DB_PASSWORD);<br>
    return \$pdo;<br>
}

### index.php

require_once config.php;<br>
\$db = getDbConnection();<br>

## Sicherheit - WICHTIG!

### .gitignore erstellen

.env<br>
.env.local<br>
vendor/<br>

### Warum .env NICHT committen?

FALSCH: git add .env<br>
-> Passwörter landen in Git History!<br>

RICHTIG: git add .env.example<br>
-> Nur Template ohne echte Passwörter<br>

### Team-Setup

1. Repository holen<br>
2. cp .env.example .env<br>
3. .env mit echten Passwörtern bearbeiten<br>

## Erweiterte Features

### Helper-Funktion

function env(\$key, \$default = null) {<br>
    \$value = \$_ENV[\$key] ?? \$_SERVER[\$key] ?? getenv(\$key);<br>
    return \$value !== false ? \$value : \$default;<br>
}<br>

// Verwendung:
\$dbHost = env(DB_HOST, localhost);<br>
\$debug = env(APP_DEBUG, false);<br>

### Validierung

function validateEnv(\$required = []) {<br>
    \$missing = [];<br>
    foreach (\$required as \$key) {<br>
        if (!isset(\$_ENV[\$key]) || \$_ENV[\$key] === ) {<br>
            \$missing[] = \$key;<br>
        }<br>
    }<br>
    if (!empty(\$missing)) {<br>
        throw new Exception(Missing: . implode(, , \$missing));<br>
    }<br>
}<br>

loadEnv(__DIR__ . /.env);<br>
validateEnv([DB_HOST, DB_NAME, DB_USER, DB_PASSWORD]);<br>

## Troubleshooting

### Problem: Undefined index DB_HOST

Lösung: .env ERST laden, DANN verwenden

loadEnv(__DIR__ . /.env);<br>
\$host = \$_ENV[DB_HOST];<br>

### Problem: Parse error

Nutze Anführungszeichen bei Werten mit Leerzeichen:

Falsch: APP_NAME=Mein Shop<br>
Richtig: APP_NAME="Mein Shop"<br>

### Problem: .env file not found

Nutze absoluten Pfad:<br>

loadEnv(__DIR__ . /.env);<br>

## vs. Composer Package

### Deine Funktion (Lightweight)

Vorteile:<br>
- Keine Dependencies<br>
- Nur 20 Zeilen Code<br>
- Perfekt für kleine Projekte<br>

Nachteile:<br>
- Keine komplexen Features<br>

### vlucas/phpdotenv

Vorteile:<br>
- Viele Features<br>
- Variable Interpolation<br>

Nachteile:<br>
- Braucht Composer<br>
- Mehr Overhead<br>

### Empfehlung

- Kleine Scripts: Deine Funktion<br>
- WordPress: Deine Funktion<br>
- Laravel/Symfony: Built-in dotenv<br>

## Web-Zugriff verhindern

### Nginx

location ~ /\.env {<br>
    deny all;<br>
}<br>

### Apache (.htaccess)

<Files .env><br>
    Order allow,deny<br>
    Deny from all<br>
</Files><br>

## Best Practices

- .env ist in .gitignore<br>
- .env.example als Template committen<br>
- Sensible Daten NUR in .env<br>
- .env hat sichere Permissions (644)<br>
- .env nicht über Web erreichbar<br>
- Production .env ist anders als Development<br>

## Checkliste

- [ ] .gitignore enthält .env<br>
- [ ] .env.example existiert<br>
- [ ] Web-Zugriff blockiert<br>
- [ ] Permissions gesetzt<br>
- [ ] Validierung implementiert<br>

---

Simple. Secure. No Dependencies!
