<x-app-layout>
    @include('components.checkout')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
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
});
  </script>
</x-app-layout>    