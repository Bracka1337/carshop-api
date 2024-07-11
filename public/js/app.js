document.addEventListener('DOMContentLoaded', function() {
    // homepage modal window
    
    // const products = document.querySelectorAll("#product");
    // const modal = document.querySelector("#modal");
    // const productsDetail = document.querySelectorAll("#productDetail");

    // products.forEach((product) => {
    //     product.addEventListener('click', ((event) => {
    //         event.preventDefault();
    //         const productId = event.currentTarget.getAttribute('product-id');
    //         const productsDetailArr = Array.from(productsDetail);
    //         const productDetail = productsDetailArr.find((detail) => {
    //             const detailId =detail.getAttribute('product-data-id');
    //             return detailId === productId;
    //         });
    //         modal.classList.remove('hidden');
    //         productDetail.classList.remove('hidden');
    //     }));
    // });

    // modal.addEventListener('click', ((event) => {
    //     event.preventDefault();

    //     const productsDetailArr = Array.from(productsDetail);
    //     console.log(productsDetailArr);
    //     // const productDetail = productsDetailArr.find((detail) => {
    //     //     return detail.classList.contains;
    //     // });
    // }));

    // productsDetail.forEach((detail) => {
    //     detail.addEventListener('click', ((event) => {
    //         event.preventDefault();

    //         if (!event.currentTarget.classList.contains('hidden')) {
    //         //    if (event.target.id === 'closeModal' || )
    //         console.log(event.target);
    //         }
    //     }));
    // });

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



// banner

    const subtitles = [
        "for everyone",
        "empowering developers",
        "building the future",
        "secure and fast"
      ];
      
      let currentSubtitleIndex = 0;
      
      function updateSubtitle() {
        const subtitle = subtitles[currentSubtitleIndex];
        document.getElementById('bannerSubtitle').innerText = subtitle;
      
        currentSubtitleIndex++;
        if (currentSubtitleIndex >= subtitles.length) {
          currentSubtitleIndex = 0; // Loop back to the first subtitle after showing all
        }
      
        setTimeout(updateSubtitle, 3000); // Change subtitle every 3 seconds
      }
      
      updateSubtitle(); // Initialize the subtitle
});