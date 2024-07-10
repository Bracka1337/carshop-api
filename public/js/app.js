document.addEventListener('DOMContentLoaded', function() {
    // homepage modal window
    
    const products = document.querySelectorAll("#product");
    const modal = document.querySelector("#modal");
    const productsDetail = document.querySelectorAll("#productDetail");

    products.forEach((product) => {
        product.addEventListener('click', ((event) => {
            event.preventDefault();
            const productId = event.currentTarget.getAttribute('product-id');
            const productsDetailArr = Array.from(productsDetail);
            const productDetail = productsDetailArr.find((detail) => {
                const detailId =detail.getAttribute('product-data-id');
                return detailId === productId;
            });
            modal.classList.remove('hidden');
            productDetail.classList.remove('hidden');
        }));
    });

    modal.addEventListener('click', ((event) => {
        event.preventDefault();

        const productsDetailArr = Array.from(productsDetail);
        console.log(productsDetailArr);
        // const productDetail = productsDetailArr.find((detail) => {
        //     return detail.classList.contains;
        // });
    }));

    // productsDetail.forEach((detail) => {
    //     detail.addEventListener('click', ((event) => {
    //         event.preventDefault();

    //         if (!event.currentTarget.classList.contains('hidden')) {
    //         //    if (event.target.id === 'closeModal' || )
    //         console.log(event.target);
    //         }
    //     }));
    // });


});