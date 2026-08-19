# Guide de Responsivité - SOMAF

Ce guide explique comment utiliser les styles responsifs dans le projet SOMAF.

## 🎯 Objectif
Rendre complètement responsif le projet SOMAF pour tous les appareils (mobile, tablette, desktop).

## 📱 Points de Rupture (Breakpoints)

- **Mobile**: < 480px
- **Tablette**: 480px - 768px  
- **Desktop**: > 768px
- **Grand écran**: > 1024px

## ✅ Améliorations Apportées

### 1. Navigation Mobile
- **Menu Hamburger** : Automatique sur mobile (< 768px)
- **Toggle Button** : Affiche/masque le menu
- **Fermeture automatique** : Le menu se ferme en cliquant un lien

```php
<!-- Le header.php inclut désormais le menu burger -->
<!-- Aucun changement nécessaire - c'est automatique ! -->
```

### 2. Grilles Responsives
Les grilles utilisent `grid-template-columns: repeat(auto-fit, minmax(...))` qui s'adaptent automatiquement :

- **Desktop** : Affiche le nombre de colonnes original
- **Tablette** : 2 colonnes
- **Mobile** : 1 colonne (full width)

```php
<!-- Avant (pas responsive) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">

<!-- Le CSS s'adapte automatiquement ! Aucun changement nécessaire -->
```

### 3. Tableaux Responsifs
Les tableaux sont maintenant scrollables horizontalement sur mobile :

```php
<!-- Wrapper pour tableau -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Colonne 1</th>
                <th>Colonne 2</th>
                <th>Colonne 3</th>
            </tr>
        </thead>
        <tbody>
            <!-- Contenu -->
        </tbody>
    </table>
</div>
```

### 4. Boutons Responsifs
Les boutons s'ajustent automatiquement en taille sur mobile :

```php
<!-- Bouton normal -->
<a href="#" class="btn btn-primary">Bouton</a>

<!-- Bouton block (pleine largeur) -->
<a href="#" class="btn btn-primary btn-block">Bouton pleine largeur</a>

<!-- Groupe de boutons -->
<div class="btn-group">
    <a href="#" class="btn btn-primary">Bouton 1</a>
    <a href="#" class="btn btn-secondary">Bouton 2</a>
</div>
```

### 5. Formulaires Responsifs
Les champs de formulaire occupent 100% de la largeur sur mobile :

```php
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control">
</div>

<!-- Plusieurs champs côte à côte (tablette/desktop) -->
<div class="form-row">
    <div class="form-group">
        <label>Champ 1</label>
        <input type="text">
    </div>
    <div class="form-group">
        <label>Champ 2</label>
        <input type="text">
    </div>
</div>
```

### 6. Images Responsives
Les images s'ajustent automatiquement :

```html
<!-- Les images occupent 100% de la largeur max -->
<img src="image.jpg" alt="Description">
```

### 7. Cartes (Cards)
Les cartes s'adaptent automatiquement sur mobile :

```php
<div class="card" style="padding: 1.5rem;">
    <h2>Titre</h2>
    <p>Contenu</p>
    <a href="#" class="btn btn-primary">Action</a>
</div>
```

### 8. Badges et Alertes
S'ajustent en taille sur petits écrans :

```php
<!-- Badge -->
<span class="badge badge-success">Disponible</span>

<!-- Alerte -->
<div class="alert alert-success">Message de succès</div>
```

## 🎨 Classes CSS Utiles

### Visibility
```css
.hide-mobile { /* Caché sur mobile, visible sur desktop */ }
.show-mobile { /* Visible sur mobile, caché sur desktop */ }
```

### Grille
```css
.grid { /* Conteneur grille */ }
.grid-cols-1 { /* 1 colonne */ }
.grid-cols-2 { /* 2 colonnes */ }
.grid-cols-3 { /* 3 colonnes */ }
.grid-cols-4 { /* 4 colonnes */ }
```

### Flexbox
```css
.flex { /* Flexbox */ }
.flex-col { /* Direction colonne */ }
.flex-wrap { /* Wrap les éléments */ }
.gap-2, .gap-3, .gap-4 { /* Espacement */ }
```

### Espacement
```css
.mt-4, .mb-4 { /* Margin top/bottom */ }
.mt-6, .mb-6 { /* Plus grand margin */ }
.p-4 { /* Padding */ }
.text-center, .text-right { /* Alignement */ }
```

## 📋 Exemple Complet - Page Dashboard

```php
<?php include '../templates/header.php'; ?>

<!-- Bienvenue -->
<div class="card welcome-card">
    <h1>Bienvenue, <?php echo prenom_utilisateur(); ?> !</h1>
    <p>Vous êtes connecté en tant que <?php echo $_SESSION['poste']; ?></p>
</div>

<!-- Statistiques (grille responsive) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card stat-card" style="border-left: 4px solid #0284c7;">
        <div class="stat-label">Emprunts en cours</div>
        <div class="stat-number"><?php echo $count; ?></div>
    </div>
    <!-- Autres cartes... -->
</div>

<!-- Actions rapides -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card action-card">
        <i class="fas fa-hand-paper"></i>
        <h3>Emprunter</h3>
        <p>Matériel disponible</p>
        <a href="materiel.php" class="btn btn-primary btn-block">Consulter</a>
    </div>
    <!-- Autres actions... -->
</div>

<!-- Tableau -->
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

## 🚀 Tailles Adaptées par Écran

### Mobile (< 480px)
- Font size: 90% de la normal
- Padding: 0.75rem / 0.5rem
- Tableaux: Scrollable horizontalement
- Grilles: 1 colonne
- Menu: Hamburger

### Tablette (480px - 768px)
- Font size: 95% de la normal
- Padding: 1rem / 0.75rem
- Grilles: 2 colonnes
- Menu: Hamburger

### Desktop (> 768px)
- Font size: 100% (normal)
- Padding: 1.5rem / 1rem
- Grilles: Responsive auto-fit
- Menu: Horizontal complet

## 💡 Conseils

1. **Toujours tester sur mobile** : Utilisez les outils dev browser (F12)
2. **Utiliser max-width pour les conteneurs** : Limite la largeur sur grands écrans
3. **Éviter les largeurs fixes** : Préférer % ou max-width
4. **Tester sur vrais appareils** : Pas seulement le browser
5. **Images optimisées** : Compresser et redimensionner les images

## 🔧 Fichiers Modifiés

- `style.css` : Ajout des media queries complètes
- `templates/header.php` : Menu mobile responsive
- `connexion.php` : Formulaire responsive
- Toutes les pages PHP utilisent automatiquement les styles responsifs

## 📞 Besoin d'Aide ?

Tous les styles responsive sont dans `style.css`. Les media queries sont organisées par sections :
- 0-480px : Très petits écrans
- 480-768px : Tablettes et petits mobiles
- 768px+ : Desktop

---

**Dernière mise à jour** : 2024
**Status** : ✅ Complètement responsive
