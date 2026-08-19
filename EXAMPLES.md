# 📱 Exemples de Responsive Design - SOMAF

Ce fichier contient des exemples pratiques pour rendre vos pages responsive.

## ✅ Exemple 1: Page Dashboard Responsive

```php
<?php include '../templates/header.php'; ?>

<!-- 1️⃣ Carte de bienvenue -->
<div class="card welcome-card">
    <h1>Bienvenue, <?php echo prenom_utilisateur(); ?> !</h1>
    <p>Connecté en tant que <?php echo $_SESSION['poste']; ?></p>
</div>

<!-- 2️⃣ Statistiques (grid responsive) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card stat-card" style="border-left: 4px solid #0284c7;">
        <div class="stat-label">Emprunts en cours</div>
        <div class="stat-number">5</div>
    </div>
    
    <div class="card stat-card" style="border-left: 4px solid #eab308;">
        <div class="stat-label">Demandes attente</div>
        <div class="stat-number">2</div>
    </div>
</div>

<!-- 3️⃣ Actions rapides (grid responsive) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card action-card">
        <i class="fas fa-hand-paper"></i>
        <h3>Emprunter</h3>
        <p>Matériel disponible</p>
        <a href="materiel.php" class="btn btn-primary btn-block">Consulter</a>
    </div>
    
    <div class="card action-card">
        <i class="fas fa-undo-alt"></i>
        <h3>Retourner</h3>
        <p>Vos emprunts</p>
        <a href="retourner.php" class="btn btn-success btn-block">Retourner</a>
    </div>
</div>

<!-- 4️⃣ Tableau responsive -->
<div class="card">
    <h2>Mes emprunts</h2>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Matériel</th>
                    <th>Date emprunt</th>
                    <th>Retour prévu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contenu -->
            </tbody>
        </table>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
```

## ✅ Exemple 2: Page Formulaire Responsive

```php
<?php include '../templates/header.php'; ?>

<div class="card" style="padding: 2rem; max-width: 600px; margin: 0 auto;">
    <h1 style="text-align: center;">Ajouter du matériel</h1>
    
    <form method="POST">
        <!-- Champ simple -->
        <div class="form-group">
            <label for="nom">Nom du matériel</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <!-- Deux champs côte à côte (desktop), empilés (mobile) -->
        <div class="form-row">
            <div class="form-group">
                <label for="marque">Marque</label>
                <input type="text" id="marque" name="marque">
            </div>
            
            <div class="form-group">
                <label for="modele">Modèle</label>
                <input type="text" id="modele" name="modele">
            </div>
        </div>
        
        <!-- Textarea -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-family: inherit;"></textarea>
        </div>
        
        <!-- Groupe de boutons -->
        <div class="btn-group" style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Ajouter</button>
            <a href="inventory.php" class="btn btn-secondary" style="flex: 1; text-align: center;">Annuler</a>
        </div>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
```

## ✅ Exemple 3: Page Liste Responsive

```php
<?php include '../templates/header.php'; ?>

<div class="card">
    <h2 style="margin-bottom: 1.5rem;">Liste des emprunts</h2>
    
    <!-- Barre de recherche responsive -->
    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; margin-bottom: 1.5rem;">
        <input type="text" placeholder="Rechercher..." style="padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        <button class="btn btn-primary" style="white-space: nowrap;">Rechercher</button>
    </div>
    
    <!-- Tableau scrollable -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Matériel</th>
                    <th>Date départ</th>
                    <th>Retour prévu</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pierre Martin</td>
                    <td>Perceuse</td>
                    <td>15/01/2024</td>
                    <td>20/01/2024</td>
                    <td><span class="badge badge-success">En cours</span></td>
                    <td>
                        <a href="#" class="btn btn-small" style="font-size: 0.75rem;">Éditer</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
```

## ✅ Exemple 4: Page Admin Dashboard Responsive

```php
<?php include '../templates/header.php'; ?>

<!-- Titre -->
<h1 style="margin-bottom: 2rem;">Tableau de bord Administrateur</h1>

<!-- Statistiques (4 colonnes desktop, 2 tablette, 1 mobile) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card stat-card" style="border-left: 4px solid #0284c7;">
        <div class="stat-label">Utilisateurs</div>
        <div class="stat-number">42</div>
    </div>
    
    <div class="card stat-card" style="border-left: 4px solid #16a34a;">
        <div class="stat-label">Matériel</div>
        <div class="stat-number">156</div>
    </div>
    
    <div class="card stat-card" style="border-left: 4px solid #eab308;">
        <div class="stat-label">Emprunts actifs</div>
        <div class="stat-number">28</div>
    </div>
    
    <div class="card stat-card" style="border-left: 4px solid #dc2626;">
        <div class="stat-label">Pannes</div>
        <div class="stat-number">5</div>
    </div>
</div>

<!-- Deux sections côte à côte (desktop), empilées (mobile) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <!-- Section 1: Derniers emprunts -->
    <div class="card" style="padding: 1.5rem;">
        <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Derniers emprunts</h2>
        <div class="table-wrapper">
            <table style="font-size: 0.875rem;">
                <!-- Tableau -->
            </table>
        </div>
    </div>
    
    <!-- Section 2: Activité -->
    <div class="card" style="padding: 1.5rem;">
        <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Activité</h2>
        <ul style="list-style: none; padding: 0;">
            <li style="padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <strong>Pierre Martin</strong> a emprunté une perceuse
                <div style="font-size: 0.8rem; color: #6b7280;">Il y a 2 heures</div>
            </li>
        </ul>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
```

## 🎯 Bonnes Pratiques

### 1. Grilles Responsive
```php
<!-- Automatique: 1 col (mobile), 2 col (tablet), 3+ col (desktop) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
    <div class="card">...</div>
</div>
```

### 2. Images Responsive
```html
<!-- Les images s'adaptent automatiquement -->
<img src="image.jpg" alt="Description" style="max-width: 100%; height: auto;">

<!-- Ou simplement: -->
<img src="image.jpg" alt="Description">
```

### 3. Conteneurs Max-Width
```php
<!-- Limite la largeur sur les grands écrans -->
<div style="max-width: 600px; margin: 0 auto;">
    Contenu centré sur écran large
</div>
```

### 4. Espacements Adaptatifs
```css
/* Automatique avec media queries */
padding: 2rem 1.5rem; /* Desktop */
/* Devient 1rem 1rem sur mobile (via CSS) */
```

### 5. Tableaux Scrollables
```php
<!-- Utiliser .table-wrapper pour scroll horizontal sur mobile -->
<div class="table-wrapper">
    <table>...</table>
</div>
```

### 6. Boutons Flexibles
```php
<!-- Groupe de boutons responsive -->
<div class="btn-group">
    <a href="#" class="btn btn-primary">Bouton 1</a>
    <a href="#" class="btn btn-secondary">Bouton 2</a>
</div>
```

## 📱 Tailles de Référence

```
Mobile:      0 - 480px   (téléphones)
Mini:        480 - 640px (petites tablettes)
Tablet:      640 - 1024px (tablettes)
Desktop:     1024px+     (ordinateurs)
```

## 🚨 À Éviter

❌ Largeurs fixes (ex: `width: 800px`)
❌ Overflow sans scroll
❌ Texte trop petit sur mobile
❌ Images non optimisées
❌ Boutons trop petits
❌ Grilles avec trop de colonnes

## ✅ À Faire

✅ Utiliser `max-width` au lieu de `width`
✅ Utiliser `grid-template-columns: repeat(auto-fit, minmax(...))`
✅ Mettre `padding: 0.75rem` sur mobile
✅ Tester sur vrais appareils
✅ Utiliser `font-size: 1rem` minimum
✅ Ajouter `class="table-wrapper"` aux tableaux

---

Pour plus de détails, consultez [RESPONSIVE.md](RESPONSIVE.md)
