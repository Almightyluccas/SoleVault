const displayModalHome = (productName) => {
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









const addToCartBtn = document.querySelector('.buttonCart') ;

addToCartBtn.addEventListener('click', () => {
  console.log('clicked')
  const productId = addToCartBtn.getAttribute('data-productid') ;
  const data = {
    productId: productId,
  };

  const jsonData = JSON.stringify(data);
  fetch('../App/controller/AjaxHandler/homeAjaxHandler.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: jsonData
  })
    .then(response => response.text())
    .then(productName => {
      displayModalHome(productName) ;
    })
    .catch(error => console.error(`there was an error with ajax request LOCATED AT homeAjax.js:  ${error}`));

})

