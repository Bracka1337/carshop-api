document.addEventListener('DOMContentLoaded', function() {
// homepage modal window

    const products = document.querySelectorAll("#product");
    const modals = document.querySelectorAll("#modal");
    const productsDetail = document.querySelectorAll("#productDetail");
    const addToCart = document.querySelectorAll("#addToCart");
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
            const modal = productDetail.parentElement;
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

    // modal images slideshow
    const carousels = document.querySelectorAll('[data-carousel-inner]');
    carousels.forEach(carousel => {
        const items = carousel.querySelectorAll('[data-carousel-item]');
        const indicators = carousel.nextElementSibling.querySelectorAll('[data-carousel-slide-to]');
        const prevButton = carousel.parentElement.querySelector('[data-carousel-prev]');
        const nextButton = carousel.parentElement.querySelector('[data-carousel-next]');
        let activeIndex = 0;

        const showItem = (index) => {
            items.forEach((item, i) => {
                if (i === index) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.add('bg-gray-400');
                    indicator.classList.remove('bg-gray-300');
                } else {
                    indicator.classList.add('bg-gray-300');
                    indicator.classList.remove('bg-gray-400');
                }
            });
        };

        const prevItem = () => {
            activeIndex = (activeIndex > 0) ? activeIndex - 1 : items.length - 1;
            showItem(activeIndex);
        };

        const nextItem = () => {
            activeIndex = (activeIndex < items.length - 1) ? activeIndex + 1 : 0;
            showItem(activeIndex);
        };

        prevButton.addEventListener('click', prevItem);
        nextButton.addEventListener('click', nextItem);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                activeIndex = index;
                showItem(activeIndex);
            });
        });
        showItem(activeIndex);
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