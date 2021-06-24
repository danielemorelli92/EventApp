# Istruzioni generali 

## IMPORTANTE:

Il progetto è utilizzabile in due modi:<br>
 - Dal nostro dominio https://eventapp.ml <br>
 - Localmente (su Windows) con EventApp_standalone.zip: <br>
    - E' una cartella autocontenente, ovvero contiene tutto il necessario per eseguire la web app </br>
	- La cartella contiene anche un file di istruzioni per l'installazione </br>
- Importando questa repo e leggendo le istruzioni "Importa la repository"
	
## Info del DB MySQL 5.7 (nel caso di installazione locale):
 - DB username: 'root'
 - DB password: ''
 - DB name: 'eventapp_4loops'

P.S: la cartella standalone contiene un proprio DB che non necessita di configurazioni

 
## Credenziali del portale (in entrambi i casi di utilizzo):
Abbiamo creato 3 utenti generici, la password è sempre 'password':
 - admin@email.com (è un utente admin del portale);
 - organizer@email.com (è un utente organizzatore di eventi)
 - user@email.com (utente base registrato al portale)
 
Inoltre son presenti utenti che abbiamo usato personalmente per popolare il database.

## Importa la repository        (Metodo alternativo per l'importazione e il setup del progetto)

### Prerequisiti
1) Composer (https://getcomposer.org/doc/00-intro.md)
2) PHP versione 7.4 o superiore (https://www.php.net/downloads.php)
3) Node.js (https://nodejs.org/dist/v14.17.1/node-v14.17.1-x64.msi)
4) MySql 5.7 (https://dev.mysql.com/downloads/mysql/5.7.html)
5) Visual C++ Redistributable (https://support.microsoft.com/it-it/topic/download-delle-pi%C3%B9-recenti-versioni-di-visual-c-supportate-2647da03-1eea-4433-9aff-95f26a218cc0)

N.B. assicurarsi che da linea di comando siano riconoscibili i comandi "composer" e "npm". 
Controllare che con il comando "php -v" venga stampata una versione 7.4 o superiore di PHP. 
Controllare che con il comando "mysql --version" venga stampata la versione 5.7.

### Passi
1) Importare la repo in una cartella (https://github.com/danielemorelli92/EventApp.git)
2) Avviare il server mysql 5.7
3) Assicurarsi che le credenziali siano: username=root, senza password.
4) Creare un database di nome: "eventapp_4loops"
5) Aprire la console windows cmd.exe, spostarsi dentro la cartella in cui è stata importata la repo ed eseguire in sequenza i seguenti comandi:
    * composer update                   (ci potrebbe mettere qualche minuto)
    * copy env.example .env             (se non funziona rinominare semplicemente il file env.example in .env)
    * php artisan key:generate && php artisan storage:link && php artisan migrate
    * mysql -u root < mysql_dump.sql    (importa i dati nel database)
6) Avviare il server eseguendo quest'ultimo comando da console:
    * php artisan serve

Verrà stampato a video l'indirizzo su cui è possibile raggiungere l'istanza di esecuzione della webapp
