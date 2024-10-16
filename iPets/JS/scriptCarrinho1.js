document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.prod-quant').forEach(container => {
        const decrementButton = container.querySelector('.menos');
        const incrementButton = container.querySelector('.mais');
        const quantityDisplay = container.querySelector('.quant');

        decrementButton.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityDisplay.textContent);
            if (currentQuantity > 0) {
                quantityDisplay.textContent = currentQuantity - 1;
            }
        });

        incrementButton.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityDisplay.textContent);
            quantityDisplay.textContent = currentQuantity + 1;
        });
    });
});
