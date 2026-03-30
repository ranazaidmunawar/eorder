$(document).ready(function () {
    loadCart();

    // Smooth scroll for categories
    $('.category-pill').on('click', function (e) {
        e.preventDefault();
        $('.category-pill').removeClass('active');
        $(this).addClass('active');

        const target = $(this).attr('href');
        if (target !== '#') {
            $('html, body').animate({
                scrollTop: $(target).offset().top - 120
            }, 500);
        } else {
            $('html, body').animate({ scrollTop: 0 }, 500);
        }
    });
});

let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Auto-clear old cart items that don't have the image field (from before the fix)
if (cart.length > 0 && cart.some(item => item.image === undefined)) {
    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
}

let currentProduct = null;
let currentQty = 1;

function openProductModal(product) {
    currentProduct = product;
    currentQty = 1;

    $('#modalTitle').text(product.name);
    $('#modalDesc').text(product.description || '');
    $('#modalPrice').text(parseFloat(product.price).toFixed(2) + ' USD');
    $('#modalImg').attr('src', product.image || 'https://via.placeholder.com/300');
    $('#qtyInput').val(1);
    updateModalTotal();

    // Show modal
    var myModal = new bootstrap.Modal(document.getElementById('productModal'), {
        keyboard: false
    });
    myModal.show();
}

function updateQty(change) {
    currentQty += change;
    if (currentQty < 1) currentQty = 1;
    $('#qtyInput').val(currentQty);
    updateModalTotal();
}

function updateModalTotal() {
    if (currentProduct) {
        let total = currentProduct.price * currentQty;
        $('#modalTotalBtn').text(total.toFixed(2) + ' USD');
    }
}

function addToCart() {
    if (!currentProduct) return;

    const existingItemIndex = cart.findIndex(item => item.id === currentProduct.id);

    if (existingItemIndex > -1) {
        cart[existingItemIndex].qty += currentQty;
    } else {
        cart.push({
            id: currentProduct.id,
            name: currentProduct.name,
            price: currentProduct.price,
            image: currentProduct.image || '',
            qty: currentQty
        });
    }

    saveCart();
    $('#productModal').modal('hide'); // This might not work with Bootstrap 5 vanilla JS access, need jQuery selector or instance
    // bootstrap.Modal.getInstance(document.getElementById('productModal')).hide(); // Better way

    // Using jQuery trigger for consistency if needed, but let's try standard BS5 method:
    const modalEl = document.getElementById('productModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();

    Swal.fire({
        icon: 'success',
        title: 'Added to Cart',
        text: `${currentProduct.name} (x${currentQty}) added!`,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
}

function loadCart() {
    updateCartUI();
}

function updateCartUI() {
    let count = 0;
    let total = 0;

    cart.forEach(item => {
        count += item.qty;
        total += item.price * item.qty;
    });

    $('.cart-count').text(count);
    $('.cart-total').text(total.toFixed(2) + ' USD');

    if (count > 0) {
        $('#sticky-cart').removeClass('hidden');
    } else {
        $('#sticky-cart').addClass('hidden');
    }
}
