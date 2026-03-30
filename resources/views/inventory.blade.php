<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Apex Inventory | Smart Inventory Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/@zxing/library@0.18.6/umd/index.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            background: var(--bg-body);
            transition: background 0.3s, color 0.2s;
        }

        :root {
            --dark-olive: #1b4d3e;
            --light-sage: #7cb342;
            --white-soft: #f8faf7;
            --card-bg: #ffffff;
            --text-dark: #1b4d3e;
            --text-soft: #4a7c6f;
            --border-light: #d0dbd5;
            --error-red: #e74c3c;
            --success-green: #27ae60;
            --bg-body: #eef3ea;
            --shadow-sm: 0 8px 20px rgba(0,0,0,0.03), 0 2px 6px rgba(0,0,0,0.05);
            --shadow-md: 0 12px 28px rgba(0,0,0,0.08);
            --radius-card: 40px;
            --radius-element: 32px;
        }

        body.dark {
            --white-soft: #1f2b24;
            --card-bg: #1e2c25;
            --text-dark: #eaf7e2;
            --text-soft: #c2e0b8;
            --border-light: #3c5a48;
            --bg-body: #121b15;
            --shadow-sm: 0 8px 20px rgba(0,0,0,0.4);
            --shadow-md: 0 12px 28px rgba(0,0,0,0.5);
        }

        /* refined typography + readability */
        body {
            font-weight: 450;
            line-height: 1.5;
            letter-spacing: -0.01em;
        }

        .app-shelf {
            max-width: 1440px;
            margin: 24px auto;
            background: var(--card-bg);
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: transform 0.2s, background 0.2s;
            backdrop-filter: blur(0px);
        }

        /* Login Panel with gentle elegance */
        .login-reef {
            min-height: 620px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            background: var(--white-soft);
            background-image: radial-gradient(circle at 10% 20%, rgba(124,179,66,0.03) 0%, transparent 60%);
        }

        .brand-name {
            font-size: 48px;
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--dark-olive) 0%, var(--light-sage) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: none;
        }
        body.dark .brand-name {
            background: linear-gradient(135deg, #c0e6b0, #a0d47a);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .brand-tagline {
            color: var(--text-soft);
            text-align: center;
            margin-bottom: 36px;
            font-size: 1.1rem;
            font-weight: 450;
        }

        .login-panel {
            background: var(--card-bg);
            border: 1px solid rgba(124,179,66,0.3);
            border-radius: 56px;
            padding: 42px 36px;
            width: 100%;
            max-width: 440px;
            backdrop-filter: blur(2px);
            box-shadow: var(--shadow-sm);
        }

        .field {
            margin-bottom: 24px;
        }

        .field label {
            display: block;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .field input {
            width: 100%;
            padding: 14px 22px;
            background: var(--white-soft);
            border: 1.5px solid var(--border-light);
            border-radius: 60px;
            font-size: 1rem;
            color: var(--text-dark);
            transition: all 0.2s;
        }

        .field input:focus {
            outline: none;
            border-color: var(--light-sage);
            box-shadow: 0 0 0 3px rgba(124,179,66,0.2);
        }

        .signin-btn {
            width: 100%;
            background: linear-gradient(105deg, #1b4d3e, #2b6b4f);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 60px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .signin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27,77,62,0.3);
            background: linear-gradient(105deg, #123f32, #1b4d3e);
        }

        /* Dashboard header refined */
        .dashboard {
            display: none;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 36px;
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-light);
            flex-wrap: wrap;
            gap: 12px;
        }

        .logo-area span {
            font-weight: 800;
            font-size: 24px;
            background: linear-gradient(125deg, var(--dark-olive), var(--light-sage));
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .greeting {
            background: var(--white-soft);
            padding: 8px 24px;
            border-radius: 60px;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: inset 0 0 0 1px var(--border-light);
        }

        .logout-btn, .theme-toggle {
            background: transparent;
            border: 1px solid var(--border-light);
            padding: 8px 20px;
            border-radius: 60px;
            cursor: pointer;
            color: var(--text-dark);
            font-weight: 500;
            transition: 0.2s;
        }
        .logout-btn:hover, .theme-toggle:hover {
            background: var(--white-soft);
            border-color: var(--light-sage);
        }

        /* Sidebar modern */
        .sidebar {
            width: 240px;
            background: var(--white-soft);
            padding: 32px 0;
            border-right: 1px solid var(--border-light);
        }

        .sidebar-item {
            padding: 14px 28px;
            margin: 6px 12px;
            border-radius: 40px;
            cursor: pointer;
            color: var(--text-soft);
            transition: all 0.2s;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-item i {
            width: 24px;
            font-size: 1.2rem;
        }

        .sidebar-item.active {
            background: var(--card-bg);
            color: var(--light-sage);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid var(--border-light);
        }
        .sidebar-item:not(.active):hover {
            background: var(--card-bg);
            color: var(--text-dark);
        }

        /* Content containers */
        .content {
            flex: 1;
            padding: 32px 36px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white-soft);
            padding: 28px 20px;
            border-radius: 32px;
            text-align: center;
            transition: all 0.2s;
            border: 1px solid var(--border-light);
            backdrop-filter: blur(2px);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
        }

        .stat-number {
            font-size: 52px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.1;
            margin-bottom: 8px;
        }

        /* Scanner section improved */
        .scanner-section {
            background: var(--white-soft);
            border-radius: 36px;
            padding: 28px;
            margin-bottom: 28px;
            border: 1px solid var(--border-light);
        }

        .upload-area {
            background: var(--card-bg);
            border: 2px dashed var(--light-sage);
            border-radius: 36px;
            padding: 48px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s;
        }

        .upload-area:hover {
            border-color: var(--dark-olive);
            background: var(--white-soft);
            transform: scale(0.99);
        }

        .upload-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--light-sage);
            color: white;
            padding: 12px 30px;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .upload-label:hover {
            background: #5f9e2e;
            transform: scale(1.02);
        }

        .preview-img {
            max-width: 100%;
            max-height: 280px;
            border-radius: 28px;
            border: 2px solid var(--border-light);
            background: var(--white-soft);
            box-shadow: var(--shadow-sm);
        }

        .detect-btn {
            background: var(--dark-olive);
            border: none;
            padding: 12px 28px;
            border-radius: 60px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            transition: 0.2s;
        }
        .detect-btn:hover {
            background: #0f3529;
            transform: scale(1.02);
        }

        .scanner-status {
            text-align: center;
            padding: 14px;
            margin: 20px 0 0;
            border-radius: 60px;
            font-weight: 500;
            animation: fadeIn 0.3s;
        }

        .scanner-status.success { background: var(--success-green); color: white; }
        .scanner-status.error { background: var(--error-red); color: white; }
        .scanner-status.info { background: var(--light-sage); color: white; }

        .scan-tip {
            background: linear-gradient(125deg, rgba(124,179,66,0.15), rgba(27,77,62,0.1));
            border: 1px solid var(--border-light);
            color: var(--text-dark);
            padding: 18px;
            border-radius: 32px;
            margin-top: 24px;
            font-size: 0.85rem;
        }

        .product-form, .product-detail-card {
            background: var(--white-soft);
            border-radius: 36px;
            padding: 28px;
            margin-top: 24px;
            border: 1px solid var(--border-light);
            animation: fadeIn 0.3s;
        }

        .form-group input, .form-group select, .form-group textarea {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: 48px;
            padding: 12px 20px;
            color: var(--text-dark);
        }
        .form-group textarea {
            border-radius: 28px;
        }

        .image-upload-area {
            border: 2px dashed var(--light-sage);
            border-radius: 28px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            background: var(--card-bg);
        }

        .product-image-preview {
            max-width: 140px;
            max-height: 140px;
            border-radius: 20px;
            object-fit: cover;
        }

        .product-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid var(--border-light);
        }

        .detail-image {
            max-width: 180px;
            max-height: 180px;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: var(--shadow-sm);
        }

        .save-btn {
            background: var(--light-sage);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 60px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }
        .save-btn:hover {
            transform: scale(1.01);
            filter: brightness(0.96);
        }
        .cancel-btn { background: #7a8e7c; }
        .cancel-btn:hover { background: #5c6e5e; }

        /* Table readability */
        .stock-table {
            background: var(--white-soft);
            border-radius: 36px;
            padding: 24px;
            border: 1px solid var(--border-light);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-dark);
        }
        th {
            font-weight: 600;
            color: var(--text-soft);
        }

        .action-icons i {
            margin: 0 6px;
            cursor: pointer;
            color: var(--text-soft);
            transition: 0.2s;
            font-size: 1.1rem;
        }
        .action-icons i:hover {
            color: var(--light-sage);
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-light);
        }
        .detail-label {
            width: 120px;
            font-weight: 600;
            color: var(--text-dark);
        }
        .detail-value {
            flex: 1;
            color: var(--text-dark);
        }

        .toast-shelf {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1100;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .toast-fresh {
            background: var(--light-sage);
            color: white;
            padding: 12px 26px;
            border-radius: 60px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(4px);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .drag-over {
            border-color: var(--success-green);
            background: rgba(124,179,66,0.12);
            transform: scale(1.01);
        }

        .barcode-value {
            font-family: 'SF Mono', monospace;
            font-size: 1rem;
            letter-spacing: 0.5px;
            background: var(--card-bg);
            display: inline-block;
            padding: 4px 12px;
            border-radius: 40px;
        }
        input#searchStock {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: 60px;
            padding: 10px 20px;
            color: var(--text-dark);
        }
        input#manualBarcode {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
        }
        button#detectFromImageBtn, .detect-btn {
            background: var(--dark-olive);
        }
        /* Dark mode text fix - high contrast */
        body.dark .stat-card, body.dark .scanner-section, body.dark .stock-table,
        body.dark .product-form, body.dark .product-detail-card, body.dark .upload-area,
        body.dark .login-panel {
            color: var(--text-dark);
        }
        body.dark .detail-label, body.dark .detail-value, body.dark td, body.dark th,
        body.dark .form-group label, body.dark .field label, body.dark .greeting {
            color: var(--text-dark);
        }
        body.dark input, body.dark select, body.dark textarea {
            color: #eef7e6;
            background: #2c3d33;
            border-color: #527a61;
        }
        body.dark .upload-label, body.dark .save-btn {
            color: white;
        }
        body.dark .sidebar-item {
            color: #c2dfb5;
        }
        body.dark .sidebar-item.active {
            color: #c2e05c;
            background: #2e4136;
        }
        body.dark .logout-btn, body.dark .theme-toggle {
            color: #daf1ce;
        }
    </style>
</head>
<body>
<div class="app-shelf">
    <div id="loginPage" class="login-reef">
        <div class="brand-name">Apex Inventory</div>
        <div class="brand-tagline">Smart Inventory. Smarter Decisions.</div>
        <div class="login-panel">
            <div class="field">
                <label>Username</label>
                <input type="text" id="username" placeholder="Enter username">
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" id="password" placeholder="Enter password">
            </div>
            <button class="signin-btn" onclick="login()">Sign In →</button>
            <div id="loginError" style="color:var(--error-red); text-align:center; margin-top:15px;"></div>
        </div>
    </div>

    <div id="dashboard" class="dashboard">
        <div class="top-bar">
            <div class="logo-area"><span>ApexInventory</span></div>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <div class="greeting">Welcome, <span id="usernameDisplay"></span></div>
                <button class="theme-toggle" onclick="toggleTheme()"><i class="fas fa-moon"></i> Dark/Light</button>
                <button class="logout-btn" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>

        <div class="main-layout">
            <div class="sidebar">
                <div class="sidebar-item active" onclick="showPage('dashboardPage')"><i class="fas fa-chart-line"></i> Dashboard</div>
                <div class="sidebar-item" onclick="showPage('scanPage')"><i class="fas fa-camera"></i> Scan & Add</div>
                <div class="sidebar-item" onclick="showPage('stockPage')"><i class="fas fa-boxes"></i> Stock</div>
                <div class="sidebar-item" onclick="showPage('settingsPage')"><i class="fas fa-sliders-h"></i> Settings</div>
            </div>

            <div class="content">
                <div id="dashboardPage">
                    <div class="stats-grid">
                        <div class="stat-card"><div class="stat-number" id="totalProductsStat">0</div><div>Total Products</div></div>
                        <div class="stat-card"><div class="stat-number" id="lowStockStat">0</div><div>Low Stock</div></div>
                        <div class="stat-card"><div class="stat-number" id="totalValueStat">$0</div><div>Inventory Value</div></div>
                    </div>
                    <div class="stock-table"><h3 style="margin-bottom:20px; font-weight:600;">Recent Products</h3>
                        <table><thead><tr><th>Image</th><th>Name</th><th>Barcode</th><th>Price</th><th>Stock</th><th></th></tr></thead><tbody id="recentList"></tbody></table>
                    </div>
                </div>

                <div id="scanPage" style="display:none;">
                    <div class="scanner-section">
                        <h3 style="margin-bottom:16px;"><i class="fas fa-qrcode"></i> Barcode Scanner</h3>
                        <div class="upload-area" id="dropZone">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: var(--light-sage); margin-bottom: 12px;"></i>
                            <p style="margin-bottom: 15px; color: var(--text-soft);">Click or drag & drop image</p>
                            <input type="file" id="qrImageInput" accept="image/jpeg, image/png, image/jpg" style="display:none;" />
                            <div class="upload-label" onclick="document.getElementById('qrImageInput').click()"><i class="fas fa-folder-open"></i> Select Image</div>
                        </div>
                        <div id="imagePreviewContainer" style="display:none; text-align: center;"><img id="uploadPreview" class="preview-img" /><div style="margin-top:15px;"><button id="detectFromImageBtn" class="detect-btn"><i class="fas fa-search"></i> Scan Barcode</button><button onclick="resetScan()" class="detect-btn" style="background:#6c7a6e; margin-left:10px;"><i class="fas fa-times"></i> Clear</button></div></div>
                        <div id="scannerStatus" style="display:none;"></div>
                        <div class="scan-tip"><i class="fas fa-lightbulb"></i> <strong>How to scan:</strong><br>• Upload clear barcode image (UPC, EAN, Code 128, QR)<br>• Ensure well-lit & focused • Auto-detection</div>
                        <div style="margin-top:24px;"><h4><i class="fas fa-keyboard"></i> Manual Entry</h4>
                        <input type="text" id="manualBarcode" placeholder="Type barcode number manually" style="width:100%; padding:14px; border-radius:60px; border:1px solid var(--border-light); background:var(--card-bg); color:var(--text-dark);">
                        <button class="save-btn" onclick="manualSubmit()" style="margin-top:12px; background:var(--dark-olive);"><i class="fas fa-search"></i> Lookup Product</button></div>
                    </div>
                    <div id="productDetail" class="product-detail-card" style="display:none;"><h3><i class="fas fa-box"></i> Product Details</h3><div id="detailImageContainer" style="text-align:center; margin-bottom:16px;"></div><div class="detail-row"><div class="detail-label">Barcode:</div><div class="detail-value barcode-value" id="detailBarcode"></div></div><div class="detail-row"><div class="detail-label">Name:</div><div class="detail-value" id="detailName"></div></div><div class="detail-row"><div class="detail-label">Category:</div><div class="detail-value" id="detailCategory"></div></div><div class="detail-row"><div class="detail-label">Price:</div><div class="detail-value" id="detailPrice"></div></div><div class="detail-row"><div class="detail-label">Stock:</div><div class="detail-value" id="detailStock"></div></div><div class="detail-row"><div class="detail-label">Description:</div><div class="detail-value" id="detailDesc"></div></div><div style="display:flex; gap:12px; margin-top:24px;"><button class="save-btn" onclick="editCurrentProduct()">Edit Product</button><button class="save-btn cancel-btn" onclick="resetScan()">Scan Another</button></div></div>
                    <div id="productForm" class="product-form"><h3><i class="fas fa-plus-circle"></i> Add New Product</h3><div class="form-group"><label>Barcode *</label><input type="text" id="productBarcode" readonly style="background:var(--border-light); font-family:monospace;"></div><div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;"><div class="form-group"><label>Product Name *</label><input type="text" id="productName" placeholder="Enter product name"></div><div class="form-group"><label>Category</label><select id="productCategory"><option>Electronics</option><option>Clothing</option><option>Food</option><option>Furniture</option><option>Office</option><option>Other</option></select></div></div><div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;"><div class="form-group"><label>Price *</label><input type="number" id="productPrice" placeholder="0.00" step="0.01"></div><div class="form-group"><label>Quantity *</label><input type="number" id="productQuantity" placeholder="0"></div></div><div class="form-group"><label>Product Image (Optional)</label><div class="image-upload-area" onclick="document.getElementById('productImageInput').click()"><i class="fas fa-cloud-upload-alt" style="font-size:28px;"></i><p style="margin-top:6px;">Click to upload JPG/PNG</p></div><input type="file" id="productImageInput" accept="image/jpeg, image/png, image/jpg" style="display:none;"><div id="productImagePreview" style="text-align:center; margin-top:12px;"></div></div><div class="form-group"><label>Description</label><textarea id="productDescription" rows="2" placeholder="Product description..."></textarea></div><button class="save-btn" onclick="saveNewProduct()">Save Product</button><button class="save-btn cancel-btn" onclick="resetScan()">Cancel</button></div>
                </div>

                <div id="stockPage" style="display:none;"><div class="stock-table"><div style="display:flex; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap;"><h3>All Products</h3><input type="text" id="searchStock" placeholder="Search by name or barcode..."></div><table><thead><tr><th>Image</th><th>Name</th><th>Barcode</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead><tbody id="stockList"></tbody></table></div></div>

                <div id="settingsPage" style="display:none;"><div class="product-form" style="display:block;"><h3>Settings</h3><div class="form-group"><label>Low Stock Threshold</label><input type="number" id="stockThreshold" value="10"></div><div class="form-group"><label><i class="fas fa-palette"></i> Theme</label><select id="themeSelect"><option value="light">☀️ Light Mode</option><option value="dark">🌙 Dark Mode</option></select></div><button class="save-btn" onclick="saveSettings()">Save Settings</button></div></div>
            </div>
        </div>
    </div>
</div>
<div class="toast-shelf" id="toastContainer"></div>

<script>
    let products = JSON.parse(localStorage.getItem('inventory')) || [
        { id:'PRD001', name:'MacBook Pro', category:'Electronics', price:1999.99, quantity:8, description:'', qrData:'https://example.com/macbook', imageData: null },
        { id:'PRD002', name:'Logitech Mouse', category:'Electronics', price:89.99, quantity:45, description:'', qrData:'8901234567891', imageData: null },
        { id:'PRD003', name:'Keychron Keyboard', category:'Electronics', price:129.99, quantity:3, description:'', qrData:'8901234567892', imageData: null }
    ];
    let settings = JSON.parse(localStorage.getItem('settings')) || { stockThreshold:10, theme:'light' };
    let currentScannedBarcode = '';
    let selectedImageFile = null;
    let zxingBrowserReader = null;
    let currentProductImageData = null;
    let isEditing = false;

    function applyTheme(theme) { if (theme === 'dark') document.body.classList.add('dark'); else document.body.classList.remove('dark'); if(document.getElementById('themeSelect')) document.getElementById('themeSelect').value = theme; }
    applyTheme(settings.theme);
    function toggleTheme() { let newTheme = settings.theme === 'light' ? 'dark' : 'light'; settings.theme = newTheme; localStorage.setItem('settings', JSON.stringify(settings)); applyTheme(newTheme); showToast(newTheme === 'dark' ? 'Dark mode enabled' : 'Light mode enabled'); }
    function showToast(msg, type = 'success') { let toast = document.createElement('div'); toast.className = 'toast-fresh'; toast.style.background = type === 'error' ? '#e74c3c' : '#7cb342'; toast.innerText = msg; document.getElementById('toastContainer').appendChild(toast); setTimeout(() => toast.remove(), 3000); }
    function login() { let user = document.getElementById('username').value; let pass = document.getElementById('password').value; if ((user === 'carl panganiban' && pass === 'carlpogi04') || (user === 'dionisiotzy' && pass === 'rayzelcute05')) { document.getElementById('loginPage').style.display = 'none'; document.getElementById('dashboard').style.display = 'block'; document.getElementById('usernameDisplay').innerText = user; updateStats(); renderStock(); showToast('Welcome ' + user); } else { document.getElementById('loginError').innerText = 'Invalid credentials'; } }
    function logout() { document.getElementById('dashboard').style.display = 'none'; document.getElementById('loginPage').style.display = 'flex'; resetScan(); }
    const productImageInput = document.getElementById('productImageInput'); const productImagePreview = document.getElementById('productImagePreview');
    productImageInput.addEventListener('change', (event) => { const file = event.target.files[0]; if (file && (file.type.match('image/jpeg') || file.type.match('image/png'))) { const reader = new FileReader(); reader.onload = (e) => { currentProductImageData = e.target.result; productImagePreview.innerHTML = `<div><img src="${currentProductImageData}" class="product-image-preview"><br><button class="remove-image-btn" onclick="removeProductImage()" style="background:#e74c3c; border:none; padding:4px 12px; border-radius:40px; margin-top:6px;"><i class="fas fa-trash"></i> Remove</button></div>`; }; reader.readAsDataURL(file); } else { showToast('Select valid JPG/PNG', 'error'); } });
    function removeProductImage() { currentProductImageData = null; productImageInput.value = ''; productImagePreview.innerHTML = ''; }
    const fileInput = document.getElementById('qrImageInput'); const previewContainer = document.getElementById('imagePreviewContainer'); const previewImg = document.getElementById('uploadPreview'); const detectBtn = document.getElementById('detectFromImageBtn'); const statusDiv = document.getElementById('scannerStatus'); const dropZone = document.getElementById('dropZone');
    zxingBrowserReader = new ZXing.BrowserMultiFormatReader(); zxingBrowserReader.timeBetweenDecodingAttempts = 100;
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('drag-over'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', (e) => { e.preventDefault(); dropZone.classList.remove('drag-over'); const file = e.dataTransfer.files[0]; if (file && (file.type.match('image/jpeg') || file.type.match('image/png'))) handleImageFile(file); else showToast('Drop JPG/PNG image', 'error'); });
    fileInput.addEventListener('change', (event) => { if(event.target.files[0]) handleImageFile(event.target.files[0]); });
    function handleImageFile(file) { if (!file.type.match('image/jpeg') && !file.type.match('image/png')) { showToast('Only JPG/PNG allowed', 'error'); fileInput.value = ''; return; } selectedImageFile = file; const reader = new FileReader(); reader.onload = (e) => { previewImg.src = e.target.result; previewContainer.style.display = 'block'; statusDiv.style.display = 'block'; statusDiv.className = 'scanner-status info'; statusDiv.innerHTML = '<i class="fas fa-info-circle"></i> Image loaded. Click "Scan Barcode".'; }; reader.readAsDataURL(file); }
    async function detectCodeFromImage() { if (!selectedImageFile) { showToast('Select image first', 'error'); return; } statusDiv.style.display = 'block'; statusDiv.className = 'scanner-status info'; statusDiv.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Scanning...'; try { const img = await createImageElement(selectedImageFile); const result = await zxingBrowserReader.decodeFromImageElement(img); if (result && result.text && result.text.trim() !== "") { const decodedText = result.text.trim(); statusDiv.className = 'scanner-status success'; statusDiv.innerHTML = `<i class="fas fa-check-circle"></i> ✓ Barcode: ${decodedText}`; showToast(`Barcode detected: ${decodedText}`, 'success'); processBarcode(decodedText); } else throw new Error("No barcode"); } catch (error) { statusDiv.className = 'scanner-status error'; statusDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ✗ Could not detect barcode. Try clearer image.'; showToast('No barcode detected', 'error'); } }
    function createImageElement(file) { return new Promise((resolve, reject) => { const img = new Image(); img.onload = () => resolve(img); img.onerror = reject; img.src = URL.createObjectURL(file); }); }
    detectBtn.addEventListener('click', detectCodeFromImage);
    function resetScan() { fileInput.value = ''; selectedImageFile = null; previewContainer.style.display = 'none'; previewImg.src = ''; statusDiv.style.display = 'none'; document.getElementById('productDetail').style.display = 'none'; document.getElementById('productForm').style.display = 'none'; document.getElementById('manualBarcode').value = ''; currentScannedBarcode = ''; currentProductImageData = null; productImageInput.value = ''; productImagePreview.innerHTML = ''; isEditing = false; }
    function manualSubmit() { let barcode = document.getElementById('manualBarcode').value.trim(); if(barcode) { statusDiv.style.display = 'block'; statusDiv.className = 'scanner-status success'; statusDiv.innerHTML = `<i class="fas fa-check-circle"></i> Barcode entered: ${barcode}`; processBarcode(barcode); } else showToast('Enter barcode', 'error'); }
    function processBarcode(barcode) { currentScannedBarcode = barcode; let existingProduct = products.find(p => p.qrData === barcode); if (existingProduct) showProductDetails(existingProduct); else showAddProductForm(barcode); }
    function showProductDetails(product) { document.getElementById('productForm').style.display = 'none'; document.getElementById('productDetail').style.display = 'block'; const imgC = document.getElementById('detailImageContainer'); imgC.innerHTML = product.imageData ? `<img src="${product.imageData}" class="detail-image" alt="${product.name}">` : '<div style="background: var(--border-light); padding: 18px; border-radius: 20px;"><i class="fas fa-image" style="font-size: 40px;"></i><p>No image</p></div>'; document.getElementById('detailBarcode').innerText = product.qrData; document.getElementById('detailName').innerText = product.name; document.getElementById('detailCategory').innerText = product.category; document.getElementById('detailPrice').innerText = '$' + product.price.toFixed(2); document.getElementById('detailStock').innerHTML = `<span style="color: ${product.quantity < settings.stockThreshold ? '#e74c3c' : '#27ae60'}">${product.quantity}</span>`; document.getElementById('detailDesc').innerText = product.description || 'No description'; showToast(`Product: ${product.name}`, 'success'); }
    function showAddProductForm(barcode) { document.getElementById('productDetail').style.display = 'none'; document.getElementById('productForm').style.display = 'block'; document.getElementById('productBarcode').value = barcode; document.getElementById('productName').value = ''; document.getElementById('productPrice').value = ''; document.getElementById('productQuantity').value = ''; document.getElementById('productDescription').value = ''; document.getElementById('productCategory').value = 'Electronics'; currentProductImageData = null; productImageInput.value = ''; productImagePreview.innerHTML = ''; isEditing = false; showToast('Fill details for new product', 'info'); }
    function editCurrentProduct() { let product = products.find(p => p.qrData === currentScannedBarcode); if(product) { document.getElementById('productBarcode').value = product.qrData; document.getElementById('productName').value = product.name; document.getElementById('productCategory').value = product.category; document.getElementById('productPrice').value = product.price; document.getElementById('productQuantity').value = product.quantity; document.getElementById('productDescription').value = product.description || ''; currentProductImageData = product.imageData || null; if(currentProductImageData) productImagePreview.innerHTML = `<div><img src="${currentProductImageData}" class="product-image-preview"><br><button class="remove-image-btn" onclick="removeProductImage()" style="background:#e74c3c; border:none; border-radius:40px; padding:4px 12px;">Remove</button></div>`; else productImagePreview.innerHTML = ''; document.getElementById('productDetail').style.display = 'none'; document.getElementById('productForm').style.display = 'block'; isEditing = true; } }
    function saveNewProduct() { let barcode = document.getElementById('productBarcode').value; let name = document.getElementById('productName').value.trim(); let category = document.getElementById('productCategory').value; let price = parseFloat(document.getElementById('productPrice').value); let quantity = parseInt(document.getElementById('productQuantity').value); let description = document.getElementById('productDescription').value; if(!name || isNaN(price) || isNaN(quantity)) { showToast('Name, price and quantity required', 'error'); return; } if(isEditing) { let idx = products.findIndex(p => p.qrData === barcode); if(idx!==-1) { products[idx] = {...products[idx], name, category, price, quantity, description, imageData: currentProductImageData || products[idx].imageData}; localStorage.setItem('inventory', JSON.stringify(products)); updateStats(); renderStock(); showToast('Product updated', 'success'); resetScan(); } } else { if(products.find(p=>p.qrData===barcode)) { showToast('Product exists!', 'error'); resetScan(); return; } let id = 'PRD' + String(products.length+1).padStart(3,'0'); products.push({id, name, category, price, quantity, description, qrData:barcode, imageData: currentProductImageData || null}); localStorage.setItem('inventory', JSON.stringify(products)); updateStats(); renderStock(); showToast('Product added', 'success'); resetScan(); } }
    function updateStats() { let total=products.length, low=products.filter(p=>p.quantity<settings.stockThreshold).length, value=products.reduce((s,p)=>s+(p.price*p.quantity),0); document.getElementById('totalProductsStat').innerText=total; document.getElementById('lowStockStat').innerText=low; document.getElementById('totalValueStat').innerText='$'+value.toFixed(2); let recent=products.slice(-5).reverse(); document.getElementById('recentList').innerHTML=recent.map(p=>`<tr><td>${p.imageData?`<img src="${p.imageData}" class="product-thumb">`:'<i class="fas fa-image"></i>'}</td><td>${p.name}</td><td>${p.qrData.substring(0,18)}</td><td>$${p.price}</td><td>${p.quantity}</td><td class="action-icons"><i class="fas fa-edit" onclick="editProductById('${p.id}')"></i></td></tr>`).join(''); }
    function editProductById(id) { let p=products.find(p=>p.id===id); if(p) { currentScannedBarcode=p.qrData; showPage('scanPage'); setTimeout(()=>showProductDetails(p),100); } }
    function renderStock() { let search=document.getElementById('searchStock')?.value.toLowerCase()||''; let filtered=products.filter(p=>p.name.toLowerCase().includes(search)||p.qrData.includes(search)); document.getElementById('stockList').innerHTML=filtered.map(p=>`<tr><td>${p.imageData?`<img src="${p.imageData}" class="product-thumb">`:'<i class="fas fa-image"></i>'}</td><td>${p.name}</td><td>${p.qrData}</td><td>${p.category}</td><td>$${p.price}</td><td style="color:${p.quantity<settings.stockThreshold?'#e74c3c':'#27ae60'}">${p.quantity}</td><td class="action-icons"><i class="fas fa-edit" onclick="editProductById('${p.id}')"></i><i class="fas fa-trash" onclick="deleteProduct('${p.id}')"></i></td></tr>`).join(''); }
    function deleteProduct(id) { if(confirm('Delete permanently?')) { products=products.filter(p=>p.id!==id); localStorage.setItem('inventory',JSON.stringify(products)); updateStats(); renderStock(); showToast('Deleted'); } }
    function saveSettings() { settings.stockThreshold=parseInt(document.getElementById('stockThreshold').value); settings.theme=document.getElementById('themeSelect').value; localStorage.setItem('settings',JSON.stringify(settings)); applyTheme(settings.theme); updateStats(); renderStock(); showToast('Settings saved'); }
    function showPage(page) { document.querySelectorAll('.sidebar-item').forEach(i=>i.classList.remove('active')); if(event?.target){ let t=event.target.closest('.sidebar-item'); if(t) t.classList.add('active'); } else { const items=document.querySelectorAll('.sidebar-item'); if(page==='dashboardPage') items[0].classList.add('active'); else if(page==='scanPage') items[1].classList.add('active'); else if(page==='stockPage') items[2].classList.add('active'); else items[3].classList.add('active'); } ['dashboardPage','scanPage','stockPage','settingsPage'].forEach(p=>document.getElementById(p).style.display='none'); document.getElementById(page).style.display='block'; if(page==='scanPage') resetScan(); if(page==='stockPage') renderStock(); }
    document.getElementById('searchStock')?.addEventListener('keyup',()=>renderStock()); if(document.getElementById('stockThreshold')) document.getElementById('stockThreshold').value=settings.stockThreshold; updateStats(); renderStock();
</script>
</body>
</html>
