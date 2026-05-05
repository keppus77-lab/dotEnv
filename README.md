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

DB_HOST=localhost
DB_PORT=3306
DB_NAME=meine_datenbank
DB_USER=root
DB_PASSWORD=geheimes_passwort

API_KEY=abc123xyz789

APP_ENV=production
APP_DEBUG=false

### 3. Verwenden in index.php

require_once loadEnv.php;

loadEnv(__DIR__ . /.env);

\$dbHost = \$_ENV[DB_HOST];
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

require_once loadEnvr.php;
loadEnv(__DIR__ . /.env);

define(DB_HOST, \$_ENV[DB_HOST]);
define(DB_NAME, \$_ENV[DB_NAME]);
define(DB_USER, \$_ENV[DB_USER]);
define(DB_PASSWORD, \$_ENV[DB_PASSWORD]);

function getDbConnection() {
    \$dsn = mysql:host= . DB_HOST . ;dbname= . DB_NAME;
    \$pdo = new PDO(\$dsn, DB_USER, DB_PASSWORD);
    return \$pdo;
}

### index.php

require_once config.php;
\$db = getDbConnection();

## Sicherheit - WICHTIG!

### .gitignore erstellen

.env
.env.local
vendor/

### Warum .env NICHT committen?

FALSCH: git add .env
-> Passwörter landen in Git History!

RICHTIG: git add .env.example
-> Nur Template ohne echte Passwörter

### Team-Setup

1. Repository holen
2. cp .env.example .env
3. .env mit echten Passwörtern bearbeiten

## Erweiterte Features

### Helper-Funktion

function env(\$key, \$default = null) {
    \$value = \$_ENV[\$key] ?? \$_SERVER[\$key] ?? getenv(\$key);
    return \$value !== false ? \$value : \$default;
}

// Verwendung:
\$dbHost = env(DB_HOST, localhost);
\$debug = env(APP_DEBUG, false);

### Validierung

function validateEnv(\$required = []) {
    \$missing = [];
    foreach (\$required as \$key) {
        if (!isset(\$_ENV[\$key]) || \$_ENV[\$key] === ) {
            \$missing[] = \$key;
        }
    }
    if (!empty(\$missing)) {
        throw new Exception(Missing: . implode(, , \$missing));
    }
}

loadEnv(__DIR__ . /.env);
validateEnv([DB_HOST, DB_NAME, DB_USER, DB_PASSWORD]);

## Troubleshooting

### Problem: Undefined index DB_HOST

Lösung: .env ERST laden, DANN verwenden

loadEnv(__DIR__ . /.env);
\$host = \$_ENV[DB_HOST];

### Problem: Parse error

Nutze Anführungszeichen bei Werten mit Leerzeichen:

Falsch: APP_NAME=Mein Shop
Richtig: APP_NAME="Mein Shop"

### Problem: .env file not found

Nutze absoluten Pfad:

loadEnv(__DIR__ . /.env);

## vs. Composer Package

### Deine Funktion (Lightweight)

Vorteile:
- Keine Dependencies
- Nur 20 Zeilen Code
- Perfekt für kleine Projekte

Nachteile:
- Keine komplexen Features

### vlucas/phpdotenv

Vorteile:
- Viele Features
- Variable Interpolation

Nachteile:
- Braucht Composer
- Mehr Overhead

### Empfehlung

- Kleine Scripts: Deine Funktion
- WordPress: Deine Funktion
- Laravel/Symfony: Built-in dotenv

## Web-Zugriff verhindern

### Nginx

location ~ /\.env {
    deny all;
}

### Apache (.htaccess)

<Files .env>
    Order allow,deny
    Deny from all
</Files>

## Best Practices

- .env ist in .gitignore
- .env.example als Template committen
- Sensible Daten NUR in .env
- .env hat sichere Permissions (644)
- .env nicht über Web erreichbar
- Production .env ist anders als Development

## Checkliste

- [ ] .gitignore enthält .env
- [ ] .env.example existiert
- [ ] Web-Zugriff blockiert
- [ ] Permissions gesetzt
- [ ] Validierung implementiert

---

Simple. Secure. No Dependencies!
