
//TODO: add the number of products in warehouse so there is a limit to cart.
//TODO: change item name length
//TODO: Add functionality to shipping option






const convertToUSD = (money) => {
  return money.toLocaleString('en-US', {
    style: 'currency',
    currency: 'USD'
  });
}
const updateCartList = (currentBtn) => {
  const row = currentBtn.closest('.row');
  const hrElement = row.previousElementSibling;
  row.remove();
  hrElement.remove();
}
const updateTotalPrices = (formattedTotal, formattedTotalAfterTax) => {
  const totalDisplayAfterTax = document.querySelector('#totalPriceAfterTax') ;
  const totalDisplay = document.querySelector('#cartTotalPrice');
  totalDisplay.textContent = formattedTotal ;
  totalDisplayAfterTax.textContent = formattedTotalAfterTax ;
}
const updateItemCount = (cartQuantity) => {
  const topQuantityDisplay = document.querySelector('#totalQuantityTop') ;
  const bottomQuantityDisplay = document.querySelector('#totalQuantitySide') ;
  // correctly formats and updates the item quantity labels
  if (cartQuantity === 0){
    bottomQuantityDisplay.textContent = ` items 0` ;
    topQuantityDisplay.textContent = `0 items` ;
  } else if (cartQuantity === 1) {
    bottomQuantityDisplay.textContent = `items ${cartQuantity} ` ;
    topQuantityDisplay.textContent = `${cartQuantity} item` ;
  } else {
    bottomQuantityDisplay.textContent = `items ${cartQuantity} ` ;
    topQuantityDisplay.textContent = `${cartQuantity} items` ;
  }
}
const deleteItemBtn = document.querySelectorAll(".removeProductCart") ;
const itemQuantityBtn = document.querySelectorAll(".itemQuantityCart") ;

/*
when item quantity changes, request is sent to the server to update the cart quantity.
The response received is the new total price and quantity
TODO: change to where request only gets sent once purchase is chosen or you select save to cart option
 this will lower amount of request sent to the server from cart front-end... going have only the front end change when
 cart gets edited but changes only persist when purchased or saved
*/
itemQuantityBtn.forEach((currentInput) => {
  currentInput.addEventListener('change', () => {
    console.log(currentInput.value) ;
    const productId = currentInput.getAttribute('data-productid') ;
    const data = {
      type : 'changeSingleItemAtOnce' ,
      productId : productId ,
      newQuantity : currentInput.value
    }
    const jsonData = JSON.stringify(data);

    fetch('../App/controller/AjaxHandler/cartAjaxHandler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'cartAjaxHandler/json'
      },
      body: jsonData
    })
      .then(response => response.json())
      .then(response => {
        console.log(response['message']) ;
        const cartQuantity = response['cartQuantity'] ;
        const cartTotal = response['cartTotalPrice'] ;
        const cartTotalAfterTax = response['cartTotalPriceAfterTax'] ;
        const formattedTotal = convertToUSD(cartTotal) ;
        const formattedTotalAfterTax = convertToUSD(cartTotalAfterTax) ;

        updateTotalPrices(formattedTotal, formattedTotalAfterTax) ;
        updateItemCount(cartQuantity) ;
      })
      .catch(error => console.error(`there was an error with ajax request LOCATED AT cartAjax.js:  ${error}`));
  })
})
// X delete button on the cart page to remove all of one item from the cart and updates cart accordingly
deleteItemBtn.forEach((currentBtn) => {
  currentBtn.addEventListener('click', () => {
    const productId = currentBtn.getAttribute('data-productid') ;
    const data = {
      type : 'deleteAllOfOneItem',
      productId: productId,
    };

    const jsonData = JSON.stringify(data);
    fetch('../App/controller/AjaxHandler/cartAjaxHandler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: jsonData
    })
      .then(response => response.json())
      .then(response => {

        console.log(response['message']) ;
        const cartQuantity = response['cartQuantity'] ;
        const cartTotal = response['cartTotalPrice'] ;
        const cartTotalAfterTax = response['cartTotalPriceAfterTax'] ;
        const formattedTotal = convertToUSD(cartTotal) ;
        const formattedTotalAfterTax = convertToUSD(cartTotalAfterTax) ;

        updateCartList(currentBtn) ;
        updateTotalPrices(formattedTotal, formattedTotalAfterTax) ;
        updateItemCount(cartQuantity) ;
      })
      .catch(error => console.error(`there was an error with ajax request LOCATED AT cartAjax.js:  ${error}`));
  })
})

