document.addEventListener("DOMContentLoaded", function () {
  const csrfToken = () =>
    document.querySelector('meta[name="csrf-token"]').getAttribute("content");

  const lockScroll = (locked) =>
    document.body.classList.toggle("overflow-hidden", locked);

  // --- Product page: gallery thumbnails and quantity stepper ----------------

  document.querySelectorAll("[data-gallery]").forEach((gallery) => {
    const main = gallery.querySelector("[data-gallery-main]");
    const thumbs = gallery.querySelectorAll("[data-gallery-thumb]");
    thumbs.forEach((thumb) =>
      thumb.addEventListener("click", () => {
        main.src = thumb.dataset.galleryThumb;
        thumbs.forEach((t) => t.setAttribute("aria-pressed", String(t === thumb)));
      })
    );
  });

  document.querySelectorAll("[data-quantity]").forEach((stepper) => {
    const input = stepper.querySelector('input[name="quantity"]');
    stepper.querySelectorAll("[data-quantity-step]").forEach((button) =>
      button.addEventListener("click", () => {
        const next = (parseInt(input.value, 10) || 1) + parseInt(button.dataset.quantityStep, 10);
        input.value = Math.min(Math.max(next, parseInt(input.min, 10)), parseInt(input.max, 10));
      })
    );
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeFilters();
      closeCart();
    }
  });

  // --- Catalogue filters ----------------------------------------------------

  const filtersPanel = document.getElementById("filters-panel");
  const filtersForm = document.getElementById("filters");

  function closeFilters() {
    if (filtersPanel && !filtersPanel.classList.contains("hidden") && window.innerWidth < 1024) {
      filtersPanel.classList.add("hidden");
      lockScroll(false);
    }
  }

  document.querySelectorAll("[data-filters-open]").forEach((button) =>
    button.addEventListener("click", () => {
      filtersPanel.classList.remove("hidden");
      lockScroll(true);
    })
  );
  document
    .querySelectorAll("[data-filters-close]")
    .forEach((el) => el.addEventListener("click", closeFilters));

  if (filtersForm) {
    // Leave empty filters out of the URL (?brand=&diameter=… otherwise).
    filtersForm.addEventListener("formdata", (event) => {
      for (const [key, value] of [...event.formData.entries()]) {
        if (value === "") event.formData.delete(key);
      }
    });
    document.querySelectorAll("[data-autosubmit]").forEach((select) =>
      select.addEventListener("change", () => filtersForm.requestSubmit())
    );
  }

  // --- Add to cart ----------------------------------------------------------

  document.addEventListener("submit", async (event) => {
    const form = event.target.closest("form[data-add-to-cart]");
    if (!form) return;
    event.preventDefault();

    const button = form.querySelector('button[type="submit"]');
    if (button.dataset.state === "loading") return;
    button.dataset.state = "loading";
    button.setAttribute("aria-busy", "true");

    try {
      const response = await fetch(form.action, {
        method: "POST",
        headers: { Accept: "application/json", "X-CSRF-TOKEN": csrfToken() },
        body: new FormData(form),
      });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const data = await response.json();

      shoppingCart.innerHTML = data.drawer;
      refreshCart();
      button.dataset.state = "added";
      button.removeAttribute("aria-busy");
      clearTimeout(button.resetTimer);
      button.resetTimer = setTimeout(() => (button.dataset.state = "idle"), 2000);
    } catch (error) {
      console.error("Add to cart failed, falling back to a form post:", error);
      form.submit();
    }
  });

  // --- Cart drawer ----------------------------------------------------------

  const cartModal = document.getElementById("cart-modal");
  const shoppingCart = document.getElementById("shopping-cart");

  function openCart() {
    cartModal.classList.remove("hidden");
    lockScroll(true);
  }

  function closeCart() {
    if (cartModal && !cartModal.classList.contains("hidden")) {
      cartModal.classList.add("hidden");
      lockScroll(false);
    }
  }

  document.getElementById("open-button")?.addEventListener("click", (event) => {
    event.preventDefault();
    openCart();
  });

  // One listener for the drawer, so it keeps working after it is re-rendered.
  cartModal.addEventListener("click", (event) => {
    if (!shoppingCart.contains(event.target)) {
      closeCart();
      return;
    }

    const target = event.target.closest(
      "#cart-close-button, #continue-shopping, .remove-item, .decrease-quantity, .increase-quantity"
    );
    if (!target) return;
    event.preventDefault();

    if (target.matches("#cart-close-button, #continue-shopping")) {
      closeCart();
    } else if (target.matches(".remove-item")) {
      removeFromCart(target.dataset.id);
    } else {
      const id = target.dataset.id;
      const display = document.getElementById(`quantity-${id}`);
      let quantity = parseInt(display.innerText, 10);
      if (target.matches(".decrease-quantity")) {
        if (quantity <= 1) return;
        quantity -= 1;
      } else {
        quantity += 1;
      }
      display.innerText = quantity;
      updateCart(id, quantity);
      refreshCart();
    }
  });

  const postJson = (url) =>
    fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-CSRF-TOKEN": csrfToken(),
      },
    }).then((response) => {
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      return response.json();
    });

  function removeFromCart(id) {
    postJson(`/cart/remove/${id}`)
      .then(() => {
        document.querySelector(`.cart-item[data-id="${id}"]`)?.remove();
        if (!document.querySelector(".cart-item")) {
          document.getElementById("checkout")?.remove();
        }
        refreshCart();
      })
      .catch((error) => console.error("Error:", error));
  }

  function updateCart(id, quantity) {
    postJson(`/cart/update/${id}/${quantity}`).catch((error) =>
      console.error("Error:", error)
    );
  }

  // Recomputes the subtotal, the header count and the empty message from the drawer.
  function refreshCart() {
    let subtotal = 0;
    let count = 0;
    document.querySelectorAll(".cart-item").forEach((item) => {
      const id = item.dataset.id;
      const quantity = parseInt(document.getElementById(`quantity-${id}`).innerText, 10);
      const price = parseFloat(item.querySelector(".product-price").dataset.price);
      subtotal += price * quantity;
      count += quantity;
    });

    const subtotalElement = document.getElementById("subtotal-amount");
    subtotalElement.innerText =
      subtotalElement.dataset.currency +
      subtotal.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    document.getElementById("empty-cart-message").classList.toggle("hidden", count > 0);

    const cartCount = document.getElementById("cart-count");
    if (cartCount) {
      cartCount.innerText = count;
      cartCount.classList.toggle("hidden", count === 0);
    }
  }

  refreshCart();

  // --- Mobile menu ----------------------------------------------------------

  const menuButton = document.getElementById("menu-button");
  const sidebarModal = document.getElementById("sidebar-modal");
  const sidebarMenu = document.getElementById("sidebar-menu");

  if (menuButton) {
    const setMenu = (open) => {
      menuButton.setAttribute("aria-expanded", String(open));
      sidebarModal.classList.toggle("hidden", !open);
      lockScroll(open);
    };
    menuButton.addEventListener("click", () => setMenu(true));
    document.getElementById("close-button").addEventListener("click", () => setMenu(false));
    sidebarModal.addEventListener("click", (event) => {
      if (!sidebarMenu.contains(event.target)) setMenu(false);
    });
  }

  // --- Flash message --------------------------------------------------------

  const successMessage = document.getElementById("success-message");
  if (successMessage) {
    successMessage.style.transition = "opacity 400ms";
    setTimeout(() => (successMessage.style.opacity = "0"), 2500);
    setTimeout(() => successMessage.remove(), 3000);
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

  // The phone dropdown only exists on the checkout page.
  if (dropdownButton && dropdownMenu) {
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

window.addEventListener("load", function () {
  const banner = document.getElementById("cookie-banner");
  if (!banner) return;

  let shown = false;
  try {
    shown = localStorage.getItem("cookieBannerShown") === "true";
  } catch (e) {
    // Storage blocked: show the banner every time.
  }
  if (shown) {
    banner.remove();
    return;
  }

  setTimeout(() => {
    banner.classList.remove("invisible", "opacity-0");
    banner.classList.add("opacity-100");
  }, 1000);

  const answer = (consent) => {
    try {
      localStorage.setItem("cookie_consent", consent);
      localStorage.setItem("cookieBannerShown", "true");
    } catch (e) {
      // Nothing to remember.
    }
    banner.remove();
  };

  document.getElementById("acceptButton").addEventListener("click", () => answer("yes"));
  document.getElementById("declineButton").addEventListener("click", () => answer("no"));
});
