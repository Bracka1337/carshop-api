document.addEventListener('DOMContentLoaded', function() {
// homepage modal window

    const products = document.querySelectorAll("#product");
    const modals = document.querySelectorAll("#modal");
    const productsDetail = document.querySelectorAll("#productDetail");

    // open modal
    products.forEach((product) => {
        product.addEventListener('click', ((event) => {
            event.preventDefault();
            const productId = event.currentTarget.getAttribute('product-id');
            const productsDetailArr = Array.from(productsDetail);
            const productDetail = productsDetailArr.find((detail) => {
                const detailId = detail.getAttribute('product-data-id');
                return productId === detailId;
            });
            const modal = productDetail.parentElement.parentElement;
            modal.classList.remove('hidden');
            productDetail.classList.remove('hidden');
        }));
    });

    // close modal
    modals.forEach((modal) => {
        modal.addEventListener('click', ((event) => {
            event.preventDefault();
            const productsDetailArr = Array.from(productsDetail);
            const productDetail = productsDetailArr.find((detail) => {
                return !detail.classList.contains('hidden');
            });
            const closeModal = productDetail.querySelector("#closeModal");
            if (!productDetail.contains(event.target) || event.target === closeModal) {
                modal.classList.add('hidden');
                productDetail.classList.add('hidden');
            }
        }));
    });

    // grid infinite scroll

    // document.getElementById('fetchDataForm').submit();

    document.getElementById('productListDataForm').addEventListener('submit', function(event) {
        event.preventDefault();
// 
        fetch('/path/to/server/script', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(new FormData(this))
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update the page with the new data
            document.getElementById('user-name').textContent = data.name;
            // Update other elements similarly
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });

//shopping cart
    //shopping cart close button 
   
    const closeButton = document.getElementById('close-button');
    const shoppingCart = document.getElementById('shopping-cart');
    const modal = document.getElementById('modal');
    closeButton.addEventListener('click', (event) => {
    event.preventDefault();
        shoppingCart.classList.add('hidden');
        modal.classList.add('hidden');
    });


    //shopping cart open button 

    const openButton = document.getElementById('open-button');
    openButton.addEventListener('click', (event) => {
        event.preventDefault();
        modal.classList.remove('hidden');
        shoppingCart.classList.remove('hidden');
    });

    

    modal.addEventListener('click', (event) => {
        event.preventDefault()

        if (!shoppingCart.contains(event.target)) {
            shoppingCart.classList.add('hidden');
            modal.classList.add('hidden');
        }
    })

    const continueShopping = document.getElementById('continue-shopping');
    continueShopping .addEventListener('click', (event) => {
        event.preventDefault();
        shoppingCart.classList.add('hidden');
        modal.classList.add('hidden');
    });
});