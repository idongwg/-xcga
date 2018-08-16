<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ZipArchive;

class UploadFileApiController extends Controller
{

	protected $field = 'file';

	public function __construct()
	{
	}

	public function index()
	{
		return $this->upload(request());
	}

	public function store(Request $request)
	{
		return $this->upload($request);
	}

	public function upload(Request $request)
	{
		if ($request->hasFile($this->field)) {
			$file = $request->file($this->field);
			if ($file->isValid()) {
				$file_name = $file->getClientOriginalName();
				$file_path = 'uploads/' . date('Y-m-d') . '/';

				$real_path = public_path($file_path);
				if (!file_exists($real_path)) {
					if (!mkdir($real_path, 0777, true)) {
						return false;
					}
				}

				//$uploaded = $file->store('images');
				$uploaded = $file->move($real_path, $file_name);
				if ($uploaded) {
					$zip = new ZipArchive();
					if ($zip->open($real_path . $file_name) === true) {
						$zip->extractTo($real_path);
						$zip->close();
						@unlink($real_path . $file_name);

						return $this->success(array('uploaded_file' => $file_name));
					} else {
						//@unlink ($real_path . $file_name);
					}
				}
            }

		return $this->error(array(), "提交的上传文件无效");
	}
return $this->error(array(), "没有提交上传文件");
}

}