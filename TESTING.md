# 🧪 SOMAF - Plan de Test Complet

## 📋 Prérequis
- WAMP/XAMPP en cours d'exécution
- PHP 8.x activé
- MySQL 8.x avec base `somaf_materiel` créée et remplie
- Navigateur web (Chrome, Firefox, Safari)

---

## 🔐 Phase 1: Authentification

### Test 1.1: Connexion Admin
```
1. Aller à: http://localhost/Somaf/connexion.php
2. Entrer: 
   - Email: admin@somaf.fr
   - Mot de passe: password123
3. ✓ Vérifier: Redirection vers admin/dashboard.php
4. ✓ Vérifier: Navbar affiche menu admin
```

### Test 1.2: Connexion Employé
```
1. Déconnexion (clic bouton logout)
2. Aller à: http://localhost/Somaf/connexion.php
3. Entrer:
   - Email: pierre@somaf.fr
   - Mot de passe: password123
4. ✓ Vérifier: Redirection vers employe/dashboard.php
5. ✓ Vérifier: Navbar affiche menu employé
```

### Test 1.3: Identifiants Incorrects
```
1. Aller à: http://localhost/Somaf/connexion.php
2. Entrer email/password invalides
3. ✓ Vérifier: Message d'erreur affiché
4. ✓ Vérifier: Pas de redirection
```

### Test 1.4: Session Expirée
```
1. Connecté en tant que admin
2. Vider les cookies du navigateur (Dev Tools)
3. Rafraîchir http://localhost/Somaf/admin/dashboard.php
4. ✓ Vérifier: Redirection vers connexion.php
```

---

## 📦 Phase 2: Gestion du Matériel (Admin)

### Test 2.1: Liste du Matériel
```
1. Connecté en admin → Clic "admin/equipment.php"
2. ✓ Vérifier: Tableau affiche tous les équipements
3. ✓ Vérifier: Colonnes: Nom, Série, Catégorie, État, Date
4. ✓ Vérifier: Badges couleur pour états
```

### Test 2.2: Ajouter du Matériel
```
1. Admin → equipment.php → Clic "Ajouter du matériel"
2. Remplir:
   - Nom: Perceuse Bosch XYZ
   - Série: PERC-2024-001
   - Catégorie: Outils
   - Localisation: Hangar A
   - État: Disponible
3. Clic "Ajouter l'équipement"
4. ✓ Vérifier: Message succès affiché
5. ✓ Vérifier: Nouveau matériel dans le tableau
```

### Test 2.3: Rechercher Matériel
```
1. equipment.php
2. Entrer "perceuse" dans recherche
3. ✓ Vérifier: Filtre par nom
4. Essayer recherche par numéro de série
5. ✓ Vérifier: Fonctionnement
```

---

## 🤝 Phase 3: Gestion des Utilisateurs (Admin)

### Test 3.1: Liste Utilisateurs
```
1. Admin → users.php
2. ✓ Vérifier: Tableau avec tous les utilisateurs
3. ✓ Vérifier: Rôles et statuts affichés
```

### Test 3.2: Créer Utilisateur
```
1. Admin → users.php → "Créer un utilisateur"
2. Remplir:
   - Nom: Jean Dupont
   - Email: jean@somaf.fr
   - Rôle: Employé
   - Poste: Maçon
3. Clic "Créer l'utilisateur"
4. ✓ Vérifier: Message succès
5. ✓ Vérifier: Statut = "Invitation en attente"
6. ✓ Vérifier: Utilisateur dans la liste
```

---

## 📋 Phase 4: Système d'Emprunt

### Test 4.1: Employé Consulte Matériel
```
1. Connecté en tant que pierre@somaf.fr (Employé)
2. Clic "Matériel disponible" dans actions rapides
3. ✓ Vérifier: Grille de matériel disponible affichée
4. ✓ Vérifier: Filtres: catégorie, recherche
5. ✓ Vérifier: Bouton "Emprunter" sur chaque item
```

### Test 4.2: Demande d'Emprunt
```
1. Employé → materiel.php
2. Clic "Emprunter" sur un équipement
3. Remplir:
   - Date retour: +7 jours
   - Motif: Réparation du portail
4. Clic "Soumettre la demande"
5. ✓ Vérifier: Redirection vers emprunts.php
6. ✓ Vérifier: Message succès
7. ✓ Vérifier: Emprunt en statut "En attente"
```

### Test 4.3: Admin Valide Emprunt
```
1. Admin connecté → admin/loans.php
2. Filtre: "En attente" - voir la nouvelle demande
3. ✓ Vérifier: Emprunt de pierre affiche
4. Clic "Valider"
5. ✓ Vérifier: Statut change à "En cours"
6. ✓ Vérifier: État matériel passe à "Emprunté"
7. Quitter admin, se reconnecter en pierre
8. ✓ Vérifier: Emprunt visible dans "Mes emprunts"
```

### Test 4.4: Admin Refuse Emprunt
```
1. Faire une nouvelle demande d'emprunt (Employé)
2. Admin → loans.php → Filtre "En attente"
3. Clic "Refuser" sur la demande
4. ✓ Vérifier: Statut change à "Refusé"
5. ✓ Vérifier: État matériel reste "Disponible"
```

---

## 🔄 Phase 5: Retours de Matériel

### Test 5.1: Employé Demande Retour
```
1. Employé (pierre) → Clic "Retourner du matériel"
2. ✓ Vérifier: Liste emprunts en cours affichée
3. Clic "Retourner" sur un emprunt
4. Remplir observations: "Bon état"
5. Clic "Demander le retour"
6. ✓ Vérifier: Statut emprunt = "Retour demandé"
```

### Test 5.2: Chargé Matériel Valide Retour
```
1. Connecté chargé_materiel@somaf.fr
2. Clic "Valider les retours" dans actions rapides
3. ✓ Vérifier: Modal pour état du matériel
4. Sélectionner: "Bon état"
5. Clic "Valider le retour"
6. ✓ Vérifier: Statut emprunt = "Retourné"
7. ✓ Vérifier: État matériel = "Disponible"
```

### Test 5.3: Chargé Matériel Signale Panne
```
1. Nouveau retour demandé
2. Chargé matériel → retours.php
3. Sélectionner: "En panne - À réparer"
4. ✓ Vérifier: État matériel = "Panne"
5. ✓ Vérifier: Mécanicien voit dans son dashboard
```

---

## 🔧 Phase 6: Réparations (Mécanicien)

### Test 6.1: Vue Équipements en Panne
```
1. Mécanicien (marc@somaf.fr) connecté
2. ✓ Vérifier: Dashboard affiche équipements en panne
3. Clic "Équipements en panne"
4. ✓ Vérifier: Tableau/grille d'équipements panne
```

### Test 6.2: Enregistrer Intervention
```
1. Mécanicien → reparations.php → "Nouvelle intervention"
2. Sélectionner équipement en panne
3. Remplir:
   - Description: Vérifier moteur, nettoyage, huile neuve
   - État après: Réparé - Disponible
4. Clic "Enregistrer l'intervention"
5. ✓ Vérifier: Intervention enregistrée
6. ✓ Vérifier: État matériel = "Disponible"
7. ✓ Vérifier: Apparaît dans historique
```

---

## 🔔 Phase 7: Notifications

### Test 7.1: Créer Notifications
```
1. Admin effectue une action (valide emprunt)
2. ✓ Vérifier: Notification créée en BD
3. Connecté avec l'utilisateur affecté
4. Clic "Notifications" (badge affiche count)
5. ✓ Vérifier: Notification affichée
```

### Test 7.2: Marquer Comme Lu
```
1. Notifications → Voir notification non lue (badge rouge)
2. Clic sur la notification ou "Marquer comme lu"
3. ✓ Vérifier: Badge disparaît
4. ✓ Vérifier: Notification grisée
```

### Test 7.3: Tout Marquer Comme Lu
```
1. Plusieurs notifications non lues
2. Clic "Tout marquer comme lu"
3. ✓ Vérifier: Tous les badges disparus
4. ✓ Vérifier: Compteur = 0
```

---

## 📊 Phase 8: Rapports & Statistiques

### Test 8.1: Dashboard Admin
```
1. Admin → dashboard.php
2. ✓ Vérifier: Statistiques correctes (total, disponible, etc)
3. ✓ Vérifier: Grille derniers emprunts affichée
4. Clic "Voir détails" sur demandes
5. ✓ Vérifier: Redirection vers loans.php
```

### Test 8.2: Rapports
```
1. Admin → rapports.php
2. ✓ Vérifier: Cartes statistiques
3. ✓ Vérifier: Graphiques barres par catégorie
4. ✓ Vérifier: Top employés (emprunts)
5. ✓ Vérifier: Top matériel emprunté
```

### Test 8.3: Inventaire
```
1. Chargé matériel → inventaire.php
2. ✓ Vérifier: Stats par état affichées
3. Filtrer par état "En panne"
4. ✓ Vérifier: Tableau filtrée
5. Filtrer par catégorie
6. ✓ Vérifier: Fonctionne
```

---

## 🎨 Phase 9: UI/UX

### Test 9.1: Responsive Design
```
1. Ouvrir chaque page en desktop (1920px)
2. ✓ Vérifier: Layout lisible, pas overflow
3. Redimensionner à tablet (768px)
4. ✓ Vérifier: Grid se réadapte
5. Redimensionner à mobile (375px)
6. ✓ Vérifier: Stack vertical, lisible
```

### Test 9.2: Navbar
```
1. Clic sur logo/titre
2. ✓ Vérifier: Retourne à l'accueil approprié
3. Vérifier tous les liens du menu
4. ✓ Vérifier: Aucun lien cassé (404)
5. Badge notification affiche bon count
```

### Test 9.3: Formulaires
```
1. Tester validation client (laisser champ vide)
2. ✓ Vérifier: Message d'erreur navigateur
3. Essayer caractères spéciaux
4. ✓ Vérifier: Pas d'injection (affichage échappe)
5. Essayer très long texte
6. ✓ Vérifier: Textarea resize ok
```

---

## 🔐 Phase 10: Sécurité

### Test 10.1: XSS Prevention
```
1. Admin → users.php → Créer utilisateur
2. Nom: <script>alert('XSS')</script>
3. ✓ Vérifier: Script n'exécute pas
4. ✓ Vérifier: Affiché comme texte
```

### Test 10.2: SQL Injection Prevention
```
1. Aller à: http://localhost/Somaf/employe/materiel.php?search='; DROP TABLE equipment; --
2. ✓ Vérifier: Page fonctionne normalement
3. ✓ Vérifier: Requête sécurisée (pas d'erreur SQL)
4. ✓ Vérifier: Table equipment intacte
```

### Test 10.3: Autorisation
```
1. Employé connecté
2. Essayer accès manuel: /admin/users.php
3. ✓ Vérifier: Redirection (ou erreur 403)
4. Vérifier avec tous les rôles
```

---

## 🚀 Checklist Finale

- [ ] Aucune erreur PHP (pas de warnings)
- [ ] Aucune erreur JavaScript (console)
- [ ] Base de données synchronisée
- [ ] Tous les états matériel testés
- [ ] Tous les statuts emprunt testés
- [ ] Toutes les notifications fonctionnelles
- [ ] Tous les rôles testés
- [ ] Responsive design OK
- [ ] Aucune faille de sécurité visible
- [ ] Performances acceptables (< 1s chargement pages)

---

## 📝 Bugs Trouvés

| # | Severity | Component | Description | Status |
|---|----------|-----------|-------------|--------|
| B1 | High | X | Y | ☐ TODO |

---

## 📞 Notes

- Identifiants de test disponibles dans connexion.php
- Toutes les dates sont GMT+0 (vérifier fuseau horaire serveur)
- Emails d'invitation ne sont pas implémentés (placeholder)

---

**Date du test:** [À remplir]
**Testeur:** [Votre nom]
**Version testée:** 1.0-beta
