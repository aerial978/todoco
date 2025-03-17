
# Guide de Collaboration et de Développement

## Introduction
Le projet Symfony met en avant une collaboration efficace entre les membres de l'équipe de développement. Ce document vise à fournir des directives claires sur la manière d'apporter des modifications au projet, en mettant l'accent sur le processus de qualité et les règles à respecter.

## Collaboration

### Gestion de versions

Le projet utilise un système de gestion de versions, tel que Git, pour assurer un suivi efficace des modifications apportées au code source. Tous les développeurs sont invités à travailler sur des branches distinctes pour leurs fonctionnalités ou corrections.

#### Clonage du projet

Dans GitHub.com, accédez à la page principale du repository et au-dessus de la liste des fichiers, 
Copie de l’URL du repository en cliquant sur <> Code et en sélectionnant le lien HTTPS ou SSH :

https://github.com/github/docs.git

Ouvrir Git Bash et se placer dans le répertoire dédié au clonage du repository.

Taper git clone et collez l’URL copiée précédemment.

```bash
    git clone https://github.com/YOUR-USERNAME/YOUR-REPOSITORY
```

#### Création de milestones et issues

Dans Github.com, avant chaque création de branche, créer un milestone ou une issue pour détailler les objectifs de la fonctionnalité ou de la correction.

#### Création d’une branche en local

Établir une norme de nommage claire pour la création des branches Git localement, par exemple, utiliser un préfixe indiquant le type de la fonctionnalité ou de la correction (ex : feature/nom_de_la_feature ou bugfix/nom_de_la_correction).

#### Nommage des Commits

Instaurer une norme pour les libellés de commits en anglais avec un suffixe indiquant la nature du commit (ex : [feat] Ajouter une nouvelle fonctionnalité ou [fix] Corriger un bug).

#### Commandes Git de base

Exemple : 

Ajout des modifications à l'index (staging area) en préparation d'un commit.

```bash
    git add README.md
```

Aperçu rapide des changements apportés au répertoire de travail.

```bash
    git status
```

Création d’un nouveau commit avec les modifications de l'index et ajout d’un message descriptif.

```bash
    git commit -m "I added text to the README file"
```

Envoi du commit local vers un dépôt distant (Github.com)

```bash
    git push origin example-tutorial-branch
```

### Pull Requests

Avant d'intégrer des modifications dans la branche principale, chaque développeur doit créer une Pull Request. Cela permet une revue du code par les pairs, favorisant la qualité du code.

### Revue de Code

Chaque Pull Request doit être examinée par au moins un autre développeur. Les commentaires constructifs et les suggestions d'amélioration sont encouragés pour garantir un code de qualité.

## Processus de qualité

### Tests Automatisés

Tout code ajouté doit être accompagné de tests appropriés. Les tests assurent la stabilité du projet et la détection rapide des erreurs.

### Normes de Codage

Les développeurs sont tenus de suivre les normes de codage définies dans le projet. 

## Règles à Respecter

### Branches Protégées

La branche principale est protégée, ce qui signifie que les modifications ne peuvent être fusionnées qu'après une revue de code réussie.

### Documentation

Toute nouvelle fonctionnalité doit être accompagnée d'une mise à jour de la documentation (README). La documentation doit être complète et explicite.

### Communication

Les développeurs sont encouragés à communiquer régulièrement sur les modifications apportées et à signaler tout problème rencontré.

# Conclusion

Ce guide a pour but de faciliter une collaboration harmonieuse et de maintenir la qualité du code au sein d'un projet Symfony. En suivant ces directives, nous contribuons à créer un environnement de développement robuste et efficace.