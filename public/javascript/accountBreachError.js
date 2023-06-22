const displayModal = () => {
  const modalHtml = `
<div class="modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Warning!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>We have detected a breach in your account. To protect your account, please reset your password.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary continue-shopping" data-dismiss="modal">
          Continue
        </button>
      </div>
    </div>
  </div>
</div>
  `;
  const modalContainer = document.createElement('div');
  modalContainer.innerHTML = modalHtml ;
  document.body.appendChild(modalContainer) ;
};
document.addEventListener('DOMContentLoaded', function() {
  displayModal() ;
  const modal = document.querySelector('.modal');
  modal.addEventListener('hide.bs.modal', function(event) {
    event.stopPropagation();
  });
  const modalInstance = new bootstrap.Modal(modal);
  modalInstance.show();
});

let test = 0 ;
