<?php

use App\Infrastructure\Order\InMemoryOrderRepository;
use App\Application\Order\CreateOrderService;
use App\Interfaces\Http\Controllers\OrderController;

require __DIR__ . '/../vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/orders' && $method === 'POST') {
    $repo = new InMemoryOrderRepository();
    $service = new CreateOrderService($repo);
    $controller = new OrderController($service);
    $controller->create();
} else {
    http_response_code(404);
    echo "Pls use curl to test this:  <br>"; ?>

    <p>Example to create Order:</p>
    <p style="background-color: #000; color: #fff; padding: 5px 15px;">
         curl -X POST http://localhost:8000/orders \
        -H "Content-Type: application/json" \
        -d '{"title": "Test Order", "description": "Test description"}'
    </p>
<?php }
