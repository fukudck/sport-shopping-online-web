$(document).on('click', '#ondelete', function () {
	const cartItemId = $(this).data('cart-item-id'); // Lấy ID sản phẩm trong giỏ hàng

	if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
			$.ajax({
					url: 'php/cart_process.php', // Tệp xử lý PHP
					type: 'POST',
					data: {
							action: 'delete_item',
							cart_item_id: cartItemId
					},
					success: function (response) {
							if (response.trim() === 'success') {
									alert('Xóa sản phẩm thành công.');
									refreshCart(); 
							} else if (response.trim() === 'empty_cart') {
									alert('Giỏ hàng hiện tại trống.');
									refreshCart();
							} else {
									alert('Có lỗi xảy ra, vui lòng thử lại.');
							}
					},
					error: function () {
							alert('Lỗi kết nối đến máy chủ.');
					}
			});
	}
});

function refreshCart() {
	// Gửi yêu cầu AJAX để tải lại nội dung giỏ hàng
	$.ajax({
			url: 'cart.php',
			type: 'GET',
			success: function (data) {
					const cartContent = $(data).find('#cart-container').html();
					$('#cart-container').html(cartContent);
			},
	});
}
function refreshPrice() {
	// Gửi yêu cầu AJAX để tải lại nội dung giỏ hàng
	$.ajax({
			url: 'cart.php', 
			type: 'GET',    
			success: function (data) {
					const totalPrice = $(data).find('#total-price').text();
					$('#total-price').text(totalPrice);
			},
	});
}

$(document).on('change', '.quantity-input', function () {
	const cartItemId = $(this).closest('div').find('button[data-cart-item-id]').data('cart-item-id');
	const newQuantity = $(this).val();

	if (newQuantity > 0) {
			$.ajax({
					url: './php/cart_process.php',
					type: 'POST',
					data: {
							action: 'update_quantity',
							cart_item_id: cartItemId,
							quantity: newQuantity
					},
					success: function (response) {
							if (response.status === 'success') {
									
									$('#total-price').text(response.total_price.toLocaleString() + ' VND');

									// Cập nhật giá trị hiển thị cho sản phẩm
									const itemPrice = response.updated_item_price.toLocaleString() + ' VND';
									$(`#item-price-${cartItemId}`).text(itemPrice);
							} else {
									refreshPrice();

							}
					},
					error: function () {
							alert('Đã xảy ra lỗi khi cập nhật số lượng.');
					}
			});
	} else {
			alert('Số lượng phải lớn hơn 0.');
			$(this).val(1); 
	}
});

