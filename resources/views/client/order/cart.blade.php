        @php
            $total = 0;
            $hasProduct = false;
        @endphp
        <form action="{{ route('client.cart.update', 0) }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        @if (isset($item['product_id']) && isset($item['quantity']) && isset($productMap[$item['product_id']]))
                            @php
                                $hasProduct = true;
                                $prod = $productMap[$item['product_id']];
                                $productName = $prod['name'] ?? 'Sản phẩm #' . $item['product_id'];
                                $price = isset($prod['price']) ? (float) $prod['price'] : 0;
                                $image = $prod['image_url'] ?? null;
                                $subtotal = $price * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    @if ($image)
                                        <img src="{{ $image }}" alt="{{ $productName }}"
                                            style="width:60px;height:40px;object-fit:cover;margin-right:8px;">
                                    @endif
                                    <b>{{ $productName }}</b>
                                    <br>
                                    <span class="text-muted">ID: {{ $item['product_id'] }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('client.cart.update', $item['product_id']) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                            min="1" style="width:60px;">
                                        <button type="submit" class="btn btn-sm btn-info">Cập nhật</button>
                                    </form>
                                </td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }} VNĐ<br><small class="text-muted">Đơn
                                        giá: {{ number_format($price, 0, ',', '.') }} VNĐ</small></td>
                                <td>
                                    <form action="{{ route('client.cart.remove', $item['product_id']) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if (!$hasProduct)
                        <tr>
                            <td colspan="4" class="text-center text-muted">Giỏ hàng của bạn đang trống.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="text-right">
                <h4>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</h4>
                <h5>Bạn cần đặt cọc 30%: <span class="text-danger">{{ number_format($total * 0.3, 0, ',', '.') }}
                        VNĐ</span></h5>
            </div>
            <button type="button" class="btn btn-success mt-3" id="openOrderModal"
                @if (!$hasProduct) disabled @endif>Đặt hàng & Đặt cọc 30%</button>
        </form>
        </td>
        </tr>
        @endif
        @endforeach
        </tbody>
        </table>
        <div class="text-right">
            <h4>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</h4>
            <h5>Bạn cần đặt cọc 30%: <span class="text-danger">{{ number_format($total * 0.3, 0, ',', '.') }}
                    VNĐ</span></h5>
        </div>
        <button type="button" class="btn btn-success mt-3" id="openOrderModal">Đặt hàng & Đặt cọc 30%</button>
        </form>
        @endif
        </div>

        <!-- Modal Đặt hàng -->
        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Đặt hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="cartOrderForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="orderName">Họ tên</label>
                                <input type="text" class="form-control" id="orderName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="orderPhone">Số điện thoại</label>
                                <input type="text" class="form-control" id="orderPhone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="orderAddress">Địa chỉ</label>
                                <input type="text" class="form-control" id="orderAddress" name="address" required>
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <input type="text" class="form-control" id="orderNote" name="note">
                            </div>
                            <div class="form-group">
                                <label>Đặt cọc (30%)</label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($total * 0.3, 0, ',', '.') }} VNĐ" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success">Xác nhận đặt hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách đơn hàng đã đặt (từ cookie) -->
        <div class="container mt-5" id="orderListContainer" style="display:none;">
            <h4>Đơn hàng của bạn</h4>
            <div id="orderList"></div>
        </div>

        <script>
            // Helper: đọc/ghi cookie đơn giản
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (encodeURIComponent(value) || "") + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
                }
                return null;
            }

            // Hiển thị danh sách đơn hàng từ cookie
            function renderOrderList() {
                var orderList = getCookie('orders');
                if (orderList) {
                    try {
                        var orders = JSON.parse(orderList);
                        if (orders.length > 0) {
                            var html = '<ul class="list-group">';
                            orders.forEach(function(order, idx) {
                                html += '<li class="list-group-item">';
                                html += '<b>Khách:</b> ' + order.name + ' | <b>SDT:</b> ' + order.phone +
                                    ' | <b>Địa chỉ:</b> ' + order.address + '<br>';
                                html += '<b>Đặt cọc:</b> ' + order.deposit + ' | <b>Thời gian:</b> ' + order.time +
                                    '<br>';
                                html += '<b>Ghi chú:</b> ' + (order.note || '') + '</li>';
                            });
                            html += '</ul>';
                            document.getElementById('orderList').innerHTML = html;
                            document.getElementById('orderListContainer').style.display = '';
                        }
                    } catch (e) {}
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Mở modal đặt hàng
                document.getElementById('openOrderModal').onclick = function() {
                    $('#orderModal').modal('show');
                };

                // Xử lý submit form đặt hàng
                document.getElementById('cartOrderForm').onsubmit = function(e) {
                    e.preventDefault();
                    var name = document.getElementById('orderName').value;
                    var phone = document.getElementById('orderPhone').value;
                    var address = document.getElementById('orderAddress').value;
                    var note = document.getElementById('orderNote').value;
                    var deposit = '{{ number_format($total * 0.3, 0, ',', '.') }} VNĐ';
                    var time = new Date().toLocaleString();
                    var order = {
                        name,
                        phone,
                        address,
                        note,
                        deposit,
                        time
                    };
                    // Lưu vào cookie (danh sách đơn hàng)
                    var orders = [];
                    var old = getCookie('orders');
                    if (old) {
                        try {
                            orders = JSON.parse(old);
                        } catch (e) {}
                    }
                    orders.push(order);
                    setCookie('orders', JSON.stringify(orders), 7);
                    alert('Đặt hàng thành công!');
                    $('#orderModal').modal('hide');
                    renderOrderList();
                };

                // Hiển thị đơn hàng nếu có cookie
                renderOrderList();
            });
        </script>
    @endsection
