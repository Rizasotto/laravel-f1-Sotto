<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .success-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 500px;
            text-align: center;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        
        .checkmark svg {
            width: 50px;
            height: 50px;
            stroke: white;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .checkmark-line {
            animation: lineAnimation 0.6s ease-out 0.3s both;
        }
        
        @keyframes lineAnimation {
            from {
                stroke-dasharray: 50;
                stroke-dashoffset: 50;
            }
            to {
                stroke-dasharray: 50;
                stroke-dashoffset: 0;
            }
        }
        
        h1 {
            font-size: 28px;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .subtitle {
            font-size: 16px;
            color: #10b981;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .amount-box {
            background: #f3f4f6;
            border-left: 4px solid #10b981;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .amount-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .amount {
            font-size: 36px;
            color: #10b981;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .shop-name {
            font-size: 16px;
            color: #374151;
            font-weight: 600;
        }
        
        .order-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #6b7280;
        }
        
        .order-info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        
        .order-info-label {
            font-weight: 600;
            color: #374151;
        }
        
        .order-info-value {
            color: #10b981;
            font-family: 'Courier New', monospace;
        }
        
        .message {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .timer {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 20px;
        }
        
        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        a, button {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #10b981;
            color: white;
        }
        
        .btn-primary:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background: #d1d5db;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <!-- Checkmark Animation -->
        <div class="checkmark">
            <svg viewBox="0 0 24 24">
                <polyline class="checkmark-line" points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <!-- Success Message -->
        <h1>Payment Successful!</h1>
        <p class="subtitle">✓ Your payment has been confirmed</p>
        
        <!-- Amount Display -->
        <div class="amount-box">
            <div class="amount-label">Amount Paid</div>
            <div class="amount">₱{{ number_format($amount, 2) }}</div>
            <div class="shop-name">ARTCONNECT SHOP</div>
        </div>
        
        <!-- Order Information -->
        <div class="order-info">
            <div class="order-info-row">
                <span class="order-info-label">Order Number:</span>
                <span class="order-info-value">{{ $order->order_number }}</span>
            </div>
            <div class="order-info-row">
                <span class="order-info-label">Reference:</span>
                <span class="order-info-value">{{ $referenceNumber }}</span>
            </div>
            <div class="order-info-row">
                <span class="order-info-label">Items:</span>
                <span class="order-info-value">{{ $order->orderItems->count() }}</span>
            </div>
        </div>
        
        <!-- Message -->
        <p class="message">
            Your order has been confirmed and you'll receive an SMS confirmation. Your items will be processed for shipment shortly.
        </p>
        
        <!-- Timer -->
        <div class="timer">
            Redirecting in <span id="countdown">3</span> seconds...
        </div>
        
        <!-- Action Buttons -->
        <div class="button-group">
            <a href="{{ route('order.show', $order) }}" class="btn-secondary">View Order</a>
            <a href="{{ route('order.index') }}" class="btn-primary">Go to Orders</a>
        </div>
    </div>
    
    <script>
        // Auto-redirect countdown
        let timeLeft = 3;
        const countdownEl = document.getElementById('countdown');
        
        const interval = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('order.show', $order) }}";
            }
        }, 1000);
    </script>
</body>
</html>
