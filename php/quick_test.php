<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VieGrand - Test Quick Submit</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #004aad;
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #004aad;
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .btn {
            background: linear-gradient(135deg, #004aad 0%, #0066ff 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            display: none;
        }
        
        .result.success {
            background: #f0fff4;
            border: 2px solid #22c55e;
            color: #065f46;
        }
        
        .result.error {
            background: #fef2f2;
            border: 2px solid #ef4444;
            color: #991b1b;
        }
        
        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-family: monospace;
            font-size: 14px;
            white-space: pre-wrap;
            border: 1px solid #dee2e6;
        }
        
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        
        .actions a {
            color: #004aad;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Quick Test Submit</h1>
            <p>Test nhanh gửi tin nhắn với dữ liệu mẫu</p>
        </div>
        
        <form id="quickTestForm">
            <div class="form-group">
                <label for="name">Họ và tên:</label>
                <input type="text" id="name" name="name" value="Nguyễn Văn Test" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="test@viegrand.com" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" value="0987654321">
            </div>
            
            <div class="form-group">
                <label for="subject">Chủ đề:</label>
                <select id="subject" name="subject" required>
                    <option value="">Chọn chủ đề</option>
                    <option value="Tư vấn sản phẩm" selected>Tư vấn sản phẩm</option>
                    <option value="Hỗ trợ kỹ thuật">Hỗ trợ kỹ thuật</option>
                    <option value="Phản hồi">Phản hồi</option>
                    <option value="Khác">Khác</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="message">Tin nhắn:</label>
                <textarea id="message" name="message" required>Đây là tin nhắn test từ Quick Test Submit. Thời gian: <?= date('d/m/Y H:i:s') ?></textarea>
            </div>
            
            <button type="submit" class="btn" id="submitBtn">
                🚀 Gửi Test Message
            </button>
        </form>
        
        <div id="result" class="result"></div>
        
        <div class="actions">
            <a href="status.php">📊 Xem Status</a>
            <a href="admin.php">👨‍💼 Admin Panel</a>
            <a href="test_form.html">🧪 Full Test Form</a>
        </div>
    </div>

    <script>
        document.getElementById('quickTestForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const resultDiv = document.getElementById('result');
            
            // Disable form and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '⏳ Đang gửi...';
            
            // Hide previous result
            resultDiv.style.display = 'none';
            
            try {
                const formData = new FormData(this);
                
                console.log('=== QUICK TEST SUBMIT START ===');
                console.log('Form data:', Object.fromEntries(formData));
                
                const response = await fetch('contact_form_debug.php', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers.entries()]);
                
                const responseText = await response.text();
                console.log('Raw response:', responseText);
                
                let jsonResponse;
                try {
                    jsonResponse = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    throw new Error('Server trả về dữ liệu không hợp lệ: ' + responseText.substring(0, 200));
                }
                
                console.log('Parsed response:', jsonResponse);
                
                // Show result
                resultDiv.style.display = 'block';
                
                if (jsonResponse.success) {
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `
                        <strong>✅ Thành công!</strong><br>
                        ${jsonResponse.message}<br>
                        <strong>ID tin nhắn:</strong> ${jsonResponse.data?.id || 'N/A'}
                        ${jsonResponse.debug ? '<div class="debug-info">' + JSON.stringify(jsonResponse.debug, null, 2) + '</div>' : ''}
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <strong>❌ Lỗi!</strong><br>
                        ${jsonResponse.message}
                        ${jsonResponse.debug ? '<div class="debug-info">' + JSON.stringify(jsonResponse.debug, null, 2) + '</div>' : ''}
                        ${jsonResponse.errors ? '<div class="debug-info">Errors: ' + JSON.stringify(jsonResponse.errors, null, 2) + '</div>' : ''}
                    `;
                }
                
            } catch (error) {
                console.error('Submit error:', error);
                
                resultDiv.style.display = 'block';
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `
                    <strong>💥 Lỗi nghiêm trọng!</strong><br>
                    ${error.message}
                    <div class="debug-info">
Kiểm tra:
1. File contact_form_debug.php có tồn tại không?
2. Có lỗi PHP không? (kiểm tra error log)
3. Database có kết nối được không?
4. Đường dẫn file có đúng không?
                    </div>
                `;
            } finally {
                // Re-enable form
                submitBtn.disabled = false;
                submitBtn.innerHTML = '🚀 Gửi Test Message';
                
                console.log('=== QUICK TEST SUBMIT END ===');
            }
        });
        
        // Auto-focus first field
        document.getElementById('name').focus();
    </script>
</body>
</html>
