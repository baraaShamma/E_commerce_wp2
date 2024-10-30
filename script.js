function requireLogin() {
    alert("يجب عليك تسجيل الدخول أولاً لإضافة منتجات إلى السلة.");
  }
function updateQuantity(productId, change) {
    const card = document.querySelector(`.cart-card[data-product-id='${productId}']`);
    if (!card) {
        console.error(`No card found for product ID: ${productId}`);
        return;
    }
    
    const quantityElement = card.querySelector('.item-quantity');
    const totalElement = document.getElementById('total-price');
    const itemTotalPriceElement = card.querySelector('.item-total-price');

    if (!quantityElement || !itemTotalPriceElement || !totalElement) {
        console.error("Required elements not found in card or DOM.");
        return;
    }

    let currentQuantity = parseInt(quantityElement.textContent);
    let newQuantity = currentQuantity + change;

    if (newQuantity < 1) return;

    let itemPrice = parseFloat(itemTotalPriceElement.getAttribute('data-price'));
    let currentTotalPrice = parseFloat(totalElement.textContent);

    // حساب السعر الجديد
    currentTotalPrice += itemPrice * change;
    itemTotalPriceElement.textContent = itemPrice * newQuantity;
    quantityElement.textContent = newQuantity;
    totalElement.textContent = currentTotalPrice;

    // تحديث الكمية في قاعدة البيانات باستخدام AJAX
    fetch('update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, quantity: newQuantity })
    })
    .catch(error => console.error('Error updating cart:', error));
}


document.addEventListener('DOMContentLoaded', () => {
    window.showDeleteConfirmation = function(productId) {
        const confirmationDialog = document.getElementById("confirmation-dialog");
        confirmationDialog.style.display = "flex";
        document.getElementById("confirm-delete").onclick = () => {
            deleteFromCart(productId);
            confirmationDialog.style.display = "none";
        };
        document.getElementById("cancel-delete").onclick = () => {
            confirmationDialog.style.display = "none";
        };
    };

    async function deleteFromCart(productId) {
        try {
            const response = await fetch('delete_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId })
            });
            const data = await response.json();
            if (data.status === 'success') {
                document.querySelector(`.cart-card[data-product-id='${productId}']`).remove();
                updateTotalPrice();
            } else {
                console.error('Failed to delete item:', data.message);
            }
        } catch (error) {
            console.error('Error deleting item:', error);
        }
    }

    function updateTotalPrice() {
        let totalPrice = 0;
        document.querySelectorAll('.item-total-price').forEach(item => {
            totalPrice += parseFloat(item.textContent);
        });
        document.getElementById('total-price').textContent = totalPrice.toFixed(2);
    }
});
