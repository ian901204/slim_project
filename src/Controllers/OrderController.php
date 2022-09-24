<?php
	namespace App\Controllers;

	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;
	use App\Models\DB\Order;

	class OrderController
	{
		public function add(ServerRequestInterface $request, ResponseInterface $response){
			$data = json_decode($request -> getbody() -> getcontents(),true);
			$order = Order:: create(
				[
					"client_name" => $data["name"],
					"client_phone" => $data["phone"],
					"order_address" => $data["address"],
					"product_size" => $data["size"],
					"product_amount" => $data["amount"],
					"seller_id" => $data["seller"]
				]);
			$order -> save();
			$response -> getBody() -> write(json_encode(["Status"=> "Success", "id" => $order -> id]));
			return $response -> withStatus(200);
		}

		public function list(ServerRequestInterface $request, ResponseInterface $response){
			$order = Order::get();
			$order_data = [];
			foreach($order as $data){
				array_push($order_data, ["order_id" => $order_data -> getKey(), "client_name" => $data -> client_name, "product_size" => $data -> product_size, "product_amount" => $data -> product_amount]);
			}
			$response -> getBody() -> write(include __DIR__."/../backend/order.php");
			return $response -> withStatus(200);
		}
	}
?>
