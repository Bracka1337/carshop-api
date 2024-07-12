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


//banner

    // window.onload = function() {
        const dynamicWords = ["cars", "enthusiasts", "magebit", "everyone"];
        // const dynamicWords = ["cars", "motorcycles"];
        // Retrieve the current word index from localStorage, default to 0 if not found
        let currentWordIndex = parseInt(localStorage.getItem('dynamicWordIndex')) || 0;
        const targetElement = document.querySelector('.Banner__title--second');

        async function updateDynamicWord() {
            const dynamicWord = dynamicWords[currentWordIndex];
            const targetElement = document.querySelector('.Banner__title--second');
            // Clear existing content
            if (targetElement.textContent.length > 0) {
                let str = targetElement.textContent;
               await eraseText(targetElement);
            }
            targetElement.innerHTML = ''; // Use innerHTML to clear the element
            
            // Typing effect
            await typeText(targetElement, dynamicWord);

            currentWordIndex++;
            if (currentWordIndex >= dynamicWords.length) {
                currentWordIndex = 0; // Loop back to the first word after showing all
            }

        setTimeout(updateDynamicWord, 3000); // Change word every 3 seconds
        }

        // Typing effect function
        async function typeText(element, text, index = 0) {
            return new Promise((resolve) => {
                function typeNextCharacter() {
                    if (index < text.length) {
                        element.innerHTML += text.charAt(index);
                        index++;
                        setTimeout(typeNextCharacter, 100); // Adjust delay as needed
                    } else {
                        resolve();
                    }
                }
                typeNextCharacter();
            });
        }

        async function eraseText(element) {
            return new Promise((resolve) => {
                function eraseNextCharacter() {
                    if (element.textContent.length > 0) {
                        element.textContent = element.textContent.slice(0, -1);
                        setTimeout(eraseNextCharacter, 100); // Adjust delay as needed
                    } else {
                        resolve();
                    }
                }
                eraseNextCharacter();
            });
        }

        updateDynamicWord(); // Initialize the dynamic word
    // };

        // blink animation for caret coursor

    // function toggleVisibility(Banner__caret) {
    //     const element = document.getElementById(Banner__caret);
    //     if (element.style.display === "none") {
    //         element.style.display = "inline";
    //     } else {
    //         element.style.display = "none";
    //     }
    // }

    // // rgba(124, 58, 237, 1)
    
    // function startBlinking(Banner__caret, intervalDuration) {
    //     setInterval(() => toggleVisibility(Banner__caret), intervalDuration);
    // }
    
    // // Example usage: Make an element with ID 'blinkMe' blink every 500 milliseconds
    // startBlinking('blinkMe', 500);
});

