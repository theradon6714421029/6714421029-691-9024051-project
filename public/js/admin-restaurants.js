function openRestaurantModal(card = null) {
    document.getElementById('restaurantForm').reset();
    if (card) {
        document.getElementById('res_id').value = card.dataset.id;
        document.getElementById('res_name').value = card.dataset.name;
        document.getElementById('res_description').value = card.dataset.description;
        document.getElementById('res_open_time').value = card.dataset.openTime;
        document.getElementById('res_close_time').value = card.dataset.closeTime;
        document.getElementById('res_address').value = card.dataset.address;
        document.getElementById('res_phone').value = card.dataset.phone;
        document.getElementById('res_is_open').checked = card.dataset.isOpen === '1';
    } else {
        document.getElementById('res_id').value = '';
    }
}

document.addEventListener('click', (e) => {
    const btn = e.target.closest('.edit-restaurant-btn');
    if (btn) openRestaurantModal(btn.closest('[data-id]'));
});

document.getElementById('restaurantForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('res_id').value;

    const formData = new FormData();
    formData.append('name', document.getElementById('res_name').value);
    formData.append('description', document.getElementById('res_description').value);
    formData.append('open_time', document.getElementById('res_open_time').value);
    formData.append('close_time', document.getElementById('res_close_time').value);
    formData.append('address', document.getElementById('res_address').value);
    formData.append('phone', document.getElementById('res_phone').value);
    formData.append('is_open', document.getElementById('res_is_open').checked ? '1' : '0');
    const imgFile = document.getElementById('res_image').files[0];
    if (imgFile) formData.append('image', imgFile);

    const url = id ? `/admin/restaurants/${id}` : '/admin/restaurants';
    if (id) formData.append('_method', 'PUT');

    try {
        await apiFetch(url, { method: 'POST', body: formData });
        location.reload();
    } catch (err) {
        showToast(err.message, 'danger');
    }
});

document.addEventListener('click', async (e) => {
    if (!e.target.classList.contains('delete-restaurant-btn')) return;
    if (!confirm('ยืนยันการลบร้านนี้?')) return;

    const card = e.target.closest('[data-id]');
    try {
        await apiFetch(`/admin/restaurants/${card.dataset.id}`, { method: 'DELETE' });
        card.remove();
        showToast('ลบสำเร็จ');
    } catch (err) {
        showToast(err.message, 'danger');
    }
});