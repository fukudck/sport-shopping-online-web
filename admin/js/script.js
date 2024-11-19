// Hàm xóa sản phẩm với xác nhận
function deleteProduct(productId) {
  // Xác nhận xóa sản phẩm
  if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
    // Tạo form tạm thời gửi yêu cầu POST
    var form = document.createElement("form");
    form.method = "POST";
    form.action = ""; // Gửi lại trang hiện tại

    // Tạo input cho product_id và yêu cầu xóa
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "product_id";
    input.value = productId;

    var deleteInput = document.createElement("input");
    deleteInput.type = "hidden";
    deleteInput.name = "delete";
    deleteInput.value = "1";

    form.appendChild(input);
    form.appendChild(deleteInput);

    // Thêm form vào body và gửi
    document.body.appendChild(form);
    form.submit();
  }
}
