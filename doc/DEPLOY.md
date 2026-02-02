# Procédure de Déploiement

Pour commencer j'ai installé aaPanel sur le vps avec la commande 
```URL=https://www.aapanel.com/script/install_7.0_en.sh && if [ -f /usr/bin/curl ];then curl -ksSO "$URL" ;else wget --no-check-certificate -O install_7.0_en.sh "$URL";fi;bash install_7.0_en.sh aapanel```

Une fois installé j'ai téléchargé les outils nécessaire, NGinx, Apache, MySQL, PHP...

J'ai créer un repo local dans le VPS avec la commande 
``` git init --bare``` dans le dossier ``` /var/depot_git ```, 
celui ci à été créer avec la commande ``` mkdir depot_git ```

Ensuite je retourne sur ma machine local et j'ajoute la remote au VPS avec la commande :
``` git remote add vps root@192.168.23.144:/var/depot_git ```
PS: J'ai nommé la remote vps par souci de compréhension.

