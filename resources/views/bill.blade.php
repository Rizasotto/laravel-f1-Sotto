<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>electric Bill</title>
</head>
<body>
    <div>
        <h1>electricity Bill</h1>
        <p>customerName: {{$bill['customer_name']}}</p>
        <p>customerType: {{$bill['customer_type']}}</p>
        <p>consumption: {{$bill['consumption_kWh']}} kWh</p>
        <p>baseBill: {{$bill['base_bill']}}</p>
        <p>totalBill: {{$bill['total_bill']}} </p>
    </div>
</body>
</html>