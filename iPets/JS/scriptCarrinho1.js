document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.prod-quant button');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const productId = this.closest('.prod').dataset.productId;
            const quantityElement = document.getElementById(`quant-${productId}`);
            let currentQuantity = parseInt(quantityElement.textContent);

            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            } else if (action === 'decrease' && currentQuantity === 1) {
                currentQuantity = 0;
            }

            quantityElement.textContent = currentQuantity;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "atualizarQuantidadeCarrinho.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    if (response.total) {
                        const totalElement = document.querySelector('.vals-item .total-price');
                        if (totalElement) {
                            totalElement.textContent = `R$ ${response.total}`;
                        }
                    } else if (response.error) {
                        console.log(response.error);
                        alert('Erro ao atualizar a quantidade. Tente novamente.');
                    }
                    
                    if (currentQuantity === 0) {
                        const productElement = document.querySelector(`.prod[data-product-id="${productId}"]`);
                        if (productElement) {
                            productElement.remove();
                        }
                    }
                } else if (xhr.readyState === 4) {
                    console.log('Erro ao atualizar a quantidade');
                    alert('Erro ao se comunicar com o servidor. Tente novamente.');
                }
            };

            xhr.send(`product_id=${productId}&quantity=${currentQuantity}`);
        });
    });
});
