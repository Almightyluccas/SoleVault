document.addEventListener('DOMContentLoaded', () =>{
  document.querySelector('#backToHome').addEventListener('click', (e) => {
    e.preventDefault() ;
    console.log('clicked') ;
    window.location.href = 'index.php?choice=home' ;
  })
})