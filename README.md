# PHP .env File Loader - README

Eine einfache PHP-Funktion zum Laden von Umgebungsvariablen aus .env Dateien - OHNE externe Dependencies!

## Was macht dieser Code?

Lädt Konfigurationswerte aus einer .env Datei und macht sie verfügbar über:
```php
- $_ENV[KEY]
- $_SERVER[KEY]  
- getenv(KEY)
```
## Schnellstart

### 1. env-loader.php erstellen

Kopiere den Code in eine neue Datei env-loader.php

### 2. .env Datei erstellen

Datei: .env
```yaml
DB_HOST=localhost
DB_PORT=3306
DB_NAME=meine_datenbank
DB_USER=root
DB_PASSWORD=geheimes_passwort

API_KEY=abc123xyz789

APP_ENV=production
APP_DEBUG=false
```

### 3. Verwenden in index.php
```php
require_once loadEnv.php;

loadEnv(__DIR__ . /.env);

$dbHost = \$_ENV[DB_HOST];
$apiKey = getenv(API_KEY);
```
## Vollständiges Beispiel

### Dateistruktur

mein-projekt/
├── .env                 (NICHT committen!)<br>
├── .env.example         (Template committen)<br>
├── env-loader.php<br>
├── config.php<br>
└── index.php<br>

### config.php
```php
require_once loadEnvr.php;
loadEnv(__DIR__ . /.env);

define(DB_HOST, $_ENV[DB_HOST]);
define(DB_NAME, $_ENV[DB_NAME]);
define(DB_USER, $_ENV[DB_USER]);
define(DB_PASSWORD, $_ENV[DB_PASSWORD]);

function getDbConnection() {
    $dsn = mysql:host= . DB_HOST . ;dbname= . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    return $pdo;
}
```
### index.php
```php
require_once config.php;<br>
$db = getDbConnection();<br>
```
## Sicherheit - WICHTIG!

### .gitignore erstellen
```yaml
.env
.env.local
vendor/
```
### Warum .env NICHT committen?
```yaml
FALSCH: git add .env
```
-> Passwörter landen in Git History!<br>

RICHTIG: git add .env.example<br>
-> Nur Template ohne echte Passwörter<br>

### Team-Setup

1. Repository holen<br>
2. cp .env.example .env<br>
3. .env mit echten Passwörtern bearbeiten<br>

## Erweiterte Features

### Helper-Funktion
```php
function env($key, $default = null) {
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    return $value !== false ? $value : $default;
}

// Verwendung:
$dbHost = env(DB_HOST, localhost);
$debug = env(APP_DEBUG, false);
```
### Validierung
```php
function validateEnv($required = []) {
    $missing = [];
    foreach ($required as $key) {
        if (!isset($_ENV[$key]) || $_ENV[$key] === ) {
            $missing[] = $key;
        }
    }
    if (!empty($missing)) {
        throw new Exception(Missing: . implode(, , $missing));
    }
}


loadEnv(__DIR__ . /.env);
validateEnv([DB_HOST, DB_NAME, DB_USER, DB_PASSWORD]);
```
## Troubleshooting

### Problem: Undefined index DB_HOST

Lösung: .env ERST laden, DANN verwenden
```php
loadEnv(__DIR__ . /.env);
$host = $_ENV[DB_HOST];
```
### Problem: Parse error

Nutze Anführungszeichen bei Werten mit Leerzeichen:

Falsch: APP_NAME=Mein Shop<br>
Richtig: APP_NAME="Mein Shop"<br>

### Problem: .env file not found

Nutze absoluten Pfad:<br>
```php
loadEnv(__DIR__ . /.env);
```
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
```php
location ~ /\.env {
    deny all;
}
```

### Apache (.htaccess)
```php
<Files .env><br>
    Order allow,deny<br>
    Deny from all<br>
</Files><br>
```
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
