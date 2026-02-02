# Procédure de Déploiement

Pour commencer j'ai installé aaPanel sur le vps avec la commande 
```URL=https://www.aapanel.com/script/install_7.0_en.sh && if [ -f /usr/bin/curl ];then curl -ksSO "$URL" ;else wget --no-check-certificate -O install_7.0_en.sh "$URL";fi;bash install_7.0_en.sh aapanel```

Une fois installé j'ai téléchargé les outils nécessaire, NGinx, Apache, MySQL, PHP...

Maintenant que tous les outils sont installé, il me reste plus qu'à créer un site dans "WebSite" > "Add Site"
Je renseigne le domaine, le nom du dossier que je souhaite créer, dans mon cas ce sera "habit-tracker" puis si je souhaite par défault ajouter une base de données. J'en ai profiter pour le faire en la nommant également "habit-tracker"

J'ai créer un repo local dans le VPS avec la commande 
``` git init --bare``` dans le dossier ``` /var/depot_git ```, 
celui ci à été créer avec la commande ``` mkdir depot_git ```

Ensuite je retourne sur ma machine local et j'ajoute la remote au VPS avec la commande :
``` git remote add vps root@192.168.23.144:/var/depot_git ```
PS: J'ai nommé la remote vps par souci de compréhension.

Maintenant mon code ce situe sur la version que j'ai déployé, il ne me reste plus qu'à créer le fichier 
".env" définir mes variables d'environnements, nottement pour la connection à la base de données.

Ensuite je suis retourné sur l'interface de réglage de mon domaine fraichement créer. Je fais dans l'onglet composer et je click sur "appsearch", une fois qu'il a trouvé l'application, je click sur execute. Ce qui permet de faire un ``` composer install ``` directement depuis l'interface.

Maintenant que le fichier d'environnement est complété et composer installé, j'ai pu faire un ``` php bin/create-database ``` afin de créer la base de données et de vérifier que la connexion à celle ci est correctement configuré. J'ajoute les données d'exemple en faisant un ``` php bin/load-demo-data ```


# Script automatisé de deploiement

J'ai créer un fichier `touch deploy.sh`, je  l’ouvre `sudo nano deploy.sh` et je met la commande `VARNAME=${1:?"missing arg 1 for tag name or branch name"}`

`git --git-dir=/var/depot_git --work-tree=/www/wwwroot/habit-tracker checkout -f $VARNAME`

Je modifie les droits pour que la commande passe `chmod +x deploy.sh`
Maintenant me reste plus qu'a éxecuter `./deploy.sh nom_du_tag`

