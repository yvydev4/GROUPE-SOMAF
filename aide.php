<?php
/**
 * AIDE.PHP - GUIDE UTILISATEUR ET FAQ
 * 
 * Centre d'aide complet accessible depuis toutes les pages
 * avec guides par rü´le et FAQ.
 */

require_once 'config.php';
exiger_connexion();

$page_active = 'aide';
$page_title = 'Centre d\'aide';

$role = $_SESSION['role'];

?>
<?php include 'templates/header.php'; ?>

<!-- Titre -->
<h1>
    <i class="fas fa-question-circle"></i>
    Centre d'aide SOMAF
</h1>
<p>
    Trouvez des réponses ü  vos questions et apprenez ü  utiliser l'application.
</p>

<!-- Navigation par onglet -->
<div>
    <button class="tab-btn" onclick="afficherOnglet('guide')">
        <i class="fas fa-book"></i> Guide utilisateur
    </button>
    <button class="tab-btn" onclick="afficherOnglet('faq')">
        <i class="fas fa-comments"></i> FAQ
    </button>
    <button class="tab-btn" onclick="afficherOnglet('contact')">
        <i class="fas fa-phone"></i> Support
    </button>
</div>

<!-- ONGLET 1: GUIDE -->
<div id="guide">
    <div>
        
        <!-- Guide Employé -->
        <?php if ($role === 'employe'): ?>
        <div class="card">
            <h2>
                <i class="fas fa-user-tie"></i>
                Guide Employé
            </h2>
            
            <div>
                
                <!-- ü?tape 1 -->
                <div>
                    <h3>1ï¸→?£ Consulter le matériel disponible</h3>
                    <p>
                        Allez dans <strong>"Matériel disponible"</strong> pour voir tous les équipements 
                        que vous pouvez emprunter. Vous pouvez filtrer par catégorie ou rechercher un matériel spécifique.
                    </p>
                </div>
                
                <!-- ü?tape 2 -->
                <div>
                    <h3>2ï¸→?£ Demander un emprunt</h3>
                    <p>
                        Cliquez sur <strong>"Emprunter"</strong> sur un équipement. Remplissez le formulaire:
                    </p>
                    <ul>
                        <li>ð??? <strong>Date retour:</strong> Quand vous prévoyez de le retourner</li>
                        <li>ð?? <strong>Motif:</strong> Pourquoi vous avez besoin du matériel</li>
                    </ul>
                    <p>
                        Votre demande sera envoyée ü  l'administrateur pour validation.
                    </p>
                </div>
                
                <!-- ü?tape 3 -->
                <div>
                    <h3>3ï¸→?£ Attendre la validation</h3>
                    <p>
                        L'admin validera votre demande. Vous recevrez une <strong>notification</strong> 
                        quand l'équipement sera prêt ü  emprunter. Consultez votre <strong>"Mes emprunts"</strong> 
                        pour suivre le statut.
                    </p>
                </div>
                
                <!-- ü?tape 4 -->
                <div>
                    <h3>4ï¸→?£ Retourner le matériel</h3>
                    <p>
                        Une fois terminé, allez dans <strong>"Retourner du matériel"</strong>, 
                        sélectionnez l'équipement et demandez le retour. Le chargé du matériel 
                        validera le retour et l'équipement redevendra disponible.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Guide Admin -->
        <?php elseif ($role === 'admin'): ?>
        <div class="card">
            <h2>
                <i class="fas fa-user-shield"></i>
                Guide Administrateur
            </h2>
            
            <div>
                
                <!-- Section Utilisateurs -->
                <div>
                    <h3>ð??¥ Gérer les utilisateurs</h3>
                    <p>
                        Dans <strong>"Utilisateurs"</strong>, vous pouvez créer de nouveaux comptes. 
                        L'utilisateur reçoit un email d'invitation (ou un lien si email non configuré) 
                        pour accepter l'invitation et créer son mot de passe.
                    </p>
                </div>
                
                <!-- Section Matériel -->
                <div>
                    <h3>ð??¦ Gérer le matériel</h3>
                    <p>
                        Dans <strong>"ü?quipements"</strong>, vous pouvez ajouter, modifier ou supprimer du matériel. 
                        Les états disponibles sont: Disponible, Emprunté, En panne, En maintenance, Hors service.
                    </p>
                </div>
                
                <!-- Section Emprunts -->
                <div>
                    <h3>→ Valider les emprunts</h3>
                    <p>
                        Dans <strong>"Emprunts"</strong>, vous voyez les demandes en attente. 
                        Validez (le matériel passe en "Emprunté") ou refusez (notification envoyée ü  l'employé).
                    </p>
                </div>
                
                <!-- Section Rapports -->
                <div>
                    <h3>ð??? Consulter les rapports</h3>
                    <p>
                        <strong>"Rapports"</strong> affiche des statistiques: matériel par catégorie, 
                        top utilisateurs, top matériel emprunté, etc.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Guide Mécanicien -->
        <?php elseif ($role === 'mecanicien'): ?>
        <div class="card">
            <h2>
                <i class="fas fa-wrench"></i>
                Guide Mécanicien
            </h2>
            
            <div>
                
                <div>
                    <h3>ð??§ Enregistrer une intervention</h3>
                    <p>
                        Allez dans <strong>"Réparations"</strong>. Vous verrez le matériel signalé en panne. 
                        Cliquez <strong>"Intervenir"</strong>, décrivez l'intervention et choisissez l'état final 
                        (Disponible, En maintenance, Hors service).
                    </p>
                </div>
                
                <div>
                    <h3>ð??? Consulter l'historique</h3>
                    <p>
                        <strong>"Historique"</strong> vous montre toutes vos interventions passées. 
                        Vous pouvez filtrer par état ou mois.
                    </p>
                </div>
                
                <div>
                    <h3>ð??? Voir vos statistiques</h3>
                    <p>
                        <strong>"Statistiques"</strong> affiche votre productivité: total interventions, 
                        moyenne par mois, matériel le plus réparé, etc.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Guide Chargé Matériel -->
        <?php elseif ($role === 'charge_materiel'): ?>
        <div class="card">
            <h2>
                <i class="fas fa-box"></i>
                Guide Chargé du Matériel
            </h2>
            
            <div>
                
                <div>
                    <h3>→ Valider les retours</h3>
                    <p>
                        Quand un employé demande le retour d'un équipement, allez dans <strong>"Valider les retours"</strong>. 
                        Une modale vous demande l'état du matériel retourné:
                    </p>
                    <ul>
                        <li>→ <strong>Bon état:</strong> Matériel = Disponible</li>
                        <li>→? ï¸ <strong>Endommagé:</strong> Matériel = Disponible (ou Panne)</li>
                        <li>ð??§ <strong>En panne:</strong> Matériel = Panne (mécanicien verra)</li>
                    </ul>
                </div>
                
                <div>
                    <h3>ð??? Suivi des emprunts</h3>
                    <p>
                        <strong>"Emprunts"</strong> affiche tous les emprunts avec alerte si date retour dépassée. 
                        Vous pouvez voir aussi les demandes de retour en attente.
                    </p>
                </div>
                
                <div>
                    <h3>ð??¦ Consulter l'inventaire</h3>
                    <p>
                        <strong>"Inventaire"</strong> vous montre l'état complet du parc matériel avec statistiques 
                        par état et catégorie. Vous pouvez filtrer et chercher.
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ONGLET 2: FAQ -->
<div id="faq">
    <div class="card">
        <h2>Questions Fréquemment Posées</h2>
        
        <!-- Accordéon FAQ -->
        <div>
            
            <!-- Q1 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Comment demander un matériel?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        1. Allez dans <strong>"Matériel disponible"</strong><br>
                        2. Cliquez sur <strong>"Emprunter"</strong> pour le matériel souhaité<br>
                        3. Remplissez le formulaire (date retour, motif)<br>
                        4. L'admin validera votre demande<br>
                        5. Vous recevrez une notification
                    </p>
                </div>
            </div>
            
            <!-- Q2 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Mon demande d'emprunt est refusée, pourquoi?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        Raisons possibles:
                        <ul>
                            <li>→?¢ Le matériel n'est pas disponible (déjü  emprunté)</li>
                            <li>→?¢ Vous avez déjü  ce matériel en emprunt</li>
                            <li>→?¢ L'admin a refusé pour une autre raison</li>
                        </ul>
                        Consultez vos notifications ou contactez l'admin.
                    </p>
                </div>
            </div>
            
            <!-- Q3 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Combien de temps puis-je garder un matériel?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        La durée dépend de vos besoins. Vous définissez la <strong>"Date retour"</strong> 
                        lors de votre demande. Vous devez respecter cette date. Si vous avez besoin de plus de temps, 
                        contactez l'admin avant la date limite.
                    </p>
                </div>
            </div>
            
            <!-- Q4 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Comment signaler un matériel en panne?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        Si vous découvrez qu'un matériel est en panne pendant son utilisation:
                        <ul>
                            <li>1. Arrêtez de l'utiliser immédiatement</li>
                            <li>2. Retournez-le ü  l'admin avec une note</li>
                            <li>3. L'admin le marquera comme "En panne"</li>
                            <li>4. Un mécanicien procédera ü  la réparation</li>
                        </ul>
                    </p>
                </div>
            </div>
            
            <!-- Q5 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Oü¹ sont mes notifications?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        Cliquez sur l'icü´ne <strong>cloche</strong> en haut ü  droite pour ouvrir le centre de notifications. 
                        Vous verrez toutes les notifications: demandes validées, refusées, retours, etc.
                    </p>
                </div>
            </div>
            
            <!-- Q6 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Je ne peux pas accéder ü  une page, pourquoi?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        Raisons possibles:
                        <ul>
                            <li>→?¢ Vous n'êtes pas connecté (reconnectez-vous)</li>
                            <li>→?¢ Vous n'avez pas les permissions (accès limité ü  votre rü´le)</li>
                            <li>→?¢ La page n'existe pas (erreur 404)</li>
                        </ul>
                    </p>
                </div>
            </div>
            
            <!-- Q7 -->
            <div>
                <button onclick="toggleFaq(this)">
                    <span>→? Comment réinitialiser mon mot de passe?</span>
                    <span>+</span>
                </button>
                <div class="faq-content">
                    <p>
                        Actuellement, la réinitialisation de mot de passe n'est pas implémentée. 
                        Contactez l'administrateur pour réinitialiser votre mot de passe.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ONGLET 3: SUPPORT -->
<div id="contact">
    <div class="card">
        <h2>Contacter le Support</h2>
        
        <div>
            
            <!-- Administrateur -->
            <div>
                <h3>
                    <i class="fas fa-user-shield"></i>
                    Administrateur
                </h3>
                <p>
                    Pour les problèmes de gestion d'utilisateurs, de matériel ou de demandes d'emprunt.
                </p>
                <p>
                    ð??§ admin@somaf.fr
                </p>
            </div>
            
            <!-- Chargé Matériel -->
            <div>
                <h3>
                    <i class="fas fa-box"></i>
                    Chargé du Matériel
                </h3>
                <p>
                    Pour les questions sur les retours de matériel ou l'inventaire.
                </p>
                <p>
                    ð??§ charge_materiel@somaf.fr
                </p>
            </div>
            
            <!-- Mécanicien -->
            <div>
                <h3>
                    <i class="fas fa-wrench"></i>
                    Mécanicien
                </h3>
                <p>
                    Pour signaler un matériel défectueux ou poser une question sur une réparation.
                </p>
                <p>
                    ð??§ marc@somaf.fr
                </p>
            </div>
        </div>
        
        <!-- Info supplémentaire -->
        <div>
            <h4>
                <i class="fas fa-lightbulb"></i>
                Astuce
            </h4>
            <p>
                La plupart des problèmes sont couverts dans le guide utilisateur et la FAQ ci-dessus. 
                Consultez-les d'abord avant de contacter le support.
            </p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Fonction pour afficher/cacher les onglets
function afficherOnglet(onglet) {
    // Cacher tous les onglets
    document.getElementById('guide').style.display = 'none';
    document.getElementById('faq').style.display = 'none';
    document.getElementById('contact').style.display = 'none';
    
    // Afficher l'onglet sélectionné
    document.getElementById(onglet).style.display = 'block';
    
    // Actualiser le style des boutons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.style.color = '#6b7280';
        btn.style.borderBottomColor = 'transparent';
    });
    event.target.closest('.tab-btn').style.color = '#0284c7';
    event.target.closest('.tab-btn').style.borderBottomColor = '#0284c7';
}

// Fonction pour toggle les FAQ
function toggleFaq(button) {
    const content = button.nextElementSibling;
    const isOpen = content.style.display === 'block';
    
    // Fermer toutes les autres
    document.querySelectorAll('.faq-content').forEach(item => {
        item.style.display = 'none';
        item.previousElementSibling.querySelector('span:last-child').textContent = '+';
    });
    
    // Toggle le courant
    if (!isOpen) {
        content.style.display = 'block';
        button.querySelector('span:last-child').textContent = '→';
    }
}
</script>

<?php include 'templates/footer.php'; ?>

