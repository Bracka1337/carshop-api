document.addEventListener('DOMContentLoaded', function() {
    // homepage modal window
    
    const products = document.querySelectorAll("#product");
    const modals = document.querySelectorAll("#modal");
    const productsDetail = document.querySelectorAll("#productDetail");

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
});