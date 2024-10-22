document.addEventListener("DOMContentLoaded", function () {
  // homepage modal window

  const products = document.querySelectorAll("#product");
  const modals = document.querySelectorAll("#modal");
  const productsDetail = document.querySelectorAll("#productDetail");
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
    const totalSlides = items.length;
    let activeIndex = 0;

    const showItem = (index) => {
      const offset = -index * 100;
      carousel.style.transform = `translateX(${offset}%)`;

      indicators.forEach((indicator, i) => {
        indicator.classList.toggle("bg-gray-400", i === index);
        indicator.classList.toggle("bg-gray-300", i !== index);
      });
    };

    indicators.forEach((indicator, i) => {
      indicator.addEventListener("click", (event) => {
        index = i;
        showItem(index);
      });
    });

    const prevItem = () => {
      let prevIndex = activeIndex;
      activeIndex = (activeIndex - 1 + totalSlides) % totalSlides;
      showItem(activeIndex);
    };

    const nextItem = () => {
      let prevIndex = activeIndex;
      activeIndex = (activeIndex + 1) % totalSlides;
      showItem(activeIndex);
    };

    prevButton.addEventListener("click", prevItem);
    nextButton.addEventListener("click", nextItem);
  });

  // modal Add To Cart
  document.body.addEventListener("click", (event) => {
    if (event.target.matches("#btn-addToCart")) {
      event.preventDefault();
      const productLink = event.target.getAttribute("productlink");
      const newLink = document.createElement("a");
      newLink.setAttribute("href", productLink);
      document.body.appendChild(newLink);
      newLink.click();
    }
  });

  //shopping cart

  //shopping cart close button

  const closeButton = document.getElementById("cart-close-button");
  const shoppingCart = document.getElementById("shopping-cart");
  const modal = document.getElementById("modal");

  closeButton.addEventListener("click", (event) => {
    event.preventDefault();
    shoppingCart.classList.add("hidden");
    modal.classList.add("hidden");
  });

  //shopping cart open button

  const openButton = document.getElementById("open-button");
  if (openButton) {
    openButton.addEventListener("click", (event) => {
      event.preventDefault();
      modal.classList.remove("hidden");
      shoppingCart.classList.remove("hidden");
    });
  }

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
  let currentWordIndex =
    parseInt(localStorage.getItem("dynamicWordIndex")) || 0;
  const targetElement = document.querySelector(".Banner__title--second");

  if (targetElement) {
    async function updateDynamicWord() {
      const dynamicWord = dynamicWords[currentWordIndex];
      const targetElement = document.querySelector(".Banner__title--second");
      // Clear existing content
      if (targetElement.textContent.length > 0) {
        let str = targetElement.textContent;
        await eraseText(targetElement);
      }
      targetElement.innerHTML = ""; // Use innerHTML to clear the element

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
  }
 
    //dropdown button in navbar
    
      const button = document.getElementById('menu-button');
      const sidebar = document.getElementById('sidebar-menu');
      const sidebarModal = document.getElementById('sidebar-modal');

    // sidebar
    if (button) {
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
    }

  //Notification message

  function fadeOut(element) {
    let currentOpacity = 3.5;

    function frame() {
      if (currentOpacity <= 0) {
        element.style.display = "none";
        return;
      }
      currentOpacity -= 0.02; // Adjust speed of fade-out
      element.style.opacity = currentOpacity;
      requestAnimationFrame(frame);
    }

    requestAnimationFrame(frame);
  }

  const successMessage = document.getElementById("success-message");
  if (successMessage) {
    fadeOut(successMessage);
  }

  const checkoutButton = document.getElementById("checkout");
  if (checkoutButton) {
    checkoutButton.addEventListener("click", function (event) {
      event.preventDefault();
      window.location.href = "/checkout";
    });
  }

  //home button

  //   document.addEventListener('DOMContentLoaded', function() {
  //     // Initially hide the home button
  //     document.getElementById('homeButton').style.display = 'none';

  //     // Check if the user is authenticated
  //     if (window.location.href.includes('/dashboard')) { // Adjust '/dashboard' to match your route
  //         // Show the home button if the user is on the dashboard page
  //         document.getElementById('homeButton').style.display = 'inline-block';
  //     }
  // });
  const removeButtons = document.querySelectorAll("#remove-item");
  const quantityInputs = document.querySelectorAll(".quantity-display");
  const emptyCartMessage = document.getElementById("empty-cart-message");

  function checkIfCartIsEmpty() {
    const cartItems = document.querySelectorAll(".cart-item");
    if (cartItems.length === 0) {
      emptyCartMessage.classList.remove("hidden");
    } else {
      emptyCartMessage.classList.add("hidden");
    }
  }

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
          // Remove the item from the DOM
          const itemElement = document.querySelector(
            `.cart-item[data-id="${productId}"]`
          );
          if (itemElement) {
            itemElement.remove();
          }
          calculateSubtotal();
          updateCartCount();
          checkIfCartIsEmpty();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  });

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
        updateCartCount();
      }
    });

    increaseButton.addEventListener("click", (event) => {
      event.preventDefault();
      let quantity = parseInt(display.innerText);
      quantity += 1;
      display.innerText = quantity;
      updateCart(productId, quantity);
      calculateSubtotal();
      updateCartCount();
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
        console.log("Cart updated successfully.");
      })
      .catch((error) => {
        console.error("Error:", error);
      });
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

  function updateCartCount() {
    let totalQuantity = 0;
    const quantityDisplays = document.querySelectorAll(".quantity-display");
    quantityDisplays.forEach((display) => {
      totalQuantity += parseInt(display.innerText);
    });
    document.getElementById("cart-count").innerText = totalQuantity;
  }

  checkIfCartIsEmpty();
  calculateSubtotal();
  if ( document.getElementById("cart-count")) {
    updateCartCount();
  }
});

const cardNumberInput = document.getElementById("card-number-input");
const errorMessage = document.getElementById("error-message");
if (cardNumberInput) {
  cardNumberInput.addEventListener("input", function (e) {
    let value = e.target.value.replace(/\s+/g, "").replace(/[^0-9]/gi, "");
    let formattedValue = value.replace(/(.{4})/g, "$1 ").trim();

    e.target.value = formattedValue;

  });

  // checkout
  const dropdownButton = document.getElementById('dropdown-phone-button-3');
  const dropdownMenu = document.getElementById('dropdown-phone-3');
  const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');

  dropdownButton.addEventListener('click', function() {
    dropdownMenu.classList.toggle('hidden');
  });

  dropdownItems.forEach(function(item) {
    item.addEventListener('click', function() {
      const value = this.getAttribute('data-value');
      const buttonLabel = this.innerHTML.trim();
      dropdownButton.innerHTML = `${buttonLabel} <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" /></svg>`;
      dropdownMenu.classList.add('hidden');
    });
  });

  document.addEventListener('click', function(event) {
    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.add('hidden');
    }
  });
}

const cardExpirationInput = document.getElementById('card-expiration-input');
if (cardExpirationInput) {
  cardExpirationInput.addEventListener('input', function(e) {
    let input = e.target.value;
    if (e.inputType === 'deleteContentBackward') {
        e.target.value = input;
        return;
    }
  
    if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
    const values = input.split('/').map(function(v) {
        return v.replace(/\D/g, '');
    });
    if (values[0]) values[0] = checkValue(values[0], 12);
    if (values[1]) values[1] = checkValue(values[1], 99);
    const output = values.map(function(v, i) {
        return v.length == 2 && i == 0 ? v + '/' : v;
    });
    e.target.value = output.join('').substr(0, 5);
  });
}

function checkValue(str, max) {
  if (str.charAt(0) !== '0' || str === '00') {
      let num = parseInt(str);
      if (isNaN(num) || num <= 0 || num > max) num = 1;
      str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ?
          '0' + num : num.toString();
  }
  return str;
}

window.onload = function() {
  // Check if the banner has already been shown
  if (!localStorage.getItem('cookieBannerShown')) {
    setTimeout(function() {
      const banner = document.getElementById('cookie-banner');
      banner.classList.remove('opacity-0'); // Make the banner visible
      banner.classList.add('opacity-100'); // Animate to full opacity
    }, 1000); // Wait for 3 seconds

    // Event listeners for buttons
    document.getElementById('acceptButton').addEventListener('click', function() {
      console.log('User accepted cookies.');
      // Logic for accepting cookies
      localStorage.setItem('cookie_consent', 'yes');
      hideCookieBanner();
    });

    document.getElementById('declineButton').addEventListener('click', function() {
      console.log('User declined cookies.');
      // Logic for declining cookies
      localStorage.setItem('cookie_consent', 'no');
      showDeclineMessage();
      hideCookieBanner();
    });

    function hideCookieBanner() {
      const banner = document.getElementById('cookie-banner');
      banner.style.display = 'none'; // Alternatively, you can use banner.classList.add('hidden');
      localStorage.setItem('cookieBannerShown', 'true'); // Set the flag
    }
  }
};
function showDeclineMessage() {
  alert('We respect your choice. Some features may not work as intended.'); // Or manipulate the DOM to show a custom message
}