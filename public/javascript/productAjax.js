const displayModal = (productName) => {
  const modalHtml = `
    <div class="modal" tabindex="-1" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Congratulations!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>${productName} has been successfully added to the cart</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary continue-shopping" data-dismiss="modal">
              Continue Shopping
            </button>
            <button type="button" class="btn btn-primary go-to-cart">
              Go to Cart
            </button>
          </div>
        </div>
      </div>
    </div>
  `;
  const modalContainer = document.createElement('div');
  modalContainer.innerHTML = modalHtml;
  document.body.appendChild(modalContainer);

  const modal = modalContainer.querySelector('.modal');
  const closeButton = modal.querySelector('.close');
  const continueShoppingBtn = modal.querySelector('.continue-shopping');
  const goToCartBtn = modal.querySelector('.go-to-cart');

  continueShoppingBtn.addEventListener('click', () => {
    modal.remove();
  });
  closeButton.addEventListener('click', () => {
    modal.remove();
  });
  goToCartBtn.addEventListener('click', () => {

    window.location.href = 'index.php?choice=cart';
  });

  modalContainer.addEventListener('click', (event) => {
    if (!event.target.closest('.modal-content')) {
      modal.remove();
    }
  });

  const modalInstance = new bootstrap.Modal(modal);
  modalInstance.show();
};

const addToCartBtn = document.querySelectorAll('.addToCartBtn') ;
addToCartBtn.forEach((currentBtn) => {
  const decreaseBtn = currentBtn.closest('.card-body').querySelector('.decreaseQuantity');
  const increaseBtn = currentBtn.closest('.card-body').querySelector('.increaseQuantity');

  decreaseBtn.addEventListener('click', () => {
    const quantityInput = currentBtn.closest('.card-body').querySelector('.quantitySelector');
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
      quantity--;
      quantityInput.value = quantity;
    }
  });
  increaseBtn.addEventListener('click', () => {
    const quantityInput = currentBtn.closest('.card-body').querySelector('.quantitySelector');
    let quantity = parseInt(quantityInput.value);
    quantity++;
    quantityInput.value = quantity;
  });

  currentBtn.addEventListener('click', () => {
    const productId = currentBtn.getAttribute('data-productid') ;
    const quantity = currentBtn.closest('.card-body').querySelector('.quantitySelector').value;
    const data = {
      productId: productId,
      quantity: quantity
    };
    const jsonData = JSON.stringify(data);
    fetch('../App/controller/AjaxHandler/productAjaxHandler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: jsonData
    })
      .then(response => response.text())
      .then(productName => {
        displayModal(productName) ;
      })
      .catch(error => console.error(`there was an error with ajax request LOCATED AT cartAjax.js:  ${error}`));
      })
  })
const showDescriptionButton = document.querySelectorAll('.show-description-btn');

showDescriptionButton.forEach(currentBtn => {
  currentBtn.addEventListener('click', function() {

    if(currentBtn.textContent === 'Show Description') {
      currentBtn.textContent = 'Hide Description' ;
    } else if (currentBtn.textContent === 'Hide Description') {
      currentBtn.textContent = 'Show Description' ;
    }
    const descriptionElement =  currentBtn.nextElementSibling ;
    descriptionElement.classList.toggle('d-none');
  });
})
