<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME</title>
    <link href="../public/home.css" rel="stylesheet" /> 
    <style>
        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .courses-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        
    </style>
</head>

<body>
    <header>
        <h1>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    </header>
    
    <nav>
        <ul>
            <li><a href="#cours" onclick="showSection('Cours')">Cours</a></li>
            <li><a href="#test" onclick="showSection('TEST')">Test</a></li>
            <li><a href="#payement" onclick="showSection('PAYEMENT')">Payement</a></li>
            <li><a href="#progress" onclick="showSection('progress')">Progress</a></li>
            <li><a href="#Stage" onclick="showSection('Stage')">Stage</a></li>
        </ul>
    </nav>

    <main>
    <section id="Cours" class="section active">
            <h2>COURS</h2>
            <div class="cours-item">
                <h3>MATH</h3>
                <p>Cours math</p>
            </div>
            <div class="cours-item">
                <h3>JAVA</h3>
                <p>Cours java</p>
            </div>
            <div class="cours-item">
                <h3>C / C++</h3>
                <p>Cours C / C++</p>
            </div>
        </section>

        <!-- Section Test -->
        <section id="TEST" class="section">
            <h2>TEST</h2>
            <div class="test-item">
                <h3>TEST MATH</h3>
                <p>.....</p>
            </div>
            <div class="test-item">
                <h3>TEST JAVA</h3>
                <p>.....</p>
            </div>
        </section>

        <section id="PAYEMENT" class="section">
            <h2>Payement</h2>

            <div class="courses-container">
                <div class="course-card">
                    <h3>JAVA</h3>
                    <img src="../public/JAVA.jpg" alt="Image du cours JAVA">
                    <div class="price">€20</div>
                    <button onclick="addToCart('JAVA', 20)">Acheter</button>
                </div>
                <div class="course-card">
                    <h3>HTML</h3>
                    <img src="../public/HTML.jpg" alt="Image du cours HTML">
                    
                    <div class="price">€20</div>
                    <button onclick="addToCart('HTML', 20)">Acheter</button>
                </div>
                <div class="course-card">
                    <h3>PHP</h3>
                    <img src="../public/php.jpeg" alt="Image du cours PHP">
                    
                    <div class="price">€20</div>
                    <button onclick="addToCart('PHP', 20)">Acheter</button>
                </div>
                <div class="course-card">
                    <h3>c</h3>
                    <img src="../public/c.png" alt="Image du cours c">
                    
                    <div class="price">€20</div>
                    <button onclick="addToCart('c', 20)">Acheter</button>
                </div>
                <div class="course-card">
                    <h3>C++</h3>
                    <img src="../public/C++.jpg" alt="Image du cours C++">
                    <div class="price">€20</div>
                    <button onclick="addToCart('C++', 20)">Acheter</button>
                </div>
            </div>

            <div id="cart-details" style="display: none;">
                <h3>Panier</h3>
                <ul id="cart-items"></ul>
                <p id="total-price">Prix Total: €0</p>
                
                <input type="text" id="card-number" placeholder="Votre Numéro de carte">
                
                <button onclick="validateCart()">Valider l'Achat</button>
                <button onclick="removeSelectedCourses()">Supprimer Cours </button>
                <button onclick="clearCart()">Vider le Panier</button>
            </div>
        </section>
    </main>

    <script>
        let cart = [];
        let totalPrice = 0;

        // Fonction pour afficher la section active
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            const activeSection = document.getElementById(sectionId);
            if (activeSection) {
                activeSection.classList.add('active');
            }
        }

        // Fonction pour ajouter un cours au panier
        function addToCart(courseName, coursePrice) {
            // Vérifier si le cours est déjà dans le panier
            const courseExists = cart.some(item => item.name === courseName);
            if (courseExists) {
                alert("Ce cours est déjà dans le panier.");
                return;
            }
            
            // Ajouter le cours au panier
            cart.push({ name: courseName, price: coursePrice });
            totalPrice += coursePrice;

            // Mettre à jour les détails du panier
            updateCartDetails();
            document.getElementById('cart-details').style.display = 'block';
        }

        // Fonction pour mettre à jour les détails du panier
        function updateCartDetails() {
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = ''; // Réinitialiser le contenu du panier

            cart.forEach((item, index) => {
                const listItem = document.createElement('li');
                
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.value = index; // Utiliser l'index pour identifier le cours
                checkbox.className = 'course-checkbox';

                listItem.appendChild(checkbox);
                listItem.appendChild(document.createTextNode(` ${item.name} : €${item.price}`));
                cartItemsContainer.appendChild(listItem);
            });

            document.getElementById('total-price').textContent = `Prix Total: €${totalPrice}`;
        }

        // Fonction pour valider l'achat
        function validateCart() {
            const cardNumber = document.getElementById('card-number').value;
            if (cardNumber === '') {
                alert("Veuillez entrer votre numéro de carte.");
                return;
            }

            alert(" Achat validé ! "  );
            clearCart(); // Vider le panier après validation
        }

        // Fonction pour supprimer les cours sélectionnés
        function removeSelectedCourses() {
            const checkboxes = document.querySelectorAll('.course-checkbox');
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const courseIndex = parseInt(checkbox.value);
                    totalPrice -= cart[courseIndex].price;
                    cart.splice(courseIndex, 1); // Retirer le cours du panier
                }
            });

            updateCartDetails(); // Mettre à jour le panier
            if (cart.length === 0) {
                document.getElementById('cart-details').style.display = 'none'; // Cacher le panier s'il est vide
            }
        }

        // Fonction pour vider le panier
        function clearCart() {
            cart = [];
            totalPrice = 0;
            document.getElementById('card-number').value = ''; // Réinitialiser le champ numéro de carte
            updateCartDetails();
            document.getElementById('cart-details').style.display = 'none'; // Cacher le panier
        }

        // Afficher la section des cours par défaut
        document.addEventListener("DOMContentLoaded", function() {
            showSection('Cours');
        });
    </script>
</body>
</html>
