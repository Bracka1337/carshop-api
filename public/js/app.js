document.addEventListener("DOMContentLoaded", function () {
  // homepage modal window

  const products = document.querySelectorAll("#product");
  const modals = document.querySelectorAll("#modal");
  const productsDetail = document.querySelectorAll("#productDetail");
  const addToCart = document.querySelectorAll("#addToCart");
  const updateCartButtons = document.querySelectorAll(".updateCart");

  // open modal
  products.forEach((product) => {
    product.addEventListener("click", (event) => {
      event.preventDefault();
      const productId = event.currentTarget.getAttribute("product-id");
      const productsDetailArr = Array.from(productsDetail);
      const productDetail = productsDetailArr.find((detail) => {
        const detailId = detail.getAttribute("product-data-id");
        return productId === detailId;
      });
      const modal = productDetail ? productDetail.parentElement : null;
      if (modal) {
        modal.classList.remove("hidden");
        productDetail.classList.remove("hidden");
      }
    });
  });

// close modal
modals.forEach((modal) => {
    modal.addEventListener("click", (event) => {
      closeModal(event);
    });
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeModal(event);
    }
  });

  function closeModal(event) {
    event.preventDefault();
    const productsDetailArr = Array.from(productsDetail);
    const productDetail = productsDetailArr.find((detail) => {
      return !detail.classList.contains("hidden");
    });

    if (productDetail) {
      const modal = productDetail.parentElement;
      const closeModalButton = productDetail.querySelector("#closeModal");

      if (
        !productDetail.contains(event.target) ||
        event.target === closeModalButton ||
        event.key === "Escape"
      ) {
        if (modal && productDetail) {
          modal.classList.add("hidden");
          productDetail.classList.add("hidden");
        }
      }
    }
  }

  // modal images slideshow
  const carousels = document.querySelectorAll("[data-carousel-inner]");
  carousels.forEach((carousel) => {
    const items = carousel.querySelectorAll("[data-carousel-item]");
    const indicators = carousel.nextElementSibling.querySelectorAll(
      "[data-carousel-slide-to]"
    );
    const prevButton = carousel.parentElement.querySelector(
      "[data-carousel-prev]"
    );
    const nextButton = carousel.parentElement.querySelector(
      "[data-carousel-next]"
    );
    let activeIndex = 0;

    const showItem = (index) => {
      items.forEach((item, i) => {
        if (i === index) {
          item.classList.remove("hidden");
        } else {
          item.classList.add("hidden");
        }
      });

      indicators.forEach((indicator, i) => {
        if (i === index) {
          indicator.classList.add("bg-gray-400");
          indicator.classList.remove("bg-gray-300");
        } else {
          indicator.classList.add("bg-gray-300");
          indicator.classList.remove("bg-gray-400");
        }
      });
    };

    const prevItem = () => {
      activeIndex = activeIndex > 0 ? activeIndex - 1 : items.length - 1;
      showItem(activeIndex);
    };

    const nextItem = () => {
      activeIndex = activeIndex < items.length - 1 ? activeIndex + 1 : 0;
      showItem(activeIndex);
    };

    prevButton.addEventListener("click", prevItem);
    nextButton.addEventListener("click", nextItem);

    indicators.forEach((indicator, index) => {
      indicator.addEventListener("click", () => {
        activeIndex = index;
        showItem(activeIndex);
      });
    });
    showItem(activeIndex);
  });

//shopping cart
  //shopping cart close button

  const closeButton = document.getElementById("close-button");
  const shoppingCart = document.getElementById("shopping-cart");
  const modal = document.getElementById("modal");
  closeButton.addEventListener("click", (event) => {
    event.preventDefault();
    shoppingCart.classList.add("hidden");
    modal.classList.add("hidden");
  });

//shopping cart open button 

  const openButton = document.getElementById("open-button");
  openButton.addEventListener("click", (event) => {
    event.preventDefault();
    modal.classList.remove("hidden");
    shoppingCart.classList.remove("hidden");
  });



  // Update cart  on quantity change
  const quantityInputs = document.querySelectorAll(".quantity-display");
  quantityInputs.forEach((display) => {
    const productId = display.getAttribute("id").split("-")[1];
    const decreaseButton = document.querySelector(
      `.decrease-quantity[data-id="${productId}"]`
    );
    const increaseButton = document.querySelector(
      `.increase-quantity[data-id="${productId}"]`
    );

    decreaseButton.addEventListener("click", (event) => {
      event.preventDefault();
      let quantity = parseInt(display.innerText);
      if (quantity > 1) {
        quantity -= 1;
        display.innerText = quantity;
        updateCart(productId, quantity);
        calculateSubtotal();
      }
    });

    increaseButton.addEventListener("click", (event) => {
      event.preventDefault();
      let quantity = parseInt(display.innerText);
      quantity += 1;
      display.innerText = quantity;
      updateCart(productId, quantity);
      calculateSubtotal();
    });
  });

  function updateCart(productId, quantity) {
    const url = `/cart/update/${productId}/${quantity}`;
    fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },

      body: JSON.stringify({
        productId: productId,
        quantity: quantity,
      }),
    })
      .then((response) => {
        if (response.ok) {
          return response.json();
        }
        throw new Error("Network response was not ok.");
      })
      .then((data) => {
        window.location.reload();
      });
  }

  updateCartButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      const productId = button.getAttribute("data-id");
      const quantityInput = document.getElementById(`quantity-${productId}`);
      const quantity = quantityInput.value;

      const url = `cart/update/${productId}/${quantity}`;
    });
  });

  // Remove item from cart
  const removeButtons = document.querySelectorAll("#remove-item");

  removeButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      const productId = button.getAttribute("data-id");
      const url = `/cart/remove/${productId}`;
      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          }
          throw new Error("Network response was not ok.");
        })
        .then((data) => {
          //stores modal window condition
          localStorage.setItem("cartUpdated", "true");
          window.location.reload();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  });

  if (localStorage.getItem("cartUpdated") === "true") {
    localStorage.removeItem("cartUpdated");
    openCartModal();
  }

  function openCartModal() {
    document.getElementById("shopping-cart").classList.remove("hidden");
    document.getElementById("modal").classList.remove("hidden");
  }

  function calculateSubtotal() {
    let subtotal = 0;
    const quantityDisplays = document.querySelectorAll(".quantity-display");
    quantityDisplays.forEach((display) => {
      const productId = display.getAttribute("id").split("-")[1];

      const priceElement = document.querySelector(
        `.product-price[data-id="${productId}"]`
      );

      if (priceElement) {
        const price = parseFloat(priceElement.innerText.replace("$", ""));
        const quantity = parseInt(display.innerText);
        subtotal += price * quantity;
      }
    });
    document.getElementById("subtotal-amount").innerText = `$${subtotal.toFixed(
      2
    )}`;
  }

  calculateSubtotal();

  //--

  modal.addEventListener("click", (event) => {
    event.preventDefault();

    if (!shoppingCart.contains(event.target)) {
      shoppingCart.classList.add("hidden");
      modal.classList.add("hidden");
    }
  });

  const continueShopping = document.getElementById("continue-shopping");
  continueShopping.addEventListener("click", (event) => {
    event.preventDefault();
    shoppingCart.classList.add("hidden");
    modal.classList.add("hidden");
  });

 //banner

    // window.onload = function() {
        const dynamicWords = ["cars", "enthusiasts", "magebit", "everyone"];

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
            // Initialize the dynamic word
        updateDynamicWord(); 
        
        //dropdown button in navbar
    
        const button = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar-menu');
        const sidebarModal = document.getElementById('sidebar-modal');
    // sidebar
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true' || false;
            button.setAttribute('aria-expanded', !expanded);
            sidebarModal.classList.toggle('hidden');
            if (!sidebarModal.classList.contains('hidden')) {
                sidebarModal.classList.remove('-translate-x-full');
            } else {
                sidebarModal.classList.add('-translate-x-full');
            }
    
            sidebarModal.addEventListener('click', (event) => {
                if (!sidebar.contains(event.target)) {
                    button.setAttribute('aria-expanded', 'false');
                    sidebarModal.classList.add('hidden');
                    sidebarModal.classList.add('-translate-x-full');
                }
            });
    
            // close sideBar modal
            const closeButton = document.getElementById('close-button');
    
            closeButton.addEventListener('click', (event) => {
                event.preventDefault();
                sidebarModal.classList.add('hidden');
            });
        });

          //Notification message

        const successMessage = document.getElementById("success-message");
        if (successMessage) {
            setTimeout(() => {
            successMessage.style.display = "none";
            }, 1000);
        }
    });