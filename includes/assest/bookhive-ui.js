document.addEventListener('change', async (e) => {
  const sel = e.target.closest('.bh-shelf-select');
  if (!sel) return;

  const bookId = sel.dataset.book;
  const shelf = sel.value;

  await fetch(bookhiveUI.ajaxurl, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'bookhive_set_shelf',
      nonce: bookhiveUI.nonce,
      book_id: bookId,
      shelf: shelf
    })
  });
});

document.addEventListener('click', async (e) => {
  const btn = e.target.closest('.bh-save-review');
  if (!btn) return;

  const bookId = btn.dataset.book;
  const rating = document.getElementById('bh-rating')?.value || 0;
  const spice  = document.getElementById('bh-spice')?.value || 0;
  const review = document.getElementById('bh-review')?.value || '';

  const status = document.querySelector('.bh-save-status');
  if (status) {
    status.style.display = 'block';
    status.textContent = 'Saving...';
  }

  const res = await fetch(bookhiveUI.ajaxurl, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'bookhive_save_review',
      nonce: bookhiveUI.nonce,
      book_id: bookId,
      rating,
      spice,
      review
    })
  });

  if (status) {
    status.textContent = res.ok ? 'Saved ✅' : 'Error saving ❌';
    setTimeout(() => status.style.display = 'none', 1500);
  }

  if (res.ok) location.reload();
});

