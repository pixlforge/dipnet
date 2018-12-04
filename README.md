# Dipnet

## Mise à jour 4 décembre 2018

### Changelog v0.3

- Les formats supprimés sont tout de même visibles dans le gestionnaire de commande ainsi que dans les bulletins de commande et livraison afin d'assurer l'intégrité des données.
- Les articles supprimés sont tout de même visibles dans le gestionnaire de commande ainsi que dans les bulletins de commande et livraison afin d'assurer l'intégrité des données.
- Les affaires supprimées sont tout de même visibles dans le gestionnaire de commande ainsi que dans les bulletins de commande et livraison afin d'assurer l'intégrité des données.
- L'affaire par défaut d'une société est maintenant réinitialisée lorsque celle-ci est supprimée.
- L'adresse e-mail de l'administrateur ayant pris en charge la commande est maintenant affichée sur les bulletins de commande et de livraison.
- L'impression est désormais réalisée à 100% de la largeur de la page.
- La taille du texte des pages bulletin de commande et livraison a été réduite de manière générale à l'impression.
- La taille des en-têtes du tableau des documents des pages bulletin de commande et livraison a été réduite légèrement à l'impression.
- Le tableau des pages bulleting de commande et livraison force maintenant l'affichage de la couleur de fond des rangées impaires à l'impression.
- Les utilisateurs ont maintenant la possibilité de supprimer leurs affaires.
- Résolu un bug qui empêchait les administrateurs de supprimer correctement les affaires.
- L'affichage des groupes société et utilisateur pour les sliders de création et d'ajout de société pour les administrateurs a été modifié et se présente maintenant sur une seule ligne.

## Mise à jour 27 novembre 2018

### Mise à jour

Cette mise à jour contient des changements importants au niveau des tables. Il est donc nécessaire de relancer les migrations à l'aide de la commande

```cli
php artisan migrate:fresh
```

puis

```cli
php artisan db:seed
```

dans le cas où vous voulez pré-peupler la base de données. 

### Changelog v0.2

- Suppression du package barryvdh/laravel-ide-helper
- Suppression du package beyondcode/laravel-query-detector qui faisait doublon avec Laravel Telescope
- Installation de Laravel Telescope [Laravel Telescope - Laravel - The PHP Framework For Web Artisans](https://laravel.com/docs/5.7/telescope)
- Les administrateurs n’ont désormais plus accès au formulaire d’envoi d’invitation lorsqu’il se trouvent sur la page de détails d’une société. Les administrateurs doivent utiliser la fonctionnalité de création d’utilisateur leur étant destinée.
- Supprimé le statut de la société
- Une boîte de confirmation est maintenant affichée aux administrateurs avant la suppression d’articles et de formats
- Résolu un bug affectant l’envoi de mails pour les utilisateurs solo à la finalisation d’une commande
- Ajouté plus d’informations de contact dans les bulletins de commande
- Ajouté plus d’informations de contact dans les bulletins de livraison
-  Les emails envoyés lors de la finalisation d’une commande reflètent les changements effectués au niveau des bulletins
- Les rangées paires des tableaux dans les bulletins sont maintenant colorés
- La colonne du nom de fichier des tableaux des bulletins a été grandement élargie
- Les tableaux ont maintenant une largeur minimum de 1200px. En-dessous de cette taille, leur conteneur permet un défilement horizontal.
- Le ticker n’est maintenant plus visible à l’impression
- Une page blanche superflue était générée à l’impression dans la vue des bulletins de commande. Cela ne devrait plus être le cas désormais.
- Les contacts sont maintenant identifiés à l’aide d’un prénom, d’un nom et d’un nom de société
- La fonction de recherche pour les contacts peut s’effectuer sur le prénom, le nom ou le nom de la société d’un contact
- Le champ anciennement libellé “Société” a été renommé en “Société associée” pour plus de clarté
- La sélection d’une affaire par défaut sur la page détails d’une société est maintenant masquée lorsque la société ne possède aucune affaire
- La création d’affaire par les administrateurs a été revue. Lorsque un administrateur sélectionne une société, seuls les contacts associés à cette société sont disponibles. Lorsque l’administrateur séletionne un utilisateur, seuls les utilisateurs solos sont disponibles ainsi que leurs contacts respectifs
- Toujours dans la création d’affaire par les administrateurs, lorsqu’une société est sélectionnée, la sélection d’un utilisateur déselectionne automatiquement la société précédemment sélectionnée et inversément.
- Lorsque une affaire est mise à jour par un administrateur et que celle-ci est associée à un autre utilisateur ou à une autre société, l’affaire par défaut de sa précédente société est réinitialisée
- Résolu un bug dont la particularité était de ne mettre à jour qu’une partie des informations d’une affaire dans la vue des affaires (vue administrateurs seulement)
- Les utilisateurs associés à une société peuvent maintenant sélectionner un contact par défaut pour leur affaire par défaut. Celle-ci sera automatiquement sélectionnée à la création d’une nouvelle commande
- Les affaires et les contacts sont maintenant filtrés correctement sur la page de gestion de commande pour les administrateurs
- Réglé un bug qui empêchait les utilisateurs solo de sélectionner une affaire leur appartenant