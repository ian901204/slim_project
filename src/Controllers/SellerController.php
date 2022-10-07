<?php
	namespace App\Controllers;

	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;
	use App\Models\DB\sellers;
	class SellerController
	{
		public function add(ServerRequestInterface $request, ResponseInterface $response){
			$data = json_decode($request -> getbody() -> getcontents(),true);
			$seller = sellers::create(
				[
                    "name" => $data["name"],
                    "phone" => $data["phone"]
				]);
			$seller -> save();
			$response -> getBody() -> write(json_encode(["Status"=> "Success", "id" => $seller -> id]));
			return $response -> withStatus(200);
		}

		public function list(ServerRequestInterface $request, ResponseInterface $response){
			$seller_data = sellers::get(["id", "name", "phone"]);
			include __DIR__."/../../backend/seller.php";
			return $response -> withStatus(200);
		}

		public function get(ServerRequestInterface $request, ResponseInterface $response, array $args){
			try{
				$seller_data = sellers::where("id", "=", $args["id"])->first(["id", "name", "phone"]);
			}catch(\Exception $e){
				$response -> getBody() -> write(json_encode(["Status" => "failed!"]));
				return $response -> withStatus(400);
			}
			include __DIR__."/../../backend/seller_detail.php";
			return $response -> withStatus(200);
		}

		public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args){
			try{
				$order_data = sellers::where("id", "=", $args["id"])->delete();
			}catch(\Exception $e){
				$response -> getBody() -> write(json_encode(["Status" => "failed!"]));
				return $response -> withStatus(400);
			}
			$response -> getBody() -> write(json_encode(["Status" => "Success"]));
			return $response -> withStatus(200);
		}
	}
?>