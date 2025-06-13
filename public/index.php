<?php

use App\Application\Order\DeleteOrderService;
use App\Application\Order\ListOrdersService;
use App\Infrastructure\Order\JsonOrderRepository;
use App\Application\Order\CreateOrderService;
use App\Interfaces\Http\Controllers\OrderController;

require_once __DIR__ . '/../config/constants.php';
require __DIR__ . '/../vendor/autoload.php';

$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ( $uri === '/orders' && $method === 'POST' ) {
	$repo       = new JsonOrderRepository();
	$create     = new CreateOrderService( $repo );
	$list       = new ListOrdersService( $repo );
	$controller = new OrderController( $create, $list );
	$controller->create();

} elseif ( $uri === '/orders' && $method === 'GET' ) {
	$repo       = new JsonOrderRepository();
	$create     = new CreateOrderService( $repo );
	$list       = new ListOrdersService( $repo );
	$controller = new OrderController( $create, $list );
	$controller->list();

} elseif ( $uri === '/' && $method === 'GET' ) {
	?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order App</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 2rem;
                background-color: #f4f4f4;
                color: #333;
            }

            h1 {
                margin-bottom: 1rem;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                background: #fff;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            pre {
                background: #272822;
                color: #f8f8f2;
                padding: 1rem;
                border-radius: 5px;
                overflow-x: auto;
            }

            input, textarea {
                width: 100%;
                padding: 0.5rem;
                margin-bottom: 1rem;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 1rem;
            }

            button {
                padding: 0.5rem 1rem;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 4px;
                font-size: 1rem;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>Order Management</h1>

        <h2>Create Order via Form</h2>
        <form action="/orders" method="post">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <button type="submit">Create Order</button>
        </form>

        <h2>Create Order via CURL</h2>
        <pre>
curl -X POST http://localhost:8000/orders \
     -H "Content-Type: application/json" \
     -d '{"title": "Test Order", "description": "Test description"}'
        </pre>

        <h2>View Orders</h2>
        <p><a href="/orders">Click here to view all orders</a></p>
    </div>
    </body>
    </html>
	<?php
} elseif ( preg_match( '#^/orders/delete/([a-zA-Z0-9\-]+)$#', $uri, $matches ) && $method === 'GET' ) {
	$id         = $matches[1];
	$repo       = new JsonOrderRepository();
	$create     = new CreateOrderService( $repo );
	$list       = new ListOrdersService( $repo );
	$delete     = new DeleteOrderService( $repo );
	$controller = new OrderController( $create, $list, $delete );
	$controller->delete( $id );
}