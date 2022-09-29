<?php
	namespace App\Controllers;

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;
	use App\Models\DB\admin;

	class AuthController
	{
		public function login(ServerRequestInterface $request, ResponseInterface $response){
			$data = json_decode($request -> getbody() -> getcontents(),true);
			$user = admin::where("account", "=", $data["account"])->first(["id", "name"]);
            if ($user -> id != null){
                print_r($user);
                if ($user -> check_password($data["password"])){
                    $jwt_data = [
                        "id" => $user->id,
                        "name" => $user->name,
                        "iat" => time(),
                        "exp" => time()+300
                    ];
                    $jwtToken = JWT::encode($jwt_data, $_ENV["JWT_SECRET"], 'HS256');
                    $response -> getBody() -> write(json_encode(["token"=> $jwtToken]));
                    return $response ->withHeader('content-type', 'application/json') -> withStatus(200);
                }else{
                    $response -> getBody() -> write(json_encode(["Status"=> "Password incorrect!"]));
                    return $response -> withHeader("content-type", "applocation/json") -> withStatus(403);
                }
            }else{
                $response -> getBody() -> write(json_encode(["Status"=> "account not found!"]));
                return $response->withHeader('content-type', 'application/json') -> withStatus(403);
            }
		}

        public function verify(ServerRequestInterface $request, ResponseInterface $response){
			if(!isset($request->getHeader("Authorization")[0])){
                $response->getBody()->write(json_encode([
                    "message" => "No token provided!"
                ]));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(403);
            }
            $jwtToken = str_replace("Bearer ", "", $request->getHeader("Authorization")[0]);
            try {
                $jwtBody = JWT::decode($jwtToken, new Key($_ENV["JWT_SECRET"], 'HS256'));
                $response -> getBody() -> write(json_encode(["Status" => "Success"]));
                return $response ->withHeader('content-type', 'application/json')
                ->withStatus(200);
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode([
                    "message" => "Token is invalid!",
                ]));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(400);
            }
		}
	}
?>
