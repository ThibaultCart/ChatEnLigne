# ChatEnLigne / ChatUp
Une application WEB possèdant un chat publique commun à tous. Les membres doivent être connectés afin de pouvoir rejoindre le chat.

## Langages 
Cette application a été développée à partir des langages suivant : HTML, CSS, PHP, JavaScript.
La base de donnée est développée en SQL.

## Framework
Node.js (https://nodejs.org).
Socket.io - Outil principale pour l'écoute asynchrone des websockets (pour le chat) (https://socket.io).
Express - Architecture pour construire des sites avec Node.js (https://expressjs.com/).

## Dépendences
Suivre au pas-à-pas pour faire fonctionner le site. 
### Possibilités d'installer Node.js sur WSL (Linux subsystème)
ce lien : https://docs.microsoft.com/en-us/windows/nodejs/setup-on-wsl2

### Node.JS
Node.js est nécessasire afin de lancer Socket.io (la framework sur laquelle le chat est basé).
Il suffit de télécharger Node.js sur votre poste ou sur votre serveur. (https://nodejs.org).

### Installation des modules Node.js 
Dans le répertoire du projet, effectuez les points suivants.

#### (Optionnel) Express
```sh
npm install express
```

### MySQL
```sh
npm install mysql
```

### Socket.io
```sh
npm install socket.io
```
## Résultat attendu 

![GitHub Logo](https://i.imgur.com/Ck6KkSt.png)


(Il manque mysql dans l'image)

## Installation

1. Téléchargez le projet.
2. Ouvrez le terminal de commande à l'emplacement du projet. 

![GitHub Logo](https://i.imgur.com/8MAdNJC.png)


3. Entrez 

```sh
node chat.js
```
Vous devriez avoir ceci:
![GitHub Logo](https://i.imgur.com/L7ZBYq3.png)
Cette image date d'avant la dernière modification du serveur Node.js. Le message obtenu est maintenant : 'Server started' pour déclarer le bon démarrage du serveur js et "Connected" pour déclaré la connection à la base de données.


4. Connexion au site (http://localhost)

# Fonctionnement du chat
Le chat fonctionne à partir de la framework Socket.io et écoute les messages sur le port 80.
Pour le moment le chat n'a pas été inclu dans les fichiers présents sur ce dépôt.
