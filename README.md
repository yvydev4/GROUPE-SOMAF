# ðŸ“‹ Projet SOMAF - Gestion du Parc Matü©riel

## ✨ Version Responsive Complète

> **🎉 Le projet est maintenant ENTIÈREMENT RESPONSIVE pour mobile, tablette et desktop !**

Voir la documentation :
- 📱 [Guide Responsive](RESPONSIVE.md) - Tout ce que vous devez savoir
- 💡 [Exemples de Code](EXAMPLES.md) - Exemples prêts à copier-coller
- 📈 [Changelog](CHANGELOG.md) - Résumé de tous les changements

## 🎯 Caractéristiques Responsive

✅ Navigation mobile avec menu hamburger  
✅ Grilles 100% responsives  
✅ Tableaux scrollables sur mobile  
✅ Formulaires adaptés mobile  
✅ Images et contenu optimisés  
✅ Buttons et badges adaptatifs  
✅ Footer responsive  
✅ Compatible tous navigateurs  

## 📱 Tester sur Mobile

- Ouvrir avec F12 → Toggle device toolbar (Ctrl+Shift+M)
- Ou tester sur vrais appareils (iPhone, Android, iPad)
- Tous les breakpoints testés : 480px, 768px, 1024px

---

## Plan de Développement Complet


## âœ… ü‰TAPE 1 : Configuration de Base (ü€ faire)

### 1.1 - Crü©er `config.php`
- Connexion ü  la base de donnü©es MySQL
- Dü©marrage de la session
- **Fonctions utilitaires** (avec des noms COHü‰RENTS en franü§ais) :
  - `connecte()` - Vü©rifier si utilisateur connectü©
  - `est_admin()` - Vü©rifier si admin
  - `est_employe()` - Vü©rifier si employü©
  - `est_mecanicien()` - Vü©rifier si mü©canicien
  - `est_charge_materiel()` - Vü©rifier si chargü© du matü©riel
  - `exiger_connexion()` - Rediriger si pas connectü©
  - `echapper()` - Protü©ger l'affichage HTML
  - `lire_post()` - Lire formulaire POST
  - `lire_get()` - Lire URL GET
  - `rediriger()` - Redirection avec header()
- **Vü©rification utilisateur** - ü€ chaque page, vü©rifier que l'utilisateur existe toujours

### 1.2 - Crü©er `database.sql`
Tables ü  crü©er :
- **users** (id, nom, email, password, role, poste, statut, invitation_token, token_expiration, created_at)
- **equipment** (id, nom, matricule, categorie, etat, description, photo, created_at)
- **loans** (id, equipment_id, user_id, date_emprunt, date_retour_prevue, date_retour_reel, statut, motif, site_info, validated_by, validated_at, return_validated_by, return_validated_at, created_at)
- **notifications** (id, user_id, loan_id, type, titre, message, lu, created_at)
- **postes** (id, nom)

### 1.3 - Crü©er `index.php`
- Si connectü© â†’ rediriger vers son tableau de bord (admin/dashboard.php, employe/dashboard.php, etc.)
- Si pas connectü© â†’ rediriger vers connexion.php

---

## âœ… ü‰TAPE 2 : Authentification (ü€ faire)

### 2.1 - Crü©er `connexion.php`
- Formulaire de connexion (email + mot de passe)
- Vü©rifier les identifiants
- Crü©er session utilisateur
- Vü©rifier le statut (actif/invitation_pending)
- Si statut = invitation_pending â†’ rediriger vers accepter_invitation.php

### 2.2 - Crü©er `accepter_invitation.php`
- Afficher le message "Bienvenue, vous devez accepter l'invitation"
- Formulaire : nouveau mot de passe (minimum 8 caractü¨res)
- Vü©rifier le token d'invitation
- Mettre ü  jour le mot de passe et passer le statut ü  "actif"

### 2.3 - Crü©er `deconnexion.php`
- Dü©truire la session
- Rediriger vers connexion.php

---

## âœ… ü‰TAPE 3 : Interface ADMIN (ü€ faire)

### 3.1 - Crü©er `admin/dashboard.php`
- Afficher statistiques :
  - Total matü©riel
  - Total disponible / empruntü© / en panne / en maintenance / hors service
  - Demandes d'emprunt en attente
  - Retours en attente
- Afficher les 5 derniers emprunts en cours

### 3.2 - Crü©er `admin/utilisateurs.php`
- Liste de tous les utilisateurs
- Formulaire pour **crü©er un nouvel utilisateur** :
  - Nom complet
  - Email (unique)
  - Rü´le (admin / employe)
  - Poste (Employü© / Mü©canicien / Chargü© du matü©riel / Technicien)
  - Statut (actif / invitation_pending)
  - Bouton "Crü©er" = gü©nü©rer token invitation + envoyer email (OU afficher le lien)
- Boutons : ü‰diter / Supprimer / Activer-Dü©sactiver
- ü‰diter un utilisateur : changer poste, statut, etc.

### 3.3 - Crü©er `admin/materiel.php`
- Liste de tous les ü©quipements
- Filtres : par catü©gorie, par ü©tat
- Colonnes : Nom, Matricule, Catü©gorie, ü‰tat, Actions
- Bouton "Ajouter du matü©riel"

### 3.4 - Crü©er `admin/materiel_ajouter.php`
- Formulaire pour ajouter matü©riel :
  - Nom (obligatoire)
  - Matricule (auto-gü©nü©rü© : SMF-XXNNNN)
  - Catü©gorie (liste dü©roulante)
  - ü‰tat (par dü©faut = disponible)
  - Description
  - Photo (upload fichier)
- Boutons : Enregistrer / Annuler
- Redirection vers materiel.php

### 3.5 - Crü©er `admin/materiel_editer.php`
- Formulaire pour modifier matü©riel (id en GET)
- Prü©fill les champs actuels
- Permettre changer photo
- Redirection vers materiel.php

### 3.6 - Crü©er `admin/materiel_supprimer.php`
- Confirmation avant suppression
- Supprimer le matü©riel
- Redirection vers materiel.php

### 3.7 - Crü©er `admin/emprunts.php`
- Liste de tous les emprunts
- Filtres : par statut (en_attente, en_cours, refuse, retour_demande, termine)
- Colonnes : #, Matü©riel, Employü©, ü‰tat, Date emprunt, Date retour prü©vue, Actions
- Bouton "Voir dü©tails" pour chaque emprunt

### 3.8 - Crü©er `admin/emprunts_details.php`
- Afficher les dü©tails d'un emprunt (id en GET)
- Si statut = en_attente â†’ boutons "Accepter" / "Refuser"
  - Accepter : statut = en_cours, materiel.etat = emprunte, crü©er notification
  - Refuser : statut = refuse, crü©er notification
- Si statut = retour_demande â†’ bouton "Valider le retour"
  - Afficher formulaire : ü‰tat final du matü©riel (disponible / panne / en_maintenance / hors_service)
  - Mettre ü  jour loan.statut = termine, equipment.etat, crü©er notification

### 3.9 - Crü©er `admin/notifications.php`
- Afficher les notifications de l'admin
- Marquer comme "lu"

### 3.10 - Crü©er `admin/template_header.php`
- Barre de navigation avec :
  - Logo SOMAF
  - Nom utilisateur + "Dü©connexion"
  - Menu : Tableau de bord / Matü©riel / Emprunts / Utilisateurs / Notifications

### 3.11 - Crü©er `admin/template_footer.php`
- Footer simple

---

## âœ… ü‰TAPE 4 : Interface EMPLOYE (ü€ faire)

### 4.1 - Crü©er `employe/dashboard.php`
- Afficher statistiques :
  - Total matü©riel disponible
  - Mes emprunts en cours
  - Mes emprunts terminü©s
- Afficher mes 5 derniers emprunts

### 4.2 - Crü©er `employe/materiel.php`
- Liste du matü©riel **disponible uniquement**
- Filtres : par catü©gorie
- Colonnes : Nom, Matricule, Catü©gorie, Photo, Description, Bouton "Emprunter"
- Lien vers emprunter_materiel.php?id=XXX

### 4.3 - Crü©er `employe/emprunter_materiel.php`
- Afficher dü©tails du matü©riel (id en GET)
- Formulaire de demande d'emprunt :
  - Date d'emprunt (par dü©faut = aujourd'hui)
  - Date de retour prü©vue (facultatif, > date emprunt)
  - **Motif de l'emprunt** (obligatoire)
  - **Informations du site** (obligatoires) :
    - Nom du site
    - Adresse
    - Ville
    - Catü©gorie de site
- Vü©rifier qu'un emprunt actif n'existe pas dü©jü  pour ce matü©riel
- Boutons : Envoyer demande / Annuler
- Crü©er : loan avec statut = en_attente
- Crü©er notification admin
- Redirection vers dashboard.php?success=demande_envoyee

### 4.4 - Crü©er `employe/emprunts.php`
- Liste de mes emprunts (filtrü©s par user_id)
- Filtres : par statut
- Colonnes : Matü©riel, Date emprunt, Date retour prü©vue, ü‰tat, Actions
- Boutons actions selon le statut :
  - Si en_cours â†’ "Demander le retour"
  - Si retour_demande â†’ Message "Retour demandü©, en attente de validation"
  - Si termine â†’ "Voir dü©tails"

### 4.5 - Crü©er `employe/emprunts_detendre_retour.php`
- Formulaire de demande de retour (id en GET)
- Vü©rifier que loan.statut = en_cours et user_id = moi
- Champ optionnel : "Commentaire au retour"
- Boutons : Demander retour / Annuler
- Mettre ü  jour : loan.statut = retour_demande, return_requested_at = NOW()
- Crü©er notification chargü©_materiel et admin
- Redirection vers emprunts.php?success=retour_demande

### 4.6 - Crü©er `employe/notifications.php`
- Afficher mes notifications
- Marquer comme "lu"

### 4.7 - Crü©er `employe/template_header.php` et `footer.php`
- Barre navigation similaire ü  admin

---

## âœ… ü‰TAPE 5 : Interface MECANICIEN (ü€ faire)

### 5.1 - Crü©er `mecanicien/dashboard.php`
- Afficher statistiques :
  - Total matü©riel en panne
  - Interventions en cours
- Afficher liste matü©riel en panne

### 5.2 - Crü©er `mecanicien/materiel_panne.php`
- Liste matü©riel avec ü©tat = "panne"
- Colonnes : Nom, Matricule, ü‰tat, Date signalement, Bouton "Intervenir"
- Lien vers materiel_intervenir.php?id=XXX

### 5.3 - Crü©er `mecanicien/materiel_intervenir.php`
- Afficher dü©tails du matü©riel (id en GET)
- Formulaire d'intervention :
  - ü‰tat final du matü©riel (radio buttons) :
    - Disponible (rü©paration complü¨te)
    - Hors service (non rü©parable)
  - Commentaire (optionnel)
- Boutons : Valider l'intervention / Annuler
- Mettre ü  jour : equipment.etat = ü©tat choisi
- Crü©er notification admin
- Redirection vers materiel_panne.php?success=intervention

### 5.4 - Crü©er `mecanicien/template_header.php` et `footer.php`

---

## âœ… ü‰TAPE 6 : Interface CHARGE_MATERIEL (ü€ faire)

### 6.1 - Crü©er `charge_materiel/dashboard.php`
- Afficher statistiques :
  - Retours en attente de validation
  - Retours validü©s ce mois-ci
- Afficher liste retours en attente

### 6.2 - Crü©er `charge_materiel/retours_attente.php`
- Liste emprunts avec statut = "retour_demande"
- Colonnes : Matü©riel, Employü©, Date emprunt, Date retour prü©vue, Bouton "Valider le retour"
- Lien vers retours_valider.php?id=XXX

### 6.3 - Crü©er `charge_materiel/retours_valider.php`
- Afficher dü©tails de l'emprunt (id en GET)
- Vü©rifier que loan.statut = retour_demande
- Formulaire de validation :
  - ü‰tat final du matü©riel (radio buttons) :
    - Disponible
    - En panne
    - En maintenance
    - Hors service
  - Commentaire (optionnel)
- Boutons : Valider le retour / Annuler
- Mettre ü  jour : 
  - loan.statut = termine
  - loan.date_retour_reel = aujourd'hui
  - loan.return_validated_by = moi
  - loan.return_validated_at = NOW()
  - equipment.etat = ü©tat choisi
- Crü©er notifications : employü© + admin
- Redirection vers retours_attente.php?success=retour_valide

### 6.4 - Crü©er `charge_materiel/template_header.php` et `footer.php`

---

## âœ… ü‰TAPE 7 : Fichiers Utilitaires (ü€ faire)

### 7.1 - Crü©er `templates/header.php`
- Inclus au dü©but de chaque page
- Affiche la barre de navigation adaptü©e au rü´le

### 7.2 - Crü©er `templates/footer.php`
- Inclus ü  la fin de chaque page

### 7.3 - Crü©er `templates/photo_upload.php`
- Composant rü©utilisable pour upload photo

### 7.4 - Crü©er `style.css` (Tailwind CSS)
- **Couleurs personnalisü©es** :
  - Primary (bleu foncü©) : #1e3a8a
  - Secondary (orange) : #FF8C00
  - Success (vert) : #16a34a
  - Danger (rouge) : #dc2626
  - Warning (jaune) : #eab308
- **Classes utiles** :
  - `.card` - Carte blanche
  - `.btn` - Bouton standard
  - `.btn-primary`, `.btn-danger`, `.btn-success`
  - `.badge-*` - Badges pour statuts
  - `.table` - Tableau
  - `.form-*` - ü‰lü©ments formulaire

---

## âœ… ü‰TAPE 8 : Donnü©es de Test (ü€ faire)

### 8.1 - Crü©er `seeds.sql`
- Insü©rer utilisateurs de test :
  - 1 Admin (admin@somaf.com)
  - 3 Employü©s
  - 1 Mü©canicien
  - 1 Chargü© du matü©riel
- Insü©rer matü©riel de test (10 ü©quipements variü©s)
- Insü©rer emprunts de test
- Insü©rer notifications de test

---

## âœ… ü‰TAPE 9 : Style Tailwind CSS (ü€ faire)

### 9.1 - Configuration Tailwind
- Utiliser Tailwind CSS CDN (pour simplicitü©)
- Personnaliser les couleurs
- Crü©er des composants rü©utilisables (buttons, cards, tables)

### 9.2 - Design responsif
- Mobile-first
- Breakpoints : sm, md, lg, xl
- Navbar adaptü©e mobile/desktop

---

## ðŸ“ Rü©sumü© des Fichiers ü  Crü©er

**Fichiers principaux :**
```
Somaf/
â”œâ”€â”€ config.php                          (configuration + fonctions)
â”œâ”€â”€ database.sql                        (schü©ma + donnü©es de test)
â”œâ”€â”€ index.php                           (accueil, redirection)
â”œâ”€â”€ connexion.php                       (login)
â”œâ”€â”€ accepter_invitation.php             (accepter invitation)
â”œâ”€â”€ deconnexion.php                     (logout)
â”œâ”€â”€ style.css                           (Tailwind CSS)
â”‚
â”œâ”€â”€ admin/
â”‚   â”œâ”€â”€ dashboard.php
â”‚   â”œâ”€â”€ utilisateurs.php
â”‚   â”œâ”€â”€ materiel.php
â”‚   â”œâ”€â”€ materiel_ajouter.php
â”‚   â”œâ”€â”€ materiel_editer.php
â”‚   â”œâ”€â”€ materiel_supprimer.php
â”‚   â”œâ”€â”€ emprunts.php
â”‚   â”œâ”€â”€ emprunts_details.php
â”‚   â”œâ”€â”€ notifications.php
â”‚   â””â”€â”€ template_*.php
â”‚
â”œâ”€â”€ employe/
â”‚   â”œâ”€â”€ dashboard.php
â”‚   â”œâ”€â”€ materiel.php
â”‚   â”œâ”€â”€ emprunter_materiel.php
â”‚   â”œâ”€â”€ emprunts.php
â”‚   â”œâ”€â”€ emprunts_demander_retour.php
â”‚   â”œâ”€â”€ notifications.php
â”‚   â””â”€â”€ template_*.php
â”‚
â”œâ”€â”€ mecanicien/
â”‚   â”œâ”€â”€ dashboard.php
â”‚   â”œâ”€â”€ materiel_panne.php
â”‚   â”œâ”€â”€ materiel_intervenir.php
â”‚   â””â”€â”€ template_*.php
â”‚
â”œâ”€â”€ charge_materiel/
â”‚   â”œâ”€â”€ dashboard.php
â”‚   â”œâ”€â”€ retours_attente.php
â”‚   â”œâ”€â”€ retours_valider.php
â”‚   â””â”€â”€ template_*.php
â”‚
â”œâ”€â”€ templates/
â”‚   â”œâ”€â”€ header.php
â”‚   â””â”€â”€ footer.php
â”‚
â””â”€â”€ assets/
    â””â”€â”€ (photos du matü©riel)
```

**Total : ~40 fichiers PHP**

---

## ðŸŽ¨ Principes de Code pour les Dü©butants

âœ… **Code trü¨s commentü©** - Chaque ligne expliquü©e
âœ… **Noms explicites** - Variables claires et en franü§ais
âœ… **Pas d'API** - Tout en PHP/MySQL pur
âœ… **Sü©curitü©** - prepared statements, password_hash, htmlspecialchars
âœ… **Responsive** - Tailwind CSS
âœ… **Simple** - Pas de frameworks complexes

---

## ðŸš€ Progression

- [ ] ü‰tape 1 : Config + DB
- [ ] ü‰tape 2 : Authentification
- [ ] ü‰tape 3 : Interface Admin
- [ ] ü‰tape 4 : Interface Employü©
- [ ] ü‰tape 5 : Interface Mü©canicien
- [ ] ü‰tape 6 : Interface Charge Matü©riel
- [ ] ü‰tape 7 : Utilitaires + Styles
- [ ] ü‰tape 8 : Donnü©es de test
- [ ] ü‰tape 9 : Tests complets

---

## ðŸ’¡ Notes Importantes

1. **Tokens d'invitation** : Gü©nü©rer un token unique, stocker avec expiration (24h)
2. **Photos** : Stocker en dossier `/assets/photos/`, avec chemin en base
3. **Notifications** : Crü©er automatiquement ü  chaque action importante
4. **Statuts** : actif, invitation_pending (en attente que l'utilisateur accepte l'invitation)
5. **ü‰tats matü©riel** : disponible, emprunte, panne, en_maintenance, hors_service
6. **Statuts emprunt** : en_attente, en_cours, refuse, retour_demande, termine

**LE CODE DOIT üŠTRE COMPRü‰HENSIBLE POUR UN Dü‰BUTANT - CHAQUE LIGNE EXPLIQUü‰E !**

