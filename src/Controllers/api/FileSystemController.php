<?php 

namespace App\Controllers\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class FileSystemController extends BaseController
{
	public function upload(Request $request, Response $response, $args)  
	{
		$content = file_get_contents('php://input');
		$flysystem = $this->fs;
		$nama_file = md5("Y-m-d H:i:s") . uniqid(). "1.jpg";
		$flysystem->write('images/' . $nama_file, $content);
 		$base = $request->getUri()->getBaseUrl();
		return $this->responseDetail(200, 'Berhasil upload image', [
				'result' => $base . "/assets/images/" . $nama_file
			]);
	}
}

 ?>