{{-- Cart drawer. Its contents (cart-panel) are re-rendered after a fetch add-to-cart. --}}
<div class="relative z-30 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" id="cart-modal">
    <div class="fixed inset-0 bg-ink-950/60 transition-opacity"></div>
    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div class="flex h-full w-screen max-w-md flex-col bg-white shadow-panel" id="shopping-cart">
            @include('components.cart-panel')
        </div>
    </div>
</div>
