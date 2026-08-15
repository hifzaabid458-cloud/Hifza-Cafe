// ================= HIFZA'S CAFE CART =================

let cart = JSON.parse(localStorage.getItem("hifzasCafeCart")) || [];


// ================= CART COUNT =================

function updateCartCount() {

    const cartLinks =
        document.querySelectorAll('a[href="cart.php"], a[href="pages/cart.php"]');

    let totalItems = 0;

    cart.forEach(function (item) {

        totalItems += item.quantity;

    });

    cartLinks.forEach(function (link) {

        link.textContent = "🛒 Cart (" + totalItems + ")";

    });

}


// ================= SAVE CART =================

function saveCart() {

    localStorage.setItem(
        "hifzasCafeCart",
        JSON.stringify(cart)
    );

}


// ================= ADD TO CART =================

function addToCart(name, price, quantity = 1) {

    const existingItem = cart.find(
        item => item.name === name
    );

    if (existingItem) {

        existingItem.quantity += quantity;

    } else {

        cart.push({
            name: name,
            price: price,
            quantity: quantity
        });

    }

    saveCart();
	
	updateCartCount();

   showCartToast(name + " added to your cart! 🩷");

}

// ================= CART TOAST =================

function showCartToast(message) {

    let toast = document.getElementById("cart-toast");

    if (!toast) {

        toast = document.createElement("div");

        toast.id = "cart-toast";

        document.body.appendChild(toast);

    }

    toast.textContent = message;

    toast.classList.add("show");


    setTimeout(function () {

        toast.classList.remove("show");

    }, 2500);

}

// ================= DISPLAY CART =================

function displayCart() {

    const cartContainer =
        document.getElementById("cart-container");

    const cartSummary =
        document.getElementById("cart-summary");


    if (!cartContainer || !cartSummary) {
        return;
    }


    if (cart.length === 0) {

    cartContainer.innerHTML = `
        <div class="empty-cart">
            <h2>Your cart is empty 🛒</h2>

            <p>
                Choose something delicious from our menu.
            </p>

            <a href="menu.php" class="back-menu">
                Browse Menu
            </a>
        </div>
    `;

    cartSummary.innerHTML = "";
    cartSummary.style.display = "none";

    return;
}

cartSummary.style.display = "block";


    cartContainer.innerHTML = "";


    let total = 0;


    cart.forEach(function (item, index) {

        const itemTotal =
            item.price * item.quantity;

        total += itemTotal;


        const cartItem = document.createElement("div");

        cartItem.className = "cart-item";


        cartItem.innerHTML = `

            <div class="cart-item-info">

                <h3>
                    ${item.name}
                </h3>

                <p>
                    Rs. ${item.price} × ${item.quantity}
                </p>

            </div>


            <div class="cart-item-actions">

                <button
                    type="button"
                    onclick="decreaseCartQuantity(${index})"
                >
                    −
                </button>


                <span>
                    ${item.quantity}
                </span>


                <button
                    type="button"
                    onclick="increaseCartQuantity(${index})"
                >
                    +
                </button>


                <strong>
                    Rs. ${itemTotal}
                </strong>


                <button
                    type="button"
                    onclick="removeFromCart(${index})"
                >
                    🗑️
                </button>

            </div>

        `;


        cartContainer.appendChild(cartItem);

    });


    cartSummary.innerHTML = `

        <h2>
            Cart Total: Rs. ${total}
        </h2>


        <button
            type="button"
            class="order-submit"
            onclick="goToOrder()"
        >
            Proceed to Order 🩷
        </button>

    `;

}


// ================= INCREASE QUANTITY =================

function increaseCartQuantity(index) {

    cart[index].quantity++;

    saveCart();

    displayCart();
	
	updateCartCount();

}


// ================= DECREASE QUANTITY =================

function decreaseCartQuantity(index) {

    if (cart[index].quantity > 1) {

        cart[index].quantity--;

    } else {

        cart.splice(index, 1);

    }

    saveCart();

    displayCart();
	
	updateCartCount();

}


// ================= REMOVE ITEM =================

function removeFromCart(index) {

    cart.splice(index, 1);

    saveCart();

    displayCart();
	
	updateCartCount();

}


// ================= GO TO ORDER =================

function goToOrder() {

    window.location.href = "order.php";

}


// ================= PAGE LOAD =================

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const addButtons =
            document.querySelectorAll(".add-cart-btn");


        addButtons.forEach(function (button) {

            button.addEventListener(
                "click",
                function () {

                    const name =
                        button.dataset.name;

                    const price =
                        parseInt(button.dataset.price);


                    let quantity = 1;


                    const quantityElement =
                        document.getElementById("quantity");


                    if (quantityElement) {

                        quantity =
                            parseInt(
                                quantityElement.textContent
                            ) || 1;

                    }


                    addToCart(
                        name,
                        price,
                        quantity
                    );

                }
            );

        });


        displayCart();
		
		updateCartCount();

    }
);